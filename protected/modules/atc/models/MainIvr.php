<?php

/**
 * This is the model class for table "main_ivr".
 *
 * The followings are the available columns in table 'main_ivr':
 * @property integer $id
 * @property string $name
 * @property integer $file
 * @property integer $timeout
 *
 * The followings are the available model relations:
 * @property Events[] $events
 */
class MainIvr extends CActiveRecord
{
    //Список действия для IVR
    public $listEvents = [
        'num' => ['id'=>'num', 'name' => 'Вызвать номер', 'model' => '', 'param' => '', 'type' => 'text'], //параметр: номер телефона
        'sound' => ['id' => 'sound', 'name' => 'Проиграть звуковой файл', 'model' => 'Sound', 'param' => ['id' => 'id', 'name' => 'comment'], 'type' => 'select'], //параметр: id звукового файла
        'ivr' => ['id' => 'ivr', 'name' => 'Перевести на IVR', 'model' => 'MainIVR', 'param' => ['id' => 'id', 'name' => 'name'], 'type' => 'select'], //параметр: id голосового меню
        'queue' => ['id' => 'queue', 'name' => 'Перевести на очередь', 'model' => 'Group', 'param' => ['id' => 'id', 'name' => 'name'], 'type' => 'select'], //параметр: имя очереди
        'hangup' => ['id' => 'hangup', 'name' => 'Отбой', 'model' => '', 'param' => '', 'type' => 'hidden'], //без параметров
        'timecondition' => ['id' => 'timecondition', 'name' => 'Перевод на правило по времени', 'model' => 'TimeCondition', 'param' => ['id' => 'id', 'name' => 'name'], 'type' => 'select'], //параметр: id правила по времени
        'pokazaniya' => ['id' => 'pokazaniya', 'name' => 'Показания счетчиков', 'model' => '', 'param' => '', 'type' => 'hidden'], //без параметров
	];
    
    //Список возможных событий
    public $eventKeys = [
//        array('id'=>'t', 'name' => 'Тайм-аут ввода', 'required' => 1),
//        array('id'=>'i', 'name' => 'Ошибочный ввод', 'required' => 1),
        ['id'=>'*', 'name' => 'Нажата кнопка *', 'required' => 0],
        ['id'=>'#', 'name' => 'Нажата кнопка #', 'required' => 0],
        ['id'=>'0', 'name' => 'Нажата кнопка 0', 'required' => 0],
        ['id'=>'1', 'name' => 'Нажата кнопка 1', 'required' => 0],
        ['id'=>'2', 'name' => 'Нажата кнопка 2', 'required' => 0],
        ['id'=>'3', 'name' => 'Нажата кнопка 3', 'required' => 0],
        ['id'=>'4', 'name' => 'Нажата кнопка 4', 'required' => 0],
        ['id'=>'5', 'name' => 'Нажата кнопка 5', 'required' => 0],
        ['id'=>'6', 'name' => 'Нажата кнопка 6', 'required' => 0],
        ['id'=>'7', 'name' => 'Нажата кнопка 7', 'required' => 0],
        ['id'=>'8', 'name' => 'Нажата кнопка 8', 'required' => 0],
        ['id'=>'9', 'name' => 'Нажата кнопка 9', 'required' => 0],
	];
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MainIvr the static model class
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
		return 'main_ivr';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			['name, file, timeout', 'required'],
			['file, timeout', 'numerical', 'integerOnly'=>true],
			['name', 'length', 'max'=>100],
			['id, name, file, timeout', 'safe', 'on'=>'search'],
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
			'ivrevents' => [self::HAS_MANY, 'IvrEvents', 'type_val',
                           'condition'=>'ivrevents.type=\'ivr\''],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('application', 'ID'),
			'name' => Yii::t('application', 'Name'),
			'file' => Yii::t('application', 'File'),
			'timeout' => Yii::t('application', 'Timeout'),
			'is_main' => Yii::t('application', 'Главный IVR'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('file',$this->file);
		$criteria->compare('timeout',$this->timeout);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}
}