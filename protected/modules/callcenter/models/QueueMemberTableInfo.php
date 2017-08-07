<?php

/**
 * Модель для таблицы "queue_member_table_info".
 *
 * Доступные колонки в таблице 'queue_member_table_info':
 * @property string $uniqueid
 * @property string $membername
 * @property string $queue_name
 * @property string $interface
 * @property integer $penalty
 * @property integer $paused
 */
class QueueMemberTableInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return QueueMemberTableInfo статический класс модели
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
		return 'queue_member_table_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penalty, paused', 'numerical', 'integerOnly'=>true),
			array('membername', 'length', 'max'=>40),
			array('queue_name, interface', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uniqueid, membername, queue_name, interface, penalty, paused', 'safe', 'on'=>'search'),
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
			                'uniqueid' => Yii::t('application', 'Uniqueid'),
			                'membername' => Yii::t('application', 'Membername'),
			                'queue_name' => Yii::t('application', 'Queue Name'),
			                'interface' => Yii::t('application', 'Interface'),
			                'penalty' => Yii::t('application', 'Penalty'),
			                'paused' => Yii::t('application', 'Paused'),
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

		$criteria->compare('uniqueid',$this->uniqueid,true);
		$criteria->compare('membername',$this->membername,true);
		$criteria->compare('queue_name',$this->queue_name,true);
		$criteria->compare('interface',$this->interface,true);
		$criteria->compare('penalty',$this->penalty);
		$criteria->compare('paused',$this->paused);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}