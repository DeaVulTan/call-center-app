<?php

class ExtnumberController extends Controller
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
			'postOnly + delete, getvalue', // we only allow deletion via POST request
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
			array('allow',
				'actions'=>array('index','view','admin','delete', 'getvalue','create','update'),
				'roles'=>array('manageTE'),
			),
			array('deny',  // deny all users
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ExtNumber;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ExtNumber']))
		{
			$model->attributes=$_POST['ExtNumber'];
            if (ExtNumber::model()->findByAttributes(array('number' => $model->number)) == null) {
                if($model->save())
                    $this->redirect(array('view','id'=>$model->id));
            }
            Yii::app()->user->setFlash('error','В системе уже есть указанный номер');
		}
		Yii::app()->getClientScript()->registerScriptFile('/js/extnumber.js');
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

		if(isset($_POST['ExtNumber']))
		{
			$model->attributes=$_POST['ExtNumber'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		Yii::app()->getClientScript()->registerScriptFile('/js/extnumber.js');
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
		$dataProvider=new CActiveDataProvider('ExtNumber');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ExtNumber('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExtNumber']))
			$model->attributes=$_GET['ExtNumber'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ExtNumber the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ExtNumber::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ExtNumber $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ext-number-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetValue() {
            $events = ExtNumber::model()->listEvents;
//            var_dump($_POST);
            $data = array('errors' => '-1');
            $fieldName = "ExtNumber[value]";
            $htmlParams = array('name' => $fieldName);
            if(in_array($_POST['event'], array_keys($events))) {
                $extNumber = ExtNumber::model();
                switch ($events[$_POST['event']]['type']) {
                    case 'text':
                        if(isset($_POST['selected'])) $htmlParams = array_merge($htmlParams, array('value' => $_POST['selected']));
                        $data = CHtml::activeTextField($extNumber, 'value', $htmlParams);
                        break;
                    case 'select':
                        if(isset($_POST['selected'])) {
                            $htmlParams = array_merge($htmlParams, array('options' => array(intval($_POST['selected']) => array('selected' => 'selected'))));
                        }

                        $attributes = array();
                        if ($_POST['event'] == 'group') {
                            $attributes = array(
                                'deleted' => 0
                            );
                        }

                        $data = CHtml::activeDropDownList($extNumber, 'value',
                                CHtml::listData($events[$_POST['event']]['model']::model()->findAllByAttributes($attributes),
                                        $events[$_POST['event']]['param']['id'],
                                        $events[$_POST['event']]['param']['name']), $htmlParams);
                        break;
                    case 'hidden':
                        $data = Yii::t('application', 'No params').CHtml::activeHiddenField($extNumber, 'value', array_merge($htmlParams,array('value'=>1)));
                        break;
                    default:
                        $data = CHtml::activeHiddenField($extNumber, 'value', array_merge($htmlParams,array('value'=>1)));
                        break;
                }
            }
            $dataArr = array('cell' => $data);
            echo json_encode($dataArr);
        }
}
