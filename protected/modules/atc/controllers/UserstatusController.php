<?php

class UserstatusController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return [
			'accessControl', // perform access control for CRUD operations
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
			['allow', // allow manageUsers role to perform all action
				'actions' => ['admin', 'delete', 'index', 'view', 'create', 'update'],
				'roles' => ['manageUsers'],
			],
			['deny',  // deny all users
				'users' => ['*'],
			],
		];
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view', [
			'model' => $this->loadModel(),
		]);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new UserStatus;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['UserStatus'])) {
			$model->attributes = $_POST['UserStatus'];

			if ($model->save()) {
				$uploadedFile = CUploadedFile::getInstance($model, 'icon');
				if (!empty($uploadedFile)) {
					$fileName = $model->id . '.' . end(explode(".", $uploadedFile));
					$filePath = Yii::app()->basePath . '/../images/user_status/' . $fileName;
					$model->icon = $fileName;
					$uploadedFile->saveAs($filePath);
					$image = Yii::app()->image->open($filePath);
					$thumbnail = $image->thumbnail(new Imagine\Image\Box(16, 16));
					$thumbnail->save($filePath);
					$model->save();
				}

				$this->redirect(['view', 'id' => $model->id]);
			}
		}

		$this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model = $this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['UserStatus'])) {
			if ($model->isProtected()) {
				unset($_POST['UserStatus']['name']);
			}

			$model->attributes = $_POST['UserStatus'];

			$uploadedFile = CUploadedFile::getInstance($model, 'icon');
			$fileName = $model->id . '.' . end(explode(".", $uploadedFile));
			if (!empty($uploadedFile))
				$model->icon = $fileName;
			if ($model->save()) {
				if (!empty($uploadedFile)) {
					$filePath = Yii::app()->basePath . '/../images/user_status/' . $fileName;
					$uploadedFile->saveAs($filePath);
					$image = Yii::app()->image->open($filePath);
					$thumbnail = $image->thumbnail(new Imagine\Image\Box(16, 16));
					$thumbnail->save($filePath);
				}
				$this->redirect(['view', 'id' => $model->id]);
			}
		}

		$this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if (Yii::app()->request->isPostRequest) {
			$model = $this->loadModel();
			// we only allow deletion via POST request
			if ($model->isProtected()) {
				throw new CHttpException(400, 'Нельзя удалить данный статус');
			}
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(['index']);
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('UserStatus');
		$this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new UserStatus('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['UserStatus']))
			$model->attributes = $_GET['UserStatus'];

		$this->render('admin', [
			'model' => $model,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @return Userstatus
	 */
	public function loadModel()
	{
		if ($this->_model === null) {
			if (isset($_GET['id']))
				$this->_model = UserStatus::model()->findbyPk($_GET['id']);
			if ($this->_model === null)
				throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-status-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
