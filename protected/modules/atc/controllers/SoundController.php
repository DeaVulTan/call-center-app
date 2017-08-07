<?php

class SoundController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return [
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		];
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return [
			['allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => ['admin', 'delete', 'download', 'mohlist', 'createmohdir', 'updatemohdir', 'deletemohdir', 'viewmohfile', 'create', 'update'],
				'roles' => ['manageTE'],
			],
			['deny',  // deny all users
				'users' => ['*'],
			],
		];
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewMohFile($id)
	{
		$model = $this->loadModel($id, 'MOHFile');
		// $this->render('viewmohfile',array(
		// 	'model'=>$this->loadModel($id, 'MOHFile'),
		// ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Sound;

		// Uncomment the following line if AJAX validation is needed
//		$this->performAjaxValidation($model);

		if (isset($_POST['Sound'])) {
			$model->attributes = $_POST['Sound'];
			$fileDir = Yii::app()->params['soundsDir'] . DIRECTORY_SEPARATOR;
			$fileName = time() . Yii::app()->user->id . '.wav';
			if ($this->saveFile($model, $fileName, $fileDir)) {
				if ($model->save()) {
					$this->redirect(['admin']);
				}
			}
		}

		$this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
//		$this->performAjaxValidation($model);

		if (isset($_POST['Sound'])) {
			$model->attributes = $_POST['Sound'];
			$fileDir = Yii::app()->params['soundsDir'] . DIRECTORY_SEPARATOR;
			$fileName = time() . Yii::app()->user->id;
			if ($this->saveFile($model, $fileName, $fileDir)) {
				if ($model->save()) {
					$this->redirect(['admin']);
				}
			}
		}

		$this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $type = '')
	{
		$modelName = 'Sound';
		if ($type == 'moh') {
			$modelName = 'MOHFile';
		}
		$model = $this->loadModel($id, $modelName);
		if ($type == 'moh') {
			$file = $model->name;
		} else {
			$file = Yii::app()->params['soundsDir'] . DIRECTORY_SEPARATOR . $model->name . '.wav';
		}
		if (is_file($file)) {
			unlink($file);
		}
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Sound('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Sound']))
			$model->attributes = $_GET['Sound'];

		$this->render('admin', [
			'model' => $model,
		]);
	}

	/**
	 * Manages moh model
	 */
	public function actionMohlist()
	{
		$model = new Musiconhold('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Musiconhold']))
			$model->attributes = $_GET['Musiconhold'];

		$this->render('moh', [
			'model' => $model,
		]);
	}

	/**
	 * Create moh dir
	 */
	public function actionCreatemohdir()
	{
		$model = new Musiconhold;
		$this->performAjaxValidation($model);

		if (isset($_POST['Musiconhold'])) {
			$model->attributes = $_POST['Musiconhold'];
			$model->save();
			$model = Musiconhold::model()->find("var_val=:var_val and cat_metric=:cat_metric",
				['var_val' => $model->var_val, 'cat_metric' => $model->cat_metric]);
			$this->redirect(['updatemohdir', 'id' => $model->id]);
		}

		$this->render('createmohdir', [
			'model' => $model,
		]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatemohdir($id)
	{
		$model = $this->loadModel($id, 'Musiconhold');
		$filemodel = new MOHFile();

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['Musiconhold'])) {
			$model->attributes = $_POST['Musiconhold'];
			$model->save();
			$this->redirect(['mohlist']);
		}

		$this->performAjaxValidation($filemodel);
		if (isset($_POST['MOHFile'])) {
			$filemodel->attributes = $_POST['MOHFile'];
			$filemodel->context_id = $model->cat_metric;
			if ($this->saveFile($filemodel, '0-file_' . time() . '.wav', $model->getDir() . DIRECTORY_SEPARATOR)) {
				$filemodel->name = $model->getDir() . DIRECTORY_SEPARATOR . '0-file_' . time() . '.wav';
				$filemodel->save();
				$this->redirect(['updatemohdir', 'id' => $model->id]);
			} else {
				throw new Excepton();
			}
		}

		$this->render('updatemohdir', [
			'model' => $model, 'filemodel' => $filemodel
		]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletemohdir($id)
	{
		$model = $this->loadModel($id, 'Musiconhold');
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['mohlist']);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sound the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $modelName = 'Sound')
	{
		$model = $modelName::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	public function actionDownload($id, $type = '')
	{
		$modelName = 'Sound';
		if ($type == 'moh') {
			$modelName = 'MOHFile';
		}
		$model = $this->loadModel($id, $modelName);
		if ($type == 'moh') {
			$file = $model->name;
		} else {
			$file = Yii::app()->params['soundsDir'] . DIRECTORY_SEPARATOR . $model->name . '.wav';
		}
		if (is_file($file))
			Yii::app()->request->sendFile((($type == 'moh') ? $model->comment : $model->name) . '.wav', file_get_contents($file));
		else throw new CHttpException(404, 'File not found');
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sound $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'sound-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function saveFile($model, $filename = '', $fileDir = '')
	{
		try {
			$model->soundfile = CUploadedFile::getInstance($model, 'soundfile');
			if ($model->soundfile) {
				if ($model->soundfile->saveAs($fileDir . $filename)) {
					$this->convertFile($filename, $fileDir);
					if (is_file($fileDir . $model->name)) {
						unlink($fileDir . $model->name);
					}
					$model->name = $filename;
					return true;
				}
				return false;
			} else {
				return true;
			}
		} catch (Exception $e) {
			throw new Exception();
		}
	}

	protected function convertFile($filename, $fileDir)
	{
		system('chmod 777 /usr/bin/sox ' . $fileDir . $filename, $return);
		$command = '/usr/bin/sox -v 0.5 ' . $fileDir . $filename . ' -t wav -2 -r 8000 -c 1 ' . $fileDir . $filename . '.wav';
		system($command, $return);
		if (!$return) {
			unlink($fileDir . $filename);
		}
	}

}
