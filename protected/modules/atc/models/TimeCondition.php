<?php

/**
 * This is the model class for table "time_condition".
 *
 * The followings are the available columns in table 'time_condition':
 * @property integer $id
 * @property string $name
 * @property string $event_true
 * @property string $value_true
 * @property string $event_false
 * @property string $value_false
 */
class TimeCondition extends CActiveRecord
{
    public $listEvents = [
        'num' => array('id'=>'num', 'name' => 'Вызвать номер'), //параметр: номер телефона
        'sound' => array('id' => 'sound', 'name' => 'Проиграть звуковой файл'), //параметр: id звукового файла
        'ivr' => array('id' => 'ivr', 'name' => 'Перевести на IVR'), //параметр: id голосового меню
        'queue' => array('id' => 'queue', 'name' => 'Перевести на очередь'), //параметр: имя очереди
        'hangup' => array('id' => 'hangup', 'name' => 'Отбой'), //без параметров
    ];

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TimeCondition the static model class
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
        return 'time_condition';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'length', 'max'=>200),
            array('event_true, value_true, event_false, value_false', 'length', 'max'=>100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, event_true, value_true, event_false, value_false', 'safe', 'on'=>'search'),
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
            'name' => 'Название',
            'event_true' => 'Попал, действие',
            'value_true' => 'Попал, параметр',
            'event_false' => 'Не попал, действие',
            'value_false' => 'Не попал, параметр',
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
        $criteria->compare('event_true',$this->event_true,true);
        $criteria->compare('value_true',$this->value_true,true);
        $criteria->compare('event_false',$this->event_false,true);
        $criteria->compare('value_false',$this->value_false,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getConditionList()
    {
        $data = [
            null => 'Не выбрано'
        ];
        $data += CHtml::listData(
            TimeCondition::model()->findAll(array('order' => 'name')),
            'id',
            'name'
        );
        return $data;
    }

    /**
     * Получение осмысленного значения параметра события
     *
     * @param $event string
     * @param $value string
     * @return string
     */
    public function getEventValue ($event, $value)
    {
        switch ($event) {
            case 'num':
                $result = $value;
                break;
            case 'sound':
                $result = Sound::model()->findByPk($value)->comment;
                break;
            case 'ivr':
                $result = MainIvr::model()->findByPk($value)->name;
                break;
            case 'queue':
                $result = Group::model()->findByPk($value)->name;
                break;
            default:
                $result = '';
        }

        return $result;
    }

    public function getEventName ($event)
    {
        return $this->listEvents[$event]['name'];
    }
}