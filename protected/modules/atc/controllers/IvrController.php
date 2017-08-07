<?php

class IvrController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('getvalue', 'getkeylist','create','update', 'setfile','admin','delete'),
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
		$model=new MainIvr;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['MainIvr']))
		{
			$model->attributes=$_POST['MainIvr'];
			if($model->save()) {
                                $this->saveRelationData($model);
				$this->redirect(array('admin'));
                        }
		}
                Yii::app()->getClientScript()->registerScriptFile('/js/add-delete-table-row.js');
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

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['MainIvr']))
		{
			$model->attributes=$_POST['MainIvr'];
			if($model->save()) {
			    $this->clearRelationData($model);
				$this->saveRelationData($model);
				$this->redirect(array('admin'));
			}
		}

                Yii::app()->getClientScript()->registerScriptFile('/js/add-delete-table-row.js');
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
	{echo "ok";exit;
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MainIvr('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MainIvr']))
			$model->attributes=$_GET['MainIvr'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MainIvr the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MainIvr::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MainIvr $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='main-ivr-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        public function actionSetFile() {
            $model = MainIvr::model()->findByPk($_REQUEST['item']);
            $model->file = $_REQUEST['value'];
            $model->save();
        }

        public function actionGetValue() {
            $events = MainIvr::model()->listEvents;
            $data = array('errors' => '-1');
            $fieldName = "IvrEvent[{$_POST['pos']}][value]";
            $htmlParams = array('name' => $fieldName);
            if(in_array($_POST['event'], array_keys($events))) {
                $ivrEvent = IvrEvents::model();
                switch ($events[$_POST['event']]['type']) {
                    case 'text':
                        if(isset($_POST['selected'])) $htmlParams = array_merge($htmlParams, array('value' => $_POST['selected']));
                        $data = CHtml::activeTextField($ivrEvent, 'value', $htmlParams);
                        break;
                    case 'select':
                        if(isset($_POST['selected'])) $htmlParams = array_merge($htmlParams, array('options' => array(intval($_POST['selected']) => array('selected' => 'selected'))));
                        $data = CHtml::activeDropDownList($ivrEvent, 'value',
                                CHtml::listData($events[$_POST['event']]['model']::model()->findAll(),
                                        $events[$_POST['event']]['param']['id'],
                                        $events[$_POST['event']]['param']['name']), $htmlParams);
                        break;
                    case 'hidden':
                        $data = Yii::t('application', 'No params').CHtml::activeHiddenField($ivrEvent, 'value', array_merge($htmlParams,array('value'=>1)));
                        break;
                    default:
                        $data = CHtml::activeHiddenField($ivrEvent, 'value', array_merge($htmlParams,array('value'=>1)));
                        break;
                }
            }

//            $data = CHtml::activeDropDownList(IvrEvents::model(), 'value', CHtml::listData(Sound::model()->findAll(), 'id', 'comment'));
            $dataArr = array('cell' => $data);
            echo json_encode($dataArr);
        }

        public function actiongetKeyList() {
            $model = MainIvr::model();
            $data = CHtml::activeDropDownList(IvrEvents::model(), 'key', CHtml::listData($model->eventKeys, 'id','name'));
            $dataArr = array('keys' => $data);
            echo json_encode($dataArr);
        }

	protected function clearRelationData(MainIvr $model) {
	    $criteria=new CDbCriteria;
	    $criteria->condition='type=:type and type_val=:type_val';
	    $criteria->params=array('type' => 'ivr','type_val'=>$model->id);
	    IvrEvents::model()->deleteAll($criteria);
	}

        /**
         * Метод сохранения событий IVR
         */
        protected function saveRelationData(MainIvr $model) {
            foreach ($_POST['IvrEvent'] as $eventData) {
                $event = new IvrEvents();
                $event->type = 'ivr';
                $event->type_val = $model->id;
                $event->key = $eventData['key'];
                $event->event = $eventData['event'];
                $event->value = $eventData['value'];
                if (!$event->save()) {
					VarDumper::dump($event->errors);
				}
            }
        }
}
