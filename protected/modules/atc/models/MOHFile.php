<?php

/**
 * This is the model class for table "music_on_hold_file".
 *
 * The followings are the available columns in table 'music_on_hold_file':
 * @property integer $id
 * @property integer $context_id
 * @property string $name
 * @property string $comment
 */
class MOHFile extends CActiveRecord
{
    public $mohId;
    public $soundfile;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOHFile the static model class
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
		return 'music_on_hold_file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment, soundfile', 'required'),
			array('context_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, context_id, name, comment, soundfile', 'safe', 'on'=>'search'),
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
            'id' => Yii::t('application', 'ID'),
			'context_id' => 'Context',
            'name' => Yii::t('application', 'Name'),
            'comment' => Yii::t('application', 'Comment'),
            'soundfile' => Yii::t('application', 'soundfile'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(Musiconhold $mohModel = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if($mohModel) {
		    $criteria->condition  = 'context_id =:moh_id';
		    $criteria->params = array('moh_id' => $mohModel->cat_metric);
		}
		$criteria->compare('id',$this->id);
		$criteria->compare('context_id',$this->context_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getMusicFileList()
    {
        $data = [
            null => 'Не выбрано'
        ];
        $data += CHtml::listData(
            MOHFile::model()->findAll(array('order' => 'comment')),
            'id',
            'comment'
        );
        return $data;
    }
}