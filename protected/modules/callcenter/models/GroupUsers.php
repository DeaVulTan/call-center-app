<?php

/**
 * Модель для таблицы "group_users".
 *
 * Доступные колонки в таблице 'group_users':
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $penalty
 */
class GroupUsers extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record класс.
     * @return GroupUsers статический класс модели
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'group_users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('group_id, user_id', 'required'),
            array('group_id, user_id, penalty', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('group_id, user_id, penalty', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'groupn' => array(self::BELONGS_TO, 'Group', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'group_id' => Yii::t('application', 'Group'),
            'user_id' => Yii::t('application', 'User'),
            'penalty' => Yii::t('application', 'Penalty'),
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

        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('penalty', $this->penalty);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}