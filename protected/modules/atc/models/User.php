<?php

/**
 * Модель для таблицы "user".
 *
 * Доступные колонки в таблице 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $firstname
 * @property string $surname
 * @property string $role
 * @property string $panel_cfg
 *
 * Связи таблицы:
 * @property Groupuser[] $groupusers
 */
class User extends CActiveRecord {
    public $sip_device;
    public $new_password;
    const ROLE_ADMIN = 'admin';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record класс.
     * @return User статический класс модели
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, firstname, surname', 'required'),
            array('username, password, email', 'length', 'max' => 128),
            array('firstname, surname, role', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, email, firstname, surname, role', 'safe', 'on' => 'search'),
            array('new_password', 'required', 'on'=>'register'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'group' => array(self::HAS_MANY, 'GroupUsers', 'user_id'),
            'groupname' => array(self::MANY_MANY, 'Group', 'group_users(user_id,group_id)'),
            'sipdevice' => array(self::HAS_ONE, 'SipDevices', 'chained_user_id'),
            'statusName' => array(self::BELONGS_TO, 'UserStatus', 'status'),
			'groupCallRealtime' => array(self::HAS_ONE, 'GroupCallRealtime', 'user_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('application', 'ID'),
            'username' => Yii::t('application', 'Username'),
            'password' => Yii::t('application', 'Password'),
            'new_password' => Yii::t('application', 'Password'),
            'email' => Yii::t('application', 'Email'),
            'firstname' => Yii::t('application', 'Firstname'),
            'surname' => Yii::t('application', 'Surname'),
            'role' => Yii::t('application', 'Role'),
            'sip_device' => Yii::t('application', 'Sip device'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('role', $this->role, true);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => 100,
            ),
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if (!empty($this->new_password)) {
            $this->password = md5(trim($this->new_password));
        }
        return parent::beforeSave();
    }

    /**
     * @param int $group_id
     * @return array for listbuilder (id => name)
     */
    public function findGroupChainedUsers($group_id, $chain = true) {
        $criteria = new CDbCriteria();
        $criteria->alias = 'user';
        $criteria->index = 'id';
        $criteria->select = 'user.id, concat(surname, \' \', firstname) as email';
        $criteria->join = "LEFT JOIN group_users gu ON (gu.user_id = user.id)";
        $criteria->condition = $chain ? "gu.group_id=:group_id" : 'user.id not in (select user_id from group_users where group_id=:group_id)';
        $criteria->params = array('group_id' => $group_id);
        $criteria->order = 'email';
        return CHtml::listData($this->findAll($criteria), 'id', 'email');
    }

    public function findAllUsers() {
        $criteria = new CDbCriteria();
        $criteria->alias = 'user';
        $criteria->index = 'id';
        $criteria->select = 'user.id, concat(surname, \' \', firstname) as email';
        $criteria->order = '2';
        return CHtml::listData($this->findAll($criteria), 'id', 'email');
    }

    public function insertQueue($userId = null) {
        $userId = !empty($userId) ? $userId : Yii::app()->user->id;

        $user = $this->with('sipdevice', 'group.groupn')->together()->find(
                'chained_user_id = :chained_user_id', array(':chained_user_id' => $userId));
        try {
            if($user && $user->group) {
                foreach ($user->group as $group) {
                    if (QueueMemberTable::model()->findByAttributes(array('membername' => $user->sipdevice->name, 'queue_name' => $group->groupn->qname)) != null) {
                        continue;
                    }

                    $row = new QueueMemberTable();
                    $row->attributes = array(
                        'membername' => $user->sipdevice->name,
                        'queue_name' => $group->groupn->qname,
                        'interface' => 'SIP/' . $user->sipdevice->name,
                        'penalty' => 100 - $group->penalty
                    );
                    $row->save();
                }
            }
        } catch (Exception $e) {
            Yii::log($e->getMessage() . "\n" . $e->getTraceAsString(), 'error');
        }
    }

    /**
     * Удаляет все записи из таблицы queue_member_table к которым не привязан онлайновый пользователь
     */

    public function clearQueue() {
        $cmd = $this->dbConnection->createCommand()
            ->selectDistinct('sip_devices.name')
            ->from(SipDevices::model()->tableName())
            ->leftJoin($this->tableName(), 'sip_devices.chained_user_id = user.id')
            ->join(QueueMemberTable::model()->tableName(), 'queue_member_table.membername = sip_devices.name')
            ->where(array('or', 'chained_user_id is null', array('not in', 'user.id', $this->_getOnlineUserIds())));
        $deleteQueueMember = $cmd->queryAll();
        foreach ($deleteQueueMember as $val) {
            QueueMemberTable::model()->deleteAllByAttributes(array('membername' => $val['name']));
        }
    }

    public function getUserGroupIds($userId = null) {
        $groupIds = [];
        if (is_null($userId))
            $userId = Yii::app()->user->getId();

        $groupUser = GroupUsers::model()->findAllByAttributes(['user_id' => $userId]);
        foreach ($groupUser as $group) {
            array_push($groupIds, $group->group_id);
        }
        return array_unique($groupIds);
    }

    public function getPanelCfg($userId = null) {
        if (is_null($userId))
            $userId = Yii::app()->user->getId();

        return User::model()->findByPk($userId)->panel_cfg;

    }

    /**
     * получения перечня id пользователей онлайн
     * @return array
     */
    protected function _getOnlineUserIds() {
        $sessions = UserSession::model()->findAll();
        $r = array();
        foreach ($sessions as $session) {
            $sess = Session::unserialize($session['data']);
            foreach ($sess as $k => $s) {
                if (strstr($k, '__id')) {
                    $r[] = intval($s);
                }
            }
        }
        return $r;
    }

    /**
     * Получение Имени Фамилии по ID
     *
     * @param $id
     * @return string
     */
    public function getUserFioByPk ($id)
    {
        /** @var $user User */
        $user = $this->findByPk($id);
        if (empty($user)) {
            return '-';
        }
        return $user->surname . ' ' . $user->firstname;
    }
}