<?php

/**
 * This is the model class for table "user_status".
 *
 * The followings are the available columns in table 'user_status':
 * @property string $id
 * @property string $name
 * @property integer $call_deny
 * @property string $icon
 * @property integer $limit
 * @property string $limit_message
 */
class UserStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['name', 'required'],
			['call_deny, limit', 'numerical', 'integerOnly'=>true],
			['name, limit_message', 'length', 'max'=>255],
			['icon', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			['id, name, call_deny, icon, limit, limit_message', 'safe', 'on'=>'search'],
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'users' => [self::HAS_MANY, 'User', 'status'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'Id',
			'name' => Yii::t('application','Name'),
			'call_deny' => Yii::t('application','Call Deny'),
			'icon' => Yii::t('application','Icon'),
            'limit' => Yii::t('application', 'Лимит операторов'),
            'limit_message' => Yii::t('application', 'Сообщение о превышении лимита'),
		];
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('call_deny',$this->call_deny);
		$criteria->compare('id', '>1');

		return new CActiveDataProvider('UserStatus', [
			'pagination' => [
				'pageSize' => 100,
			],
			'criteria'=>$criteria,
		]);
	}

    public function getStatusListJson()
    {
        $userStatus = self::model()->findAll();
        $statuses = [
            ['id' => 'all', 'name' => 'Все'],
			['id' => 'group', 'name' => 'Мои службы'],
        ];
        foreach($userStatus as $status)
        {
            $statuses[] = [
                'id' => $status->id,
                'name' => $status->name
            ];
        }
        return json_encode($statuses);
    }

    protected function afterValidate()
    {
        if ($this->limit > 0 && empty($this->limit_message)) {
            $this->addError('limit_message', 'При указании лимита должно быть задано сообщение пользователю');
            return false;
        }

        parent::afterValidate();
    }

	/**
	 * Проверка защищености статуса пользователя
	 * в Онлайн и Обед поле название не должно меняться
	 *
     * @return bool
	 */
	public function isProtected()
	{
		return in_array($this->id, [1,2]);
	}
}