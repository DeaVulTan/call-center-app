<?php

/**
 * This is the model class for table "sound".
 *
 * The followings are the available columns in table 'sound':
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $comment
 */
class Sound extends CActiveRecord
{
    public $soundfile;

    const SOUND_TYPE_MAIN = 0;
    const SOUND_TYPE_IVR = 1;

    static $types = [
        self::SOUND_TYPE_MAIN => 'по умолчанию',
        self::SOUND_TYPE_IVR => 'звук для IVR',
    ];

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Sound the static model class
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
        return 'sound';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, comment', 'required'],
            ['type', 'numerical', 'integerOnly'=>true],
            ['name, comment, soundfile, type', 'safe', 'on' => 'search'],
            ['soundfile', 'file', 'allowEmpty' => true, 'types' => 'wav', 'maxSize' => 1024 * 1024 * 100, 'tooLarge' => 'Файл должен быть размером не более 100 Mб', 'on' => 'insert,update'],
            ['soundfile', 'required', 'on' => 'insert'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }

    public function scopes()
    {
        return array(
            'main'=>array(
                'condition' => 'type = 0'
            ),
            'ivr' => array(
                'condition' => 'type = 1'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('application', 'ID'),
            'name' => Yii::t('application', 'Name'),
            'type' => Yii::t('application', 'Назначение файла'),
            'comment' => Yii::t('application', 'Comment'),
            'soundfile' => Yii::t('application', 'soundfile'),
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
        $criteria->compare('type', $this->type);
        $criteria->compare('comment', $this->comment, true);

        return new CActiveDataProvider($this, [
            'pagination' => [
                'pageSize' => 100,
            ],
            'criteria' => $criteria,
        ]);
    }

    /**
     * Возвращает список файлок для селекта
     *
     * @return array
     */
    public function getSoundFileList()
    {
        $data = [
            null => 'Не выбрано'
        ];
        $data += CHtml::listData(
            Sound::model()->findAll(['order' => 'comment']),
            'id',
            'comment'
        );
        return $data;
    }
}