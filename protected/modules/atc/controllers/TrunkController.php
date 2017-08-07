<?php

class TrunkController extends Controller
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
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','admin','delete'),
                'roles'=>array('manageTE'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->actionUpdate(null);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if($id === null) {
            $model = new Trunk();
            $model->host = '';
        } else {
            $model=$this->loadModel($id);
        }

        $this->performAjaxValidation($model);

        if(isset($_POST['Trunk']))
        {
            $model->attributes=$_POST['Trunk'];

            $allow = [];
            if(is_array($_POST['Trunk']['allow_audio'])) {
                $allow = array_merge($_POST['Trunk']['allow_audio'], $allow);
            }
            if(is_array($_POST['Trunk']['allow_video'])) {
                $allow = array_merge($_POST['Trunk']['allow_video'], $allow);
            }
            $model->allow = implode(',', $allow);
            $model->fromuser = $model->username;
            $model->fromdomain = $model->host;
            $model->name = 'trunk_' . $model->name;
            $model->insecure = 'very';
            $model->context = 'incoming-from-sip';
            $model->disallow = 'all';
            $model->calllimit = 1000;
            if (!strlen($model->port)) {
                $model->port = 5060;
            }

            if($model->save()) {
                if ($model->is_need_registration == 1) {
                    $model->updateDataFile();
                }
                $this->redirect(['admin']);
            }
        }

        $model->allow_audio = array_intersect(explode(',',$model->allow), array_keys($model->codecsAudio));
        $model->allow_video = array_intersect(explode(',',$model->allow), array_keys($model->codecsVideo));
        $model->name = str_replace('trunk_', '', $model->name);
        $this->render('update',[
            'model'=>$model,
        ]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $model->delete();
        $model->updateDataFile();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Trunk('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Trunk'])) $model->attributes=$_GET['Trunk'];
        $this->render('admin',['model'=>$model]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Trunk the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Trunk::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Trunk $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='trunk-devices-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
