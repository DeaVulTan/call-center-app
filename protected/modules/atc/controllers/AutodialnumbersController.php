<?php

class AutodialnumbersController extends Controller
{
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('admin', 'create', 'update', 'delete'),
                'roles'   => array('manageTE'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreate()
    {
        $model = new AutodialNumbers;

        if (isset($_POST['AutodialNumbers'])) {
            $model->attributes = $_POST['AutodialNumbers'];
            /** @var AutodialMain $Main */
            $Main = AutodialMain::model()->findByPk($model->autodialid);
            if ($Main) {
                $model->iter   = $Main->iter;
                $model->status = 0;
            }
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['AutodialNumbers'])) {
            $model->attributes = $_POST['AutodialNumbers'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin()
    {
        $model = new AutodialNumbers('search');
        $model->unsetAttributes();
        if (isset($_GET['AutodialNumbers']))
            $model->attributes = $_GET['AutodialNumbers'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model = AutodialNumbers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'autodial-numbers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
