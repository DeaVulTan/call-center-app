<?php

/**
 * This is the model class for table "report_template".
 *
 * The followings are the available columns in table 'report_template':
 * @property integer $id
 * @property string $name
 * @property string $sql
 * @property string $translate
 * @property integer $is_published
 */
class ReportTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReportTemplate the static model class
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
		return 'report_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sql', 'required'),
			array('name', 'length', 'max'=>45),
			array('name, sql, translate, is_published', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, sql, translate, is_published', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('application', 'Name'),
			'sql' => Yii::t('application', 'Template text'),
			'translate' => Yii::t('application', 'Translate template elements'),
            'is_published' => Yii::t('application', 'Is published'),
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
		$criteria->compare('sql',$this->sql,true);
		$criteria->compare('translate',$this->translate,true);
        $criteria->compare('is_published',$this->is_published,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}