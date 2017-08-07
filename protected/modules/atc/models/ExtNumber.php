<?php

/**
 * Модель для таблицы "ext_number".
 *
 * Доступные колонки в таблице 'ext_number':
 * @property integer $id
 * @property string $number
 * @property string $route
 * @property string $value
 * @property integer $error_file
 * @property integer $status
 */
class ExtNumber extends CActiveRecord {

    //Список действий для Внеших номеров
    public $listEvents = array(
        'num' => array('id' => 'num', 'name' => 'Вызвать номер', 'model' => '', 'param' => '', 'type' => 'text'), //параметр: номер телефона
        'ivr' => array('id' => 'ivr', 'name' => 'Перевести на IVR', 'model' => 'MainIvr', 'param' => array('id' => 'id', 'name' => 'name'), 'type' => 'select'), //параметр: id голосового меню
        'group' => array('id' => 'group', 'name' => 'Перевести на службу', 'model' => 'Group', 'param' => array('id' => 'id', 'name' => 'name'), 'type' => 'select'), //параметр: имя службы
        'time' => array('id' => 'time', 'name' => 'Перевод на правило по времени', 'model' => 'TimeCondition', 'param' => array('id' => 'id', 'name' => 'name'), 'type' => 'select'), //параметр: id правила по времени
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record класс.
     * @return ExtNumber статический класс модели
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ext_number';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('number, route, value, status', 'required'),
            array('error_file, status', 'numerical', 'integerOnly' => true),
            array('number, value', 'length', 'max' => 100),
            array('route', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, number, route, value, error_file, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('application', 'ID'),
            'number' => Yii::t('application', 'Number'),
            'route' => Yii::t('application', 'Route'),
            'value' => Yii::t('application', 'Value'),
            'error_file' => Yii::t('application', 'Error File'),
            'status' => Yii::t('application', 'Status'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('route', $this->route, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('error_file', $this->error_file);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => 100,
            ),
            'criteria' => $criteria,
        ));
    }

    public function getRouteValue($route, $value) {
        if ($route == 'num')
            return $value;
        $route_param = $this->listEvents[$route];
        switch ($route_param['type']) {
            case 'text':
                return $value;
                break;
            case 'select':
                $modelVal = $route_param['model']::model()->findByPk($value);
                return $modelVal ? $modelVal->name : null;
                break;
            case 'hidden':
                return $value;
                break;
            default:
                return $value;
                break;
        }
    }

}