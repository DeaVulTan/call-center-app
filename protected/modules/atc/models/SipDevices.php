<?php

/**
 * Модель для таблицы "sip_devices".
 *
 * Доступные колонки в таблице 'sip_devices':
 * @property integer $id
 * @property string $name
 * @property string $context
 * @property string $secret
 * @property string $nat
 * @property string $callerid
 * @property string $dtmfmode
 * @property string $fromuser
 * @property string $mailbox
 * @property string $allow
 * @property string $username
 * @property integer $rec
 * @property integer $calllimit
 */
class SipDevices extends CActiveRecord
{
    public $allow_audio;
    public $allow_video;

    //Типы DTFM сигнализации
    public $dtfmModes = array(
        'rfc2833' => array('id' => 'rfc2833', 'name' => 'RFC2833'),
        'info' => array('id' => 'info', 'name' => 'SIP Info'),
        'inband' => array('id' => 'inband', 'name' => 'Inband'),
    );

    public $codecsAudio = array(
        'alaw' => array('id' => 'alaw', 'name' => 'alaw'),
        'ulaw' => array('id' => 'ulaw', 'name' => 'ulaw'),
        'g729' => array('id' => 'g729', 'name' => 'g729'),
        'gsm' => array('id' => 'gsm', 'name' => 'gsm'),
    );

    public $codecsVideo = array(
        'h263' => array('id' => 'h263', 'name' => 'h263'),
        'h263p' => array('id' => 'h263p', 'name' => 'h263p'),
        'h264' => array('id' => 'h264', 'name' => 'h264'),
    );

//Тип конекста
    public $contextList = array(
        'loc' => array('id' => 'loc', 'name' => 'Внутренние'),
        'city' => array('id' => 'city', 'name' => 'Город'),
        'mg' => array('id' => 'mg', 'name' => 'Межгород и мобильные'),
        'mn' => array('id' => 'mn', 'name' => 'Международные'),
    );

//Тип поддержки видео
    public $videoSupports = array(
        'yes' => array('id' => 'yes', 'name' => 'Да'),
        'no' => array('id' => 'no', 'name' => 'Нет'),
        'allways' => array('id' => 'always', 'name' => 'Всегда'),
    );    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return SipDevices статический класс модели
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
		return 'sip_devices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rec, calllimit, chained_user_id', 'numerical', 'integerOnly'=>true),
			array('name, secret, callerid, fromuser, username', 'length', 'max'=>80),
			array('nat', 'length', 'max'=>5),
			array('dtmfmode', 'length', 'max'=>7),
			array('mailbox', 'length', 'max'=>50),
			array('allow, videosupport', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, secret, nat, callerid, dtmfmode, fromuser, mailbox, allow, username, rec, calllimit, chained_user_id, videosupport', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => Yii::t('application', 'ID'),
            'name' => Yii::t('application', 'Number'),
            'context' => Yii::t('application', 'Context'),
            'secret' => Yii::t('application', 'Secret'),
            'nat' => Yii::t('application', 'Nat'),
            'callerid' => Yii::t('application', 'Name'),
            'dtmfmode' => Yii::t('application', 'Dtmfmode'),
            'fromuser' => Yii::t('application', 'Fromuser'),
            'mailbox' => Yii::t('application', 'Mailbox'),
            'allow' => Yii::t('application', 'Allow'),
            'username' => Yii::t('application', 'Username'),
            'rec' => Yii::t('application', 'Rec'),
            'calllimit' => Yii::t('application', 'Calllimit'),
            'chained_user_id' => Yii::t('application', 'Chained user'),
            'videosupport' => Yii::t('application', 'Video support'),
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('context',$this->context,true);
		$criteria->compare('secret',$this->secret,true);
		$criteria->compare('nat',$this->nat,true);
		$criteria->compare('callerid',$this->callerid,true);
		$criteria->compare('dtmfmode',$this->dtmfmode,true);
		$criteria->compare('fromuser',$this->fromuser,true);
		$criteria->compare('mailbox',$this->mailbox,true);
		$criteria->compare('allow',$this->allow,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('rec',$this->rec);
		$criteria->compare('calllimit',$this->calllimit);
		$criteria->compare('videosupport',$this->videosupport);
		$criteria->compare('chained_user_id', User::model()->findByPk($this->chained_user_id, array('select' => 'firstname')));

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => 100,
			),
			'criteria'=>$criteria,
		));
	}

    /**
     * Сохраняем некондиционные поля
     */
    public function afterSave() {
        parent::afterSave();
        Yii::app()->db->createCommand("UPDATE {$this->tableName()} SET `call-limit`={$this->calllimit} WHERE `id`={$this->id}")->execute();
    }

    public function defaultScope()
    {
        return [
            'condition' => "name NOT LIKE 'trunk_%'",
        ];
    }
}