<?php

/**
 * This is the model class for table "note_values".
 *
 * The followings are the available columns in table 'note_values':
 * @property integer $id
 * @property integer $field_type
 * @property string $linkedid
 * @property string $value
 *
 * The followings are the available model relations:
 * @property GroupCallRealtime $groupCall
 * @property CallLog $callLog
 * @property NoteField $fieldType
 */
class NoteValues extends CActiveRecord {
    
    public $note_values_id, $gc_qname, $field_type_name, $gc_user_username, $groupCall_time_in;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NoteValues the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'note_values';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('field_type, linkedid, value', 'required'),
            array('field_type', 'numerical', 'integerOnly' => true),
            array('value, linkedid', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, field_type, linkedid, value, note_values_id, gc_qname, field_type_name, gc_user_username', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        Yii::app()->getModule('statistics');

        return array(
            'groupCall' => array(self::BELONGS_TO, 'GroupCallRealtime', ['linkedid' => 'linkedid']),
            'callLog' =>  array(self::BELONGS_TO, 'CallLog', ['linkedid' => 'linkedid']),
            'fieldType' => array(self::BELONGS_TO, 'NoteField', 'field_type'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'field_type' => 'Field Type',
            'linkedid' => 'Group Call',
            'value' => 'Value',
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

        $criteria->compare('t.id', $this->note_values_id);
        $criteria->compare('t.field_type', $this->field_type_name);
        $criteria->compare('callLog.queue', $this->gc_qname);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('t.linkedid', $this->linkedid, true);
        $criteria->compare('user.id', $this->gc_user_username);
        $criteria->with = array('callLog', 'callLog.user', 'callLog.vip', 'fieldType');
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => 100,
            ),
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.ID DESC',
            ),
        ));
    }
}
