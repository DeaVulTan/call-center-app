<?php

/**
 * This is the model class for table "autodial_numbers".
 *
 * The followings are the available columns in table 'autodial_numbers':
 * @property string $id
 * @property integer $autodialid
 * @property string $number
 * @property string $trytime
 * @property integer $iter
 * @property integer $status
 */
class AutodialNumbers extends CActiveRecord
{
    public $import_is_duplicate = false;
    public $import_file;
    public $status_list = [
        0 => 'не было попыток',
        1 => 'дозвонились',
        2 => 'попытка дозвона',
    ];

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'autodial_numbers';
    }

    public function rules()
    {
        return array(
            array('autodialid, number', 'required'),
            array('autodialid, iter, status', 'numerical', 'integerOnly' => true),
            array('number', 'length', 'max' => 100),
            array('trytime', 'safe'),
            array('id, autodialid, number, trytime, iter, status', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'autodialid' => 'Задание автообзвона',
            'number'     => 'Телефонный номер',
            'trytime'    => 'Время звонка',
            'iter'       => 'Остаток повторений',
            'status'     => 'Статус',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('autodialid', $this->autodialid);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('trytime', $this->trytime, true);
        $criteria->compare('iter', $this->iter);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize'=>'100'
            )
        ));
    }

    protected function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        $this->number = trim($this->number);

        $Number = AutodialNumbers::model()->findByAttributes(['number' => $this->number, 'autodialid' => $this->autodialid]);
        if ($Number && $Number->id != $this->id) {
            $this->import_is_duplicate = true;
            $this->addError('number', 'Номер уже существует в указанном задании');

            return false;
        }

        return true;
    }
}
