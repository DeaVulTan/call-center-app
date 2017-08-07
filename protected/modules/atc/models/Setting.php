<?php

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $value
 */
class Setting extends CActiveRecord
{
    const SMS = 1;
    const CACHE = 2;
    const SYS_MSG = 3;
    const BACKUP = 4;


    /**
     * возвращает список доступных групп настроек
     * @return array
     */
    public function getCategoryList($list = null)
    {
        $data = [
            self::SMS => 'Настройка SMS (Telnet)',
            self::CACHE => 'Настройки кеширования',
            self::SYS_MSG => 'Системные сообщения',
            self::BACKUP => 'Резервное копирование',
        ];

        if (is_array($list) && count($list) > 0) {
            return array_intersect_key($data, array_flip($list));
        }

        return $data;
    }

    public function getCategoryName($id)
    {
        return $this->getCategoryList()[$id];
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Setting the static model class
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
		return 'setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['name, title, value', 'required'],
			['name, title, value', 'length', 'max'=>255],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			['id, name, title, value', 'safe', 'on'=>'search'],
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
			'name' => 'Name',
			'title' => 'Title',
			'value' => 'Value',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

    static function getValue($name)
    {
        return Setting::model()->findByAttributes(['name' => $name])->value;
    }
}