<?php

class TimeruleController extends Controller
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
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        if($id === null) {
            $model = new TimeRule();
        } else {
            $model=$this->loadModel($id);
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['TimeRule']))
        {
            $post = $_POST['TimeRule'];
            $model->condition_id = $post['condition_id'];


            $model->time = $this->formatTime($post['time_from']) . '-' . $this->formatTime($post['time_to']);
            if ($model->time == '00:00-00:00') {
                $model->time = '*';
            }
            $model->dow = $post['dow_from'] . (!empty($post['dow_to']) ? '-' . $post['dow_to'] : '');
            if (empty($model->dow)) {
                $model->dow = '*';
            }
            $model->dom = $post['dom_from'] . (!empty($post['dom_to']) ? '-' . $post['dom_to'] : '');
            if (empty($model->dom)) {
                $model->dom = '*';
            }

            $model->mon = $post['mon_from'] . (!empty($post['mon_to']) ? '-' . $post['mon_to'] : '');
            if (empty($model->mon)) {
                $model->mon = '*';
            }

            if($model->save())
                $this->redirect(array('admin'));
        }

        if ($model->time != '*') {
            $data = explode('-', $model->time);
            $model->time_from = $data[0];
            $model->time_to = array_key_exists(1, $data) ? $data[1] : '';
        }

        if ($model->dow != '*') {
            $data = explode('-', $model->dow);
            $model->dow_from = $data[0];
            $model->dow_to = array_key_exists(1, $data) ? $data[1] : '';
        }

        if ($model->dom != '*') {
            $data = explode('-', $model->dom);
            $model->dom_from = $data[0];
            $model->dom_to = array_key_exists(1, $data) ? $data[1] : '';
        }

        if ($model->mon != '*') {
            $data = explode('-', $model->mon);
            $model->mon_from = $data[0];
            $model->mon_to = array_key_exists(1, $data) ? $data[1] : '';
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
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new TimeRule('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TimeRule']))
            $model->attributes=$_GET['TimeRule'];

        $this->render('admin',array(
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
        $model=TimeRule::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='time-rule-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function formatTime($time)
    {
        if (empty($time)) {
            $time = '00:00';
        }

        $time = explode(':', $time);
        return str_pad($time[0], 2, "0", STR_PAD_LEFT) . ':' . str_pad($time[1], 2, "0", STR_PAD_LEFT);
    }
}
