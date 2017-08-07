<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	// Будем хранить id.
	protected $_id;
	public $usernumber;
	public $groupId;


	// Данный метод вызывается один раз при аутентификации пользователя.
	public function authenticate()
	{

		// Производим стандартную аутентификацию, описанную в руководстве.
		$user = User::model()->with('group')->find('LOWER(username)=?', array(strtolower($this->username)));
		if (($user === null) or (md5($this->password) !== $user->password)) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			// В качестве идентификатора будем использовать id, а не username,
			// как это определено по умолчанию. Обязательно нужно переопределить
			// метод getId(см. ниже).
			$this->_id = $user->id;

			// Далее логин нам не понадобится, зато имя может пригодится
			// в самом приложении. Используется как Yii::app()->user->name.
			//$this->username = $user->surname . ' ' . $user->firstname;
			$auth = Yii::app()->authManager;

			if (!$auth->isAssigned($user->role, $this->_id)) {
				if ($auth->assign($user->role, $this->_id)) {
					Yii::app()->authManager->save();
				}
			}
			if ($this->usernumber === false) $this->errorCode = self::ERROR_USERNAME_INVALID;

			$groups = array();
			foreach ($user->group as $group) {
				$groups[] = $group->group_id;
			}
			$this->setState('groupId', $groups);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}