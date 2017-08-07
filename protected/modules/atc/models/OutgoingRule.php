<?php

/**
 * This is the model class for table "outgoing_rule".
 *
 * The followings are the available columns in table 'outgoing_rule':
 * @property string $id
 * @property string $name
 * @property integer $len
 * @property string $prefix
 * @property integer $cut
 * @property string $add
 * @property string $callerid
 * @property integer $trunk
 */
class OutgoingRule extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OutgoingRule the static model class
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
        return 'outgoing_rule';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name', 'required'],
            ['len, cut, trunk', 'numerical', 'integerOnly'=>true],
            ['name, prefix', 'length', 'max'=>100],
            ['add, callerid', 'length', 'max'=>255],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, name, len, prefix, cut, add, callerid, trunk', 'safe', 'on'=>'search'],
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
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'len' => 'Длина номера',
            'prefix' => 'Префикс',
            'cut' => 'Отрезать',
            'add' => 'Добавить',
            'callerid' => 'CallerID',
            'trunk' => 'Транк',
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('len',$this->len);
        $criteria->compare('prefix',$this->prefix,true);
        $criteria->compare('cut',$this->cut);
        $criteria->compare('add',$this->add,true);
        $criteria->compare('callerid',$this->callerid,true);
        $criteria->compare('trunk',$this->trunk);

        return new CActiveDataProvider($this, [
            'criteria'=>$criteria,
        ]);
    }


    /**
     * Генерация шаблона номера
     *
     * Отображаться он должен следующим образом, например, 8ХХХХХХХХХХ. Это значит префикс=8, а длина номера=10.
     * Префикс входит в длину, например, если длина=5, префикс=99, то шаблон: 99ХХХ
     * Если указана только длина номера, без префикса, то отображаем так: ХХХХХ (длина=5, префикс не указан)
     *
     * @return string
     */
    public function getNumberTemplate()
    {
        $result = $this->prefix;
        if ((int) $this->len > 0) {
            if ($this->len - strlen($this->prefix) > 0) {
                $result .= str_repeat('X', $this->len - strlen($this->prefix));
            }
        } else { // Если указан префикс, но не указана длина номера, то шаблон указывается с точкой, например, 8. (Префикс=8, длина не указана)
            $result .= '.';
        }

        // Если нет префикса и нет длины, то в шаблоне указывается Х. (с точкой)
        if (empty($this->prefix) && empty($this->len)) {
            $result = "X.";
        }
        return $result;
    }
}