<?php

class ApiController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('updategcr', 'creategcr', 'deletegcr', 'updategcrbyuserid'),
				'users' => array('*'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionCreateGcr()
	{
		$model = new GroupCallRealtime;
		if (is_array($_POST)) {
			$model->attributes = $_POST;
			if ($model->save()) {
				echo $model->id;
                try {
				    self::updateMonitorData();
                } catch (Exception $e) {
                    Yii::log('error with updateMonitorData: ' . $e->getMessage(), 'error');
                }
			}
		}
	}

	public function actionUpdateGcr($id, $uid = null)
	{
            $needUpdateFlag = false;

            if ($uid!== null && intval($uid)) {
                $needUpdateFlag = true;
                GroupCallRealtime::model()->updateAll(array('user_id'=>null), 'user_id = :uid', array(':uid'=>intval($uid)));
            }
            $model = GroupCallRealtime::model()->findByPk($id);
            if (isset($_POST)) {
                $model->attributes = $_POST;
                if ($model->save()) {
                    $needUpdateFlag = true;
                    echo $model->id;
                }
            }

            if ($needUpdateFlag) {
                self::updateMonitorData();
            }
	}

	public function actionDeleteGcr($id)
	{
		$m = GroupCallRealtime::model()->findByPk($id);
		if ($m) {
			$m->delete();
			self::updateMonitorData();
		}
	}

    public static function updateMonitorData($params = [])
    {
        Yii::import('application.modules.callcenter.controllers.OperatorpanelController');
        Yii::app()->op->getMonitorData($params, true);
    }
}
