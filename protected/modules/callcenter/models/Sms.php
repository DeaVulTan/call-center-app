<?php

/**
 * This is the model class for table "sms".
 *
 * The followings are the available columns in table 'sms':
 * @property string $id
 * @property string $created_at
 * @property string $sender
 * @property string $phone
 * @property string $body
 * @property integer $status
 * @property integer $user_id
 * @property string $linkedid
 * @property integer $group_id
 */
class Sms extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sms the static model class
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
		return 'sms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender, phone', 'required'),
			array('status, user_id, group_id', 'numerical', 'integerOnly'=>true),
			array('sender, body, linkedid', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>45),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, created_at, sender, phone, status, user_id, body, linkedid, group_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'created_at' => 'Created At',
			'sender' => Yii::t('application', 'Отправитель'),
			'phone' => Yii::t('application', 'Номер'),
			'status' => 'Status',
			'user_id' => 'User',
            'body' => Yii::t('application', 'Текст сообщения'),
            'linkedid' => 'LinkedId',
            'group_id' => 'GroupId'
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_id',$this->user_id);
        $criteria->compare('body',$this->body);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}