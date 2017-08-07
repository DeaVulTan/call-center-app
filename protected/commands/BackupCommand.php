<?php

class BackupCommand extends CConsoleCommand
{

    public function actionIndex()
    {
        echo "create -- create backup now\n";
        echo "show   -- show backup config\n";

    }

    public function actionCreate()
    {
        echo Yii::app()->system->createBackup();
    }
}