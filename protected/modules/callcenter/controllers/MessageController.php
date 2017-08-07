<?php

class MessageController extends Controller
{
    public $defaultAction = 'inbox';
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('create','inbox','outbox','view','check','all','readall'),
				'users'=>array('@'),
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
        Yii::app()->message->setViewedStatus($id);

		$this->render('view',array(
			'model' => Message::model()->getMessage($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Message;
		if(isset($_POST['Message']))
		{
            $post = Yii::app()->request->getPost('Message');
            $receiverId = 0;
            if ($post['type'] == 1) {
                $receiverId = $post['user_id'];
            } elseif ($post['type'] == 2) {
                $receiverId = $post['group_id'];
            }
            $data = [
                'title' => $post['title'],
                'body' => $post['body'],
                'type' => $post['type'], // 1 - user_id, 2 - group_id, 3 - all users
                'receiver_id' => $receiverId,
            ];
            try {
                Yii::app()->message->sendMessage($data);
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error','Не удалось сохранить сообщение. ' . $e->getMessage());
            }
			$this->redirect('inbox');
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionInbox()
	{
		$model=new Message('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Message']))
			$model->attributes=$_GET['Message'];

        $model->inbox_user_id = Yii::app()->user->getId();
		$this->render('inbox',array(
			'model'=>$model,
		));
	}

    public function actionReadall()
    {
        Message::model()->readAll();
        $this->redirect('/callcenter/message');
    }

    public function actionOutbox()
    {
        $model=new Message('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Message']))
            $model->attributes=$_GET['Message'];

        $model->user_id = Yii::app()->user->getId();
        $this->render('outbox',array(
            'model'=>$model,
        ));
    }

    public function actionAll()
    {
        $model=new Message('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Message'])) {
            $model->attributes=$_GET['Message'];
            $model->created_at_from=$_GET['created_at_from'];
        }

        $this->render('all',array(
            'model'=>$model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Message::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function actionCheck()
    {
        $newMessages = MessageUser::model()->count(['condition' => 'status = 0 and user_id = ' . Yii::app()->user->getId()]);
        print intval($newMessages);
    }
}
