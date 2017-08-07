<?php

/**
 * This is the model class for table "vip".
 *
 * The followings are the available columns in table 'vip':
 * @property string $id
 * @property string $name
 * @property string $organization
 * @property string $tel1
 * @property string $tel2
 * @property string $tel3
 * @property string $email
 * @property string $icon
 * @property string $ivr_id
 * @property string $type_of_hello
 * @property string $pic
 */
class Vip extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vip the static model class
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
		return 'vip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, organization, tel1, tel2, tel3, email, icon, ivr_id, type_of_hello, pic', 'required'),
			array('name, tel1', 'length', 'max'=>300),
			array('organization, pic', 'length', 'max'=>200),
			array('tel2, tel3, ivr_id', 'length', 'max'=>100),
			array('email', 'length', 'max'=>50),
			array('type_of_hello', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, organization, tel1, tel2, tel3, email, icon, ivr_id, type_of_hello, pic', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('application','Name'),
			'organization' => Yii::t('application','Organization'),
			'tel1' => Yii::t('application','Tel1'),
			'tel2' => Yii::t('application','Tel2'),
			'tel3' => Yii::t('application','Tel3'),
			'email' => Yii::t('application','Email'),
			'icon' => Yii::t('application','Icon'),
			'ivr_id' => Yii::t('application','Ivr'),
			'type_of_hello' => Yii::t('application','Type Of Hello'),
			'pic' => Yii::t('application','Pic'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('tel1',$this->tel1,true);
		$criteria->compare('tel2',$this->tel2,true);
		$criteria->compare('tel3',$this->tel3,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('ivr_id',$this->ivr_id,true);
		$criteria->compare('type_of_hello',$this->type_of_hello,true);
		$criteria->compare('pic',$this->pic,true);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => 100,
			),
			'criteria'=>$criteria,
		));
	}
}