<?php

class AutodialmainController extends Controller
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
                'actions' => array('admin', 'create', 'update', 'delete', 'import', 'changestatus', 'playcontinue', 'playfromstart'),
                'roles'   => array('manageTE'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionCreate()
    {
        Yii::app()->getClientScript()->registerScriptFile('/js/angular.min.js');
        $model = new AutodialMain;
        $model->success_dial = 1;
        $model->iter_delay = 5;
        $model->callerid = '';

        if (isset($_POST['AutodialMain'])) {
            $model->attributes = $_POST['AutodialMain'];
            $model->status = 2;
            if ($model->save()) {
                $model->dir = 'autodial_' . $model->id;
                $model->save();
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        Yii::app()->getClientScript()->registerScriptFile('/js/angular.min.js');
        $model = $this->loadModel($id);

        if (isset($_POST['AutodialMain'])) {
            $model->attributes = $_POST['AutodialMain'];
            if ($model->save())
                $this->redirect(array('admin', 'id' => $model->id));
        }

        $exception_days = explode(',', $model->exeption_day);
        if (is_array($exception_days)) {
            foreach ($model->exeption_day_list as $key => $day) {
                if (in_array((string)$day['id'], $exception_days, true)) {
                    $model->exeption_day_list[$key]['value'] = 1;
                }
            }
        }

        $model->is_predict = !empty($model->predict_group) || !empty($model->predict_add_calls);

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
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAdmin()
    {
        $model = new AutodialMain('search');
        $model->unsetAttributes();
        if (isset($_GET['AutodialMain']))
            $model->attributes = $_GET['AutodialMain'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionImport()
    {
        $model = AutodialNumbers::model();
        if (isset($_POST['AutodialNumbers'])) {
            $file = CUploadedFile::getInstance($model, 'import_file');
            if (empty($file)) {
                Yii::app()->user->setFlash('error', 'Ошибка импорта: нет файла');
                $this->render('import', array('model' => $model));
                return;
            }
            if (empty($_POST['AutodialNumbers']['autodialid'])) {
                Yii::app()->user->setFlash('error', 'Ошибка импорта: не выбрано задание для автообзвона');
                $this->render('import', array('model' => $model));
                return;
            }
            /** @var AutodialMain $AutodialMain */
            $AutodialMain = AutodialMain::model()->findByPk($_POST['AutodialNumbers']['autodialid']);
            if (empty($AutodialMain)) {
                Yii::app()->user->setFlash('error', 'Ошибка импорта: задание для автообзвона не найдено');
                $this->render('import', array('model' => $model));
                return;
            }

            $handle = @fopen(CUploadedFile::getInstance($model, 'import_file')->tempName, "r");
            if ($handle) {
                $doubles_count = 0;
                $success_count = 0;
                $error_numbers = [];
                while (($line = fgets($handle, 4096)) !== false) {
                    if (!empty($line) && strlen(trim($line)) > 0) {
                        /** @var AutodialNumbers $Number */
                        $Number = new AutodialNumbers();
                        $Number->autodialid = $AutodialMain->id;
                        $Number->iter = $AutodialMain->iter;
                        $Number->number = $line;
                        // проверка уникальности выполняется перед сохранением
                        if ($Number->save()) {
                            $success_count++;
                        } else {
                            if ($Number->import_is_duplicate) {
                                $doubles_count++;
                            } else {
                                $error_numbers[] = $line;
                            }
                        }
                    }
                }
                fclose($handle);
                Yii::app()->user->setFlash(
                    'info',
                    'Успешно импортированно: ' . $success_count . '<br>' .
                    'Дубликатов: ' . $doubles_count . '<br>' .
                    (count($error_numbers) ? 'Не удалось импортировать: ' . implode(', ', $error_numbers) : '')
                );
            }
        }
        $this->render('import', array('model' => $model));
    }

    public function actionChangestatus($id, $status)
    {
        $Model = AutodialMain::model()->findByPk($id);
        if ($Model) {
            $Model->status = $status;
            $Model->save();
        }
        $this->redirect(array('admin'));
    }

    public function actionPlaycontinue($id)
    {
        $this->actionChangestatus($id, 1);
    }

    public function actionPlayfromstart($id)
    {
        $Model = AutodialMain::model()->findByPk($id);
        if ($Model) {
            $Model->playFromStart();
        }
        $this->redirect(array('admin'));
    }

    public function loadModel($id)
    {
        $model = AutodialMain::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'autodial-main-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
