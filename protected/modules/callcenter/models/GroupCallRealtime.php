<?php

/**
 * Модель для таблицы "group_call_realtime".
 *
 * Доступные колонки в таблице 'group_call_realtime':
 * @property string $id
 * @property string $time_in
 * @property string $time_ans
 * @property string $time_out
 * @property string $cid
 * @property integer $group_id
 * @property string $qname
 * @property string $op_number
 * @property integer $status
 * @property string $linkedid
 * @property string $uniqueid
 * @property string $cid_chan
 * @property string $op_chan
 * @property integer $user_id
 *
 * Связи таблицы:
 * @property Group $group
 */
class GroupCallRealtime extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return GroupCallRealtime статический класс модели
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group_call_realtime';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, status, user_id', 'numerical', 'integerOnly' => true),
			array('cid, qname, op_number, linkedid, uniqueid, cid_chan, op_chan', 'length', 'max' => 255),
			array('cid, qname, group_id', 'required'),
			array('time_in, time_ans, time_out', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time_in, time_ans, time_out, cid, group_id, qname, op_number, status, linkedid, uniqueid, cid_chan, op_chan', 'safe', 'on' => 'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'vip' => array(self::HAS_ONE, 'Vip', array('tel1' => 'cid')),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('application', 'ID'),
			'time_in' => Yii::t('application', 'Time In'),
			'time_ans' => Yii::t('application', 'Time Ans'),
			'time_out' => Yii::t('application', 'Time Out'),
			'cid' => Yii::t('application', 'Cid'),
			'group_id' => Yii::t('application', 'Group'),
			'qname' => Yii::t('application', 'Qname'),
			'op_number' => Yii::t('application', 'Op Number'),
			'status' => Yii::t('application', 'Status'),
			'linkedid' => Yii::t('application', 'Linkedid'),
			'uniqueid' => Yii::t('application', 'Uniqueid'),
			'cid_chan' => Yii::t('application', 'Cid Chan'),
			'op_chan' => Yii::t('application', 'Op Chan'),
			'user_id' => Yii::t('application', 'User Id'),
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('time_in', $this->time_in, true);
		$criteria->compare('time_ans', $this->time_ans, true);
		$criteria->compare('time_out', $this->time_out, true);
		$criteria->compare('cid', $this->cid, true);
		$criteria->compare('group_id', $this->group_id);
		$criteria->compare('qname', $this->qname, true);
		$criteria->compare('op_number', $this->op_number, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('linkedid', $this->linkedid, true);
		$criteria->compare('uniqueid', $this->uniqueid, true);
		$criteria->compare('cid_chan', $this->cid_chan, true);
		$criteria->compare('op_chan', $this->op_chan, true);
		$criteria->compare('user_id', $this->user_id, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}