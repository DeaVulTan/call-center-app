<?php

class SystemController extends Controller
{
    public $layout = '//layouts/column2';
    public $defaultAction = 'backup';

    public function filters()
    {
        return [
            'accessControl',
            'postOnly + delete',
        ];
    }

    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['monitor', 'backup', 'createbackup', 'getbackup', 'delbackup'],
                'roles' => ['canEditSetting'],
            ],
            ['deny',
                'users' => ['*'],
            ],
        ];
    }


    public function actionMonitor()
    {
        $this->render('monitor', ['data' => Yii::app()->system->getMonitorData()]);
    }


    public function actionBackup()
    {
        $this->render('backup', ['backups' => Yii::app()->system->getBackupList()]);
    }


    public function actionCreatebackup()
    {
        Yii::app()->system->createBackup();
        $this->redirect('backup');
    }

    public function actionGetbackup()
    {
        $filename = Yii::app()->request->getParam('name', null);

        $path = Yii::app()->system->getFilePath($filename);

        header('Cache-control: private');
        header('Content-Type: application/octet-stream');
        header('Content-Length: '.filesize($path));
        header('Content-Disposition: filename='.$filename);
        echo file_get_contents($path);
    }

    public function actionDelbackup()
    {
        $filename = Yii::app()->request->getParam('name', null);

        Yii::app()->system->deleteBackup($filename);
        $this->redirect('backup');
    }
}