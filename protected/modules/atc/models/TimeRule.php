<?php

/**
 * This is the model class for table "time_rule".
 *
 * The followings are the available columns in table 'time_rule':
 * @property integer $id
 * @property integer $condition_id
 * @property string $time
 * @property string $dow
 * @property string $dom
 * @property string $mon
 */
class TimeRule extends CActiveRecord
{
    public $time_from,
        $time_to,
        $dow_from,
        $dow_to,
        $dom_from,
        $dom_to,
        $mon_from,
        $mon_to;

    public $listDow = array(
        ''  => array('id'=> null, 'name' => 'Не выбрано'),
        'sun' => array('id'=>'sun', 'name' => 'Воскресенье', 'short' => 'Вс'),
        'mon' => array('id'=>'mon', 'name' => 'Понедельник', 'short' => 'Пн'),
        'tue' => array('id'=>'tue', 'name' => 'Вторник', 'short' => 'Вт'),
        'wed' => array('id'=>'wed', 'name' => 'Среда', 'short' => 'Ср'),
        'thu' => array('id'=>'thu', 'name' => 'Четверг', 'short' => 'Чт'),
        'fri' => array('id'=>'fri', 'name' => 'Пятница', 'short' => 'Пт'),
        'sat' => array('id'=>'sat', 'name' => 'Суббота', 'short' => 'Сб'),
    );

    public $listMon = array(
        ''  => array('id'=> null, 'name' => 'Не выбрано'),
        'jan' => array('id'=>'jan', 'name' => 'Январь', 'short' => 'Янв'),
        'feb' => array('id'=>'feb', 'name' => 'Февраль', 'short' => 'Фев'),
        'mar' => array('id'=>'mar', 'name' => 'Март', 'short' => 'Март'),
        'apr' => array('id'=>'apr', 'name' => 'Апрель', 'short' => 'Апр'),
        'may' => array('id'=>'may', 'name' => 'Май', 'short' => 'Май'),
        'jun' => array('id'=>'jun', 'name' => 'Июнь', 'short' => 'Июнь'),
        'jul' => array('id'=>'jul', 'name' => 'Июль', 'short' => 'Июль'),
        'aug' => array('id'=>'aug', 'name' => 'Август', 'short' => 'Авг'),
        'sep' => array('id'=>'sep', 'name' => 'Сентябрь', 'short' => 'Сент'),
        'oct' => array('id'=>'oct', 'name' => 'Октябрь', 'short' => 'Окт'),
        'nov' => array('id'=>'nov', 'name' => 'Ноябрь', 'short' => 'Ноя'),
        'dec' => array('id'=>'dec', 'name' => 'Декабрь', 'short' => 'Дек'),
    );

    public function listDom($required=false)
    {
        $data = ($required) ? [] : ['' => 'Не выбрано'];
        for ($i = 1; $i <= 31; $i++) {
            $data[$i] = $i;
        }
        return $data;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TimeRule the static model class
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
        return 'time_rule';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('condition_id', 'numerical', 'integerOnly'=>true),
            array('time', 'length', 'max'=>11),
            array('dow, dom, mon', 'length', 'max'=>500),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, condition_id, time, dow, dom, mon', 'safe', 'on'=>'search'),
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
            'condition_id' => 'Правило по времени',
            'time' => 'Время',
            'dow' => 'День недели',
            'dom' => 'День месяца',
            'mon' => 'Месяц',
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
        $criteria->compare('condition_id',$this->condition_id);
        $criteria->compare('time',$this->time,true);
        $criteria->compare('dow',$this->dow,true);
        $criteria->compare('dom',$this->dom,true);
        $criteria->compare('mon',$this->mon,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getShortName($listName, $name)
    {
        $result = '';
        $list = $this->{$listName};

        $split = explode('-', $name);
        if (!is_array($split) || count($split) != 2) {
            return isset($list[$name]['short']) ? $list[$name]['short'] : $name;
        }

        if (array_key_exists($split[0], $list)) {
            $result .= $list[$split[0]]['short'] . ' - ';
        } else {
            $result .= '* -';
        }

        if (array_key_exists($split[1], $list)) {
            $result .= $list[$split[1]]['short'];
        } else {
            $result .= '*';
        }

        return $result;
    }
}