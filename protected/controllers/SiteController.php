<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('changestatus'),
				'users' => array('@'),
				'verbs' => array('post'),
			),
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('logout'),
				'users' => array('@'),
			),
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('login'),
				'users' => array('?'),
			),
			array('allow', // deny all users
				'actions' => array('index'),
				'users' => array('*'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
//            $this->actionLogin();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				if (is_null(SipDevices::model()->findByAttributes(array('chained_user_id' => Yii::app()->user->id)))) {
					Yii::app()->user->setFlash('info',"К данному пользователю не привязан внутренний номер");
				}
				if (User::model()->findByPk(Yii::app()->user->id)->role == 'operator' && Yii::app()->user->returnUrl == '/') {
					$this->redirect($this->createUrl('callcenter/operatorpanel'));
				}

				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionChangeStatus() {
        $result = [
            'status' => 'error',
            'msg' => '',
        ];
		if(!empty($_POST['id']) && $id = intval($_POST['id'])) {
            /** @var UserStatus $status */
            $status = UserStatus::model()->findByPk($id);
            if ($status->limit > 0 && $status->limit <= User::model()->count('status = ' . $id)) {
                $result = [
                    'status' => 'error',
                    'msg' => $status->limit_message,
                ];
            } elseif ($status = UserStatus::model()->findByPk(intval($_POST['id']))) {
                StatusLog::setNewStatus($status->id);
                User::model()->updateByPk(Yii::app()->user->id,array('status'=>$status->id));
                $call_deny = UserStatus::model()->findByPk($status->id)->call_deny;
                $user_phone = SipDevices::model()->findByAttributes(array('chained_user_id' => Yii::app()->user->id))->name;
                if ($call_deny == '0') {
                    QueueMemberTable::model()->updateAll(array('paused' => 0),'membername="'.$user_phone.'"');
                } else {
                    QueueMemberTable::model()->updateAll(array('paused' => 1),'membername="'.$user_phone.'"');
                }
				Yii::import('application.modules.atc.controllers.ApiController');
                ApiController::updateMonitorData();
            //    $this->amiQueueShow();
				$result = [
                    'status' => 'ok',
                    'id' => $status->id,
                    'name' => $status->name,
                    'icon' => $status->icon,
                ];

			}
		}
        echo CJSON::encode($result);
        Yii::app()->end(200);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    protected function amiQueueShow()
    {
        $ami_params = Yii::app()->params['ami'];
        $ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
        $ami->queueShow();
    }
}