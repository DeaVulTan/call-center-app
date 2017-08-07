<?php

/**
 * Модель для таблицы "redirect_in_group".
 *
 * Доступные колонки в таблице 'redirect_in_group':
 * @property integer $id
 * @property integer $group_id
 * @property string $name
 * @property string $number
 * @property string $addition
 * @property integer $timeout
 * @property integer $common
 * @property string $prefix
 *
 * Связи таблицы:
 * @property Group $group
 */
class Switching extends CActiveRecord
{
	public $group_name;
	public $import_file;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return Switching статический класс модели
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
		return 'redirect_in_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, number, timeout', 'required'),
			array('common, group_id, timeout', 'numerical', 'integerOnly'=>true),
			array('name, number', 'length', 'max'=>250),
			array('addition', 'length', 'max'=>100),
            array('prefix', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, prefix, number, group_name, addition, timeout, common', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => Yii::t('application', 'ID'),
            'group_name' => Yii::t('application', 'Group'),
            'name' => Yii::t('application', 'Name'),
            'number' => Yii::t('application', 'Number'),
            'addition' => Yii::t('application', 'Addition'),
            'timeout' => Yii::t('application', 'Timeout'),
            'group_id' => Yii::t('application', 'Group'),
            'common' => Yii::t('application', 'Common Group'),
            'prefix' => Yii::t('application', 'Prefix'),
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
		$criteria->compare('group.name', $this->group_name, true);
		$criteria->compare('t.name',$this->name,true);
		if (!empty($this->group_name) && strpos('общая', strtolower($this->group_name)) !== false) {
			$criteria->compare('common',1,false,'OR');
		}
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('addition',$this->addition,true);
		$criteria->compare('timeout',$this->timeout);
		$criteria->compare('prefix',$this->prefix);
		$criteria->with = array('group');

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => 100,
			),
			'criteria'=>$criteria,
		));
	}

    /**
     * Отбор по ID службы
     *
     * @param $userId
     * @return $this
     */
    public function scopeUser($userId=null)
    {
        $groupIds = User::model()->getUserGroupIds($userId);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('group_id', $groupIds);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
}