<?php

/**
 * This is the model class for table "note_field".
 *
 * The followings are the available columns in table 'note_field':
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $field_type
 * @property integer $is_important
 * @property string $options
 * @property integer $sort
 *
 * The followings are the available model relations:
 * @property Notes $group
 * @property NoteValues[] $noteValues
 */
class NoteField extends CActiveRecord
{
	public $note_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NoteField the static model class
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
		return 'note_field';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, name, field_type', 'required'),
			array('group_id, is_important, sort', 'numerical', 'integerOnly'=>true),
			array('name, options', 'length', 'max'=>255),
			array('field_type', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, note_name, name, field_type, is_important', 'safe', 'on'=>'search'),
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
			'note' => array(self::BELONGS_TO, 'Notes', 'group_id'),
			'noteValues' => array(self::HAS_MANY, 'NoteValues', 'field_type'),
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
			'note_name' => Yii::t('application','Note'),
			'group_id' => Yii::t('application','Note'),
			'field_type' => Yii::t('application','Field Type'),
            'is_important' => Yii::t('application', 'Обязательно для заполнения'),
			'options' => Yii::t('application', 'Дополнительные опции'),
			'sort' => Yii::t('application', 'Порядок сортировки'),
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
		$criteria->with = array('note');
		$criteria->compare('note.name', $this->note_name, true);

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('field_type',$this->field_type,true);
        $criteria->compare('is_important',$this->is_important,true);
		$criteria->compare('options', $this->options, true);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => 100,
			),
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'note_name'=>array(
						'asc'=>'note.name',
						'desc'=>'note.name DESC',
					),
					'*',
				),
			),
		));
	}
}