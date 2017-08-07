<?php

/**
 * This is the model class for table "notes".
 *
 * The followings are the available columns in table 'notes':
 * @property integer $id
 * @property string $name
 * @property integer $groupId
 *
 * The followings are the available model relations:
 * @property Group $group
 */
class Notes extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Notes the static model class
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
        return 'notes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name, groupId', 'required'],
            ['groupId', 'numerical', 'integerOnly' => true],
            ['name', 'length', 'max' => 255],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, name, groupId', 'safe', 'on' => 'search'],
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
            'group' => [self::BELONGS_TO, 'Group', 'groupId'],
            'fields' => [self::HAS_MANY, 'NoteField', 'group_id', 'order' => 'fields.sort ASC'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('application', 'Name'),
            'groupId' => Yii::t('application', 'Group'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('groupId', $this->groupId);

        return new CActiveDataProvider($this, [
            'pagination' => [
                'pageSize' => 100,
            ],
            'criteria' => $criteria,
        ]);
    }

    public function getFieldsJson()
    {
        $data = [];
        $fields = $this->fields;

        /** @var NoteField $field */
        foreach ($fields as $field) {
            $data[] = [
                'id' => $field->id,
                'type' => $field->field_type,
                'required' => (bool)$field->is_important,
                'title' => $field->name,
                'options' => $field->options,
            ];
        }
        return CJSON::encode($data);
    }

    public function saveFields($newData)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $fieldList = [];
            $fields = NoteField::model()->findAllByAttributes(['group_id' => $this->id]);
            foreach ($newData as $order => $data) {
                /** @var NoteField $field */
                $field = null;
                if (array_key_exists('id', $data) && !empty($data['id'])) {
                    $field = NoteField::model()->findByPk($data['id']);
                }

                if (empty($field)) {
                    $field = new NoteField;
                } else {
                    $fieldList[] = $data['id'];
                }

                $field->name = (array_key_exists('title', $data)) ? $data['title'] : '';
                $field->field_type = $data['type'];
                $field->is_important = (array_key_exists('required', $data)) ? '1' : '0';
                $field->options = (array_key_exists('options', $data)) ? $data['options'] : '';
                $field->sort = $order;
                $field->group_id = $this->id;
                $field->save();
            }


            foreach ($fields as $field) {
                if (!in_array($field->id, $fieldList)) {
                    $field->delete();
                }
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }
}