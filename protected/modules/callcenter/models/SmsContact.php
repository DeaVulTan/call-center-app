<?php

/**
 * This is the model class for table "sms_contact".
 *
 * The followings are the available columns in table 'sms_contact':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $number
 * @property string $description
 *
 * The followings are the available model relations:
 * @property User $user
 */
class SmsContact extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SmsContact the static model class
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
        return 'sms_contact';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['title, number', 'required'],
            ['user_id', 'numerical', 'integerOnly' => true],
            ['title', 'length', 'max' => 64],
            ['number', 'length', 'max' => 16],
            ['description', 'length', 'max' => 256],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, user_id, title, number, description', 'safe', 'on' => 'search'],
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
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => Yii::t('admin', 'Пользователь'),
            'title' => Yii::t('admin', 'ФИО'),
            'number' => Yii::t('admin', 'Номер'),
            'description' => Yii::t('admin', 'Комментарий'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', Yii::app()->user->getId());
        $criteria->compare('title', $this->title, true);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    public static function getContactList()
    {
        $data = [null => 'выбрать контакт'];
        $data += CHtml::listData(SmsContact::model()->findAll('user_id = ' . Yii::app()->user->getId(), ['select' => 'id, title'], ['order' => 'title']), 'id', 'title');
        return $data;
    }
}