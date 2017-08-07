<?php

/**
 * Модель для таблицы "events".
 *
 * Доступные колонки в таблице 'events':
 * @property integer $id
 * @property string $key
 * @property string $event
 * @property string $value
 * @property string $type
 * @property string $type_val
 */
class IvrEvents extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return IvrEvents статический класс модели
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
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key, event, value, type, type_val', 'required'),
			array('key', 'length', 'max'=>5),
			array('event', 'length', 'max'=>20),
			array('value, type, type_val', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, key, event, value, type, type_val', 'safe', 'on'=>'search'),
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
			                'key' => Yii::t('application', 'Key'),
			                'event' => Yii::t('application', 'Event'),
			                'value' => Yii::t('application', 'Value'),
			                'type' => Yii::t('application', 'Type'),
			                'type_val' => Yii::t('application', 'Type Val'),
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
		$criteria->compare('key',$this->key,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_val',$this->type_val,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}