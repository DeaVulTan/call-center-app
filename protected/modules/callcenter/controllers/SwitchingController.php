<?php

class SwitchingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'admin';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','group','import'),
				'roles'=>array('manageSwitchings'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('*'),
				'roles'=>array('admin'),
			),
			array('deny', // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionGroup()
	{
		$model = Switching::model();
		$groups = CHtml::listData(Group::model()->findAllByAttributes(array('deleted' => 0)), 'id', 'name');
		if(isset($_POST['Switching']))
		{
			$post = $_POST['Switching'];
			if (!empty($post['group_id']))
				$model->updateAll(array('prefix' => $post['prefix'], 'timeout' => intval($post['timeout'])), 'group_id = ?', array($post['group_id']));
			$this->redirect(array('admin'));
		}
		$this->render('group', array(
			'model' => $model,
			'groups' => $groups,
		));
	}

	public function actionImport()
	{
		$model = Switching::model();
		if(isset($_POST['Switching']))
		{
			$file = CUploadedFile::getInstance($model,'import_file');
			if (!empty($file)) {
				$handle = @fopen(CUploadedFile::getInstance($model,'import_file')->tempName, "r");
				if ($handle) {
					while (($line = fgets($handle, 4096)) !== false) {
						if (mb_convert_encoding($line, 'UTF-8', 'UTF-8') != $line) {
							$line = mb_convert_encoding($line, 'UTF-8', 'CP1251');
						}
						if (!empty($line) && strlen(trim($line)) > 0) {
							$data = explode(';', $line);
							if (count($data) != 6) {
								continue;
							}
							// if group is not found, then not write with line
							$group = Group::model()->findByAttributes(array('name' => $data[2]));
							if ($group == null) {
								continue;
							}
							$attributes = array(
								'prefix'   => trim($data[0]),
								'number'   => trim($data[1]),
								'group_id' => $group->id,
								'name'	 => trim($data[3]),
								'timeout'  => trim($data[4]),
								'addition' => trim($data[5]),
							);
							$switching = new Switching;
							if ($switching->findByAttributes($attributes) != null) {
								continue;
							}
							$switching->prefix = trim($data[0]);
							$switching->number = trim($data[1]);
							$switching->group_id = $group->id;
							$switching->name = trim($data[3]);
							$switching->timeout = trim($data[4]);
							$switching->addition = trim($data[5]);
							$switching->save();
						}
					}
					fclose($handle);
				}
				$this->redirect(array('admin'));
			} else {
				Yii::app()->user->setFlash('error', 'Ошибка импорта');
			}
		}
		$this->render('import', array('model'=>$model));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Switching;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Switching']))
		{
			$model->attributes=$_POST['Switching'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Switching']))
		{
			$model->attributes=$_POST['Switching'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Switching');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Switching('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Switching']))
			$model->attributes=$_GET['Switching'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Switching the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Switching::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Switching $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='switching-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
