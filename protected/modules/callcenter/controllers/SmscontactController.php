<?php

class SmscontactController extends Controller
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
			['allow',
				'actions'=> ['admin','delete','create','update','sendsms','getnumber'],
				'users'=> ['admin'],
			],
			['deny',  // deny all users
				'users'=> ['*'],
			],
		];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SmsContact;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SmsContact']))
		{
			$model->attributes=$_POST['SmsContact'];
			$model->user_id = Yii::app()->user->getId();
			if($model->save())
				$this->redirect(['update','id'=>$model->id]);
		}

		$this->render('create', [
			'model'=>$model,
		]);
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

		if(isset($_POST['SmsContact']))
		{
			$model->attributes=$_POST['SmsContact'];
			if($model->save())
				$this->redirect(['update','id'=>$model->id]);
		}

		$this->render('update', [
			'model'=>$model,
		]);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 * @throws CHttpException
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SmsContact('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SmsContact']))
			$model->attributes=$_GET['SmsContact'];

		$this->render('admin', [
			'model'=>$model,
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param $id
	 * @return array|CActiveRecord|mixed|null
	 * @throws CHttpException
	 * @internal param the $integer ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SmsContact::model()->findByAttributes(['id' => $id, 'user_id' => Yii::app()->user->getId()]);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sms-contact-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSendsms()
	{
		$request = Yii::app()->request;

		$model = new Sms;
		$model->user_id = Yii::app()->user->getId();
		$model->phone = $request->getPost('number');
		$model->body = $request->getPost('text');
		$model->sender = $request->getPost('sender');
		$model->created_at = new CDbExpression('NOW()');

		if ($model->save()) {
			echo CJSON::encode(['status' => 1, 'msg' => 'смс отправлена']);
		} else {
			echo CJSON::encode(['status' => 0, 'msg' => current($model->getErrors())[0]]);
		}

		Yii::app()->end();
	}

	public function actionGetnumber()
	{
		/** @var SmsContact $model */
		$model = SmsContact::model()->findByAttributes(['id' => intval($_POST['id']), 'user_id' => Yii::app()->user->getId()]);
		if (!empty($model)) {
			echo $model->number;
		}
		Yii::app()->end();
	}
}
