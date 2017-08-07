<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rkuzmin
 * Date: 31.03.13
 * Time: 21:03
 * To change this template use File | Settings | File Templates.
 */

class WebUser extends AuthWebUser {

	public $admins;

	protected function beforeLogin($id,$states,$fromCookie)
	{
		parent::beforeLogin($id,$states,$fromCookie);
		StatusLog::setNewStatus(1, $id);
		User::model()->updateByPk($id,array('status'=>1));
		UserSession::model()->deleteAll('data like \'%__id|s:'.strlen($id).':"'.$id.'";%\'');
		return true;
	}

	protected function afterLogin($fromCookie) {
		Yii::import('application.modules.atc.controllers.ApiController');
		parent::afterLogin($fromCookie);
		$queue = new User();
		$queue->insertQueue($this->id);
		return true;
	}

	protected function beforeLogout()
	{
		parent::beforeLogout();
		UserSession::model()->deleteAll('data like \'%__id|s:'.strlen($this->id).':"'.$this->id.'";%\'');
		$queue = new User();
		$queue->clearQueue(Yii::app()->user->id);
		StatusLog::setNewStatus(null, Yii::app()->user->getId());
		User::model()->updateByPk(Yii::app()->user->id,array('status'=>null));
		return true;
	}

	protected function afterLogout() {
		Yii::import('application.modules.atc.controllers.ApiController');
		parent::afterLogout();
        ApiController::updateMonitorData();
		return true;
	}
}