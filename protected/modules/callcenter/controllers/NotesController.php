<?php

class NotesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			['allow',
				'actions' => ['create', 'update', 'admin', 'delete'],
				'roles' => ['canAdminNotes'],
			],
			['deny',  // deny all users
				'users' => ['*'],
			],
		];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Notes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notes'])) {
			$model->attributes = $_POST['Notes'];
			if ($model->save())
				$this->redirect(['admin']);
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

		Yii::app()->getClientScript()->registerCoreScript('jquery');
		Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
		Yii::app()->getClientScript()->registerScriptFile('/js/notes.js');
		Yii::app()->getClientScript()->registerScriptFile('/js/angular.min.js');
		Yii::app()->getClientScript()->registerScriptFile('/js/angular/ng-sortable.js');

		$model = $this->loadModel($id);

		if (isset($_POST['Notes'])) {
			$model->attributes = $_POST['Notes'];
			if ($model->save()) {
				if (array_key_exists('fields', $_POST['Notes'])) {
					$model->saveFields($_POST['Notes']['fields']);
				}
				$this->redirect(['admin']);
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Notes('search');
		$model->with('group');
		$model->together();
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Notes']))
			$model->attributes = $_GET['Notes'];

		$this->render('admin', [
			'model' => $model,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Notes::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'notes-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
