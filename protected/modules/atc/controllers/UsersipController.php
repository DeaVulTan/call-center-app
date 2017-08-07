<?php

class UsersipController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

        public $defaultAction = 'admin';

        public $useAmi = true;

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
            array('allow',
                'actions'=>array('index','view','admin','delete','create','update'),
                'roles'=>array('managerUserSip'),
            ),
            array('deny',
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
        $model=new SipDevices;

        // Uncomment the following line if AJAX validation is needed
         $this->performAjaxValidation($model);

        if(isset($_POST['SipDevices']))
        {
            $model->attributes=$_POST['SipDevices'];

            if (SipDevices::model()->find('name=:name', array('name' => $model->name)) != null) {
                Yii::app()->user->setFlash('warning',"Данный номер уже существует");
            } else {
                $model->context = 'mn';
                $model->nat = 'no';
                $model->dtmfmode = 'rfc2833';
                $model->allow = 'alaw,ulaw,h263';
                $model->calllimit = 2;
                $model->videosupport = 'yes';
                $model->fromuser = $model->mailbox = $model->username = $model->name;
                if($model->save()) {
                    $voiceMail = new Voicemail();
                    $voiceMail->customer_id = $voiceMail->mailbox = $model->name;
                    $voiceMail->context = 'vmail';
                    $voiceMail->password = $model->secret;
                    $voiceMail->save();
                    if($this->useAmi) $this->_amiPull();
                    $this->redirect(array('view','id'=>$model->id));
                }
            }
        }
        $model->allow = explode(',',$model->allow);
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
        $voiceMail = Voicemail::model()->find('mailbox=:name', array('name'=>$model->name));
        if(!is_a($voiceMail, 'Voicemail')) $voiceMail = new Voicemail();
        // Uncomment the following line if AJAX validation is needed
         $this->performAjaxValidation($model);

        if(isset($_POST['SipDevices']))
        {
            $model->attributes=$_POST['SipDevices'];
            $model->context = 'mn';
            $model->fromuser = $model->mailbox = $model->username =$model->name;
            if($model->save()) {
                $voiceMail->customer_id = $voiceMail->mailbox = $model->name;
                $voiceMail->context = 'vmail';
                $voiceMail->password = $model->secret;
                if($voiceMail->save()) {
                    if($this->useAmi) $this->_amiPull();
                    $this->redirect(array('view','id'=>$model->id));
                }
                else Yii::trace('Voicemail::save() failed!', 'error');
            }
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
        $model = $this->loadModel($id);
                $voiceMail = Voicemail::model()->find('mailbox=:name', array('name'=>$model->name));
                if(is_a($voiceMail, 'Voicemail')) $voiceMail->delete();
                $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('SipDevices');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new SipDevices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SipDevices'])) $model->attributes=$_GET['SipDevices'];
        $this->render('admin',array('model'=>$model,));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SipDevices the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=SipDevices::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SipDevices $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='sip-devices-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function _amiPull() {
        $ami_params = Yii::app()->params['ami'];
        $ami = new Ami($ami_params['host'], $ami_params['port'], $ami_params['amiuser'], $ami_params['amipassword']);
        $ami->sipReload();
    }
}
