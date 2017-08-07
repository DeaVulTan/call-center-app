<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
class GroupController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'chainuser', 'admin', 'qualification'),
                'roles' => array('manageServices', 'adminServices'),
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete', 'view'),
                'roles' => array('adminServices'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Group;
        $queue = new QueueTable;
        $this->registerScripts();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Group'], $_POST['QueueTable'])) {
            $model->attributes = $_POST['Group'];
            $model->color = str_replace('#', '', $model->color);
            $queue->attributes = $_POST['QueueTable'];
            $queue->name = $this->getNewQueueName();


            $model->qname = $queue->name;
            if ($model->iconFile)
                $model->iconFile = CUploadedFile::getInstance($model, 'iconFile');
            $valid = $model->validate();
            $valid = $queue->validate() && $valid;
            if ($valid) {
                $this->saveIconFile($model);
                $queue->save();
                $model->save();

                $this->redirect(array('view', 'id' => $model->id));
            }
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create', array(
            'model' => $model,
            'queue' => $queue,
        ));
    }

    /**
     * Generate unique queue name
     * @return string
     */
    private function getNewQueueName() {
        $newQueueName = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        if (QueueTable::model()->findAll(array('condition'=>'name=:name', 'params'=>array(':name'=>$newQueueName))) != null) {
            $newQueueName = $this->getNewQueueName();
        }
        return $newQueueName;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->registerScripts();
        $model = $this->loadModel($id);
        $queue = $model->qname0;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Group'], $_POST['QueueTable'])) {
            $model->attributes = $_POST['Group'];
            $model->color = str_replace('#', '', $model->color);
            $queue->attributes = $_POST['QueueTable'];
            $model->iconFile = CUploadedFile::getInstance($model, 'iconFile');
            $valid = $model->validate();
            $valid = $queue->validate() && $valid;

            if ($model->deleteFile) {
                $this->deleteIcon($model->icon);
                $model->icon = '';
            }

            if ($valid) {
                if (!$model->deleteFile) {
                    $this->saveIconFile($model);
                }

                $queue->save();
                $model->save();

                $this->redirect(array('view', 'id' => $model->id));
            }

//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'queue' => $queue,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);

        QueueTable::model()->deleteAll('name = ?', array($model->qname));
        QueueMemberTable::model()->deleteAll('queue_name = ?', array($model->qname));
        if ($model->icon && file_exists(Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $model->icon))
            unlink(Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $model->icon);
        $model->deleted = 1;
        $model->save();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Group');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Group('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Group']))
            $model->attributes = $_GET['Group'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * @param integer $id the ID of group
     */
    public function actionQualification($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['penalty'])) {
            foreach ($_POST['penalty'] as $key => $val) {
                $penalty = 100 - intval($val);
                list($user_id, $group_id) = explode('_', $key);
                /** @var GroupUsers $groupUsers */
                $groupUsers = GroupUsers::model()->findByAttributes(['user_id' => $user_id, 'group_id' => $group_id]);
                $groupUsers->penalty = $penalty;
                $groupUsers->save();

                $sipDevice = SipDevices::model()->findByAttributes(['chained_user_id' => $user_id]);
                if ($sipDevice !== null) {
                    QueueMemberTable::model()->updateAll(
                            ['penalty' => $penalty],
                            'membername = ? and queue_name = ?', [$sipDevice->name, $model->qname0->name]
                    );
                }
            }
            Yii::import('application.modules.atc.controllers.ApiController');
            ApiController::updateMonitorData();
        }
        $this->render('qualification', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Group the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Group::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Group $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function registerScripts() {
        Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
        Yii::app()->clientScript->registerCssFile(
                Yii::app()->clientScript->getCoreScriptUrl() .
                '/jui/css/base/jquery-ui.css'
        );
    }

    public function icon_image($filename) {

        if (file_exists(Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $filename)) {
            $url = Yii::app()->assetManager->publish(
                    Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $filename
            );
            echo CHtml::image($url);
        }
        else
            return '';
    }

    public function deleteIcon($filename) {
        $filepath = Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($filepath)) {
            return @unlink($filepath);
        }

        return false;
    }

    protected function saveIconFile(Group $model) {
        if ($model->iconFile) {
            $fileDir = Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR;
            if (file_exists($fileDir . $model->icon) && is_file($fileDir . $model->icon))
                unlink($fileDir . $model->icon);

            $fileExt = $model->iconFile->getExtensionName();
            $fileName = time() . '.' . $fileExt;
            $model->iconFile->saveAs($fileDir . $fileName);
            $model->icon = $fileName;
        }
    }

    public function actionChainUser($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->clearChainedUsers();
            if (isset($_POST['User']['chained']) && is_array($_POST['User']['chained']) && count($_POST['User']['chained'])) {
                $criteria = new CDbCriteria;
                $criteria->distinct = true;
                $criteria->addInCondition('id', $_POST['User']['chained']);
                $users = User::model()->findAll($criteria);
                foreach ($users as $user) {
                    $gu = new GroupUsers();
                    $gu->user_id = $user->id;
                    $gu->group_id = $model->id;
                    $gu->penalty = 0;
                    if ($gu->save()) {
                        if($user->sipdevice) {
                            $this->clearGroupUserQueue($model->qname0->name, $user->sipdevice->name);
                            $gmti = new QueueMemberTableInfo();
                            $gmti->membername = $user->sipdevice->name;
                            $gmti->queue_name = $model->qname0->name;
                            $gmti->interface = 'SIP/'.$user->sipdevice->name;
                            $gmti->penalty = $gu->penalty;
                            $gmti->save();
                        }
                        
                    }
                }
                Yii::import('application.modules.atc.controllers.ApiController');
                ApiController::updateMonitorData();
            }
        }
        $this->render('chainuser', array(
            'model' => $model,
        ));
    }
    
    private function clearGroupUserQueue($queue_name, $user_id) {
        $criteria=new CDbCriteria;
        $criteria->condition='queue_name=:queue_name AND membername=:membername';
        $criteria->params=array('queue_name'=>$queue_name, 'membername'=>$user_id);
        if (!QueueMemberTableInfo::model()->deleteAll($criteria)) {
                VarDumper::dump('GroupUserQueue delete failed');
        }
    }

}
