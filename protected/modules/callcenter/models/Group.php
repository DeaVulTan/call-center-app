<?php

/**
 * Модель для таблицы "group".
 *
 * Доступные колонки в таблице 'group':
 * @property integer $id
 * @property string $name
 * @property string $folder
 * @property string $callerid
 * @property string $icon
 * @property string $color
 * @property string $qname
 * @property integer $deleted
 * @property integer $is_sms_auto_send
 * @property integer $is_sms_send_period
 * @property string $sms_sender
 * @property string $sms_text
 * @property integer $music_file_id
 * @property integer is_save_notes
 * @property string save_notes_path
 * @property string save_notes_delimiter
 * @property string save_notes_file_format
 * @property integer $is_need_notes
 * @property string $sla
 * @property integer $is_sms_timeout
 * @property integer $is_sms_percent
 * @property integer $is_sms_limit
 * @property integer $is_empty_group_sms
 *
 *
 * Связи таблицы:
 * @property QueueTable $qname0
 * @property Switching[] $switching
 */
class Group extends CActiveRecord
{
	public $iconFile;
    public $deleteFile;

    const CD_RINGALL = 'ringall'; // Одновременно все свободные (ringall)
    const CD_LEASTRECENT = 'leastrecent'; // Наиболее давний вызываемый (leastrecent)
    const CD_FEWESTCALLS = 'fewestcalls'; // Наименьшее кол-во обсл. вызовов (fewestcalls)
    const CD_RANDOM = 'random'; // Случайным образом (random)
    const CD_RRMEMORY = 'rrmemory'; // Циклично с запоминанием последнего ответившего (rrmemory)
    const CD_LINEAR = 'linear'; // По порядку, с первого подключившегося (linear)
    const CD_WRANDOM = 'wrandom'; // Случайным образом с запоминанием последнего ответившего (wrandom)

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return Group статический класс модели
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
		return 'group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, folder, color, qname', 'required'),
			array('name, folder, callerid, icon, qname, sms_sender, save_notes_file_format', 'length', 'max' => 100),
            array('sms_text, save_notes_path', 'length', 'max' => 255),
            array('is_sms_auto_send, is_sms_send_period, music_file_id, is_save_notes, is_need_notes, is_sms_timeout, is_sms_percent, is_sms_limit, is_empty_group_sms', 'numerical', 'integerOnly'=>true),
			array('color', 'length', 'max' => 10),
			array('save_notes_delimiter, sla', 'length', 'max' => 32),
			array('iconFile', 'file', 'types' => 'jpg, gif, png', 'maxSize' => 1024 * 100, // 100KB
				'allowEmpty' => 'true',
				'tooLarge' => Yii::t('application', 'The file was larger than 100KB. Please upload a smaller file.'),),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iconFile, deleteFile', 'safe'),
            array('timeout', 'numerical'),
            array('redirect_num', 'length', 'max' => 20),
			array('id, name, folder, callerid, icon, color, qname, is_sms_auto_send, is_sms_send_period, sms_sender, sms_text, music_file_id', 'safe', 'on' => 'search'),
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
			'qname0' => array(self::BELONGS_TO, 'QueueTable', 'qname'),
			'users' => array(self::HAS_MANY, 'GroupUsers', 'group_id'),
			'switching' => array(self::HAS_MANY, 'switching', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('application', 'ID'),
			'name' => Yii::t('application', 'Name'),
			'folder' => Yii::t('application', 'Folder'),
			'callerid' => Yii::t('application', 'Callerid'),
			'icon' => Yii::t('application', 'Icon'),
			'iconFile' => Yii::t('application', 'IconFile'),
			'color' => Yii::t('application', 'Color'),
			'qname' => Yii::t('application', 'Qname'),
            'is_sms_auto_send' => Yii::t('application', 'Is sms auto send'),
            'is_sms_send_period' => Yii::t('application', 'Is sms send period'),
            'sms_sender' => Yii::t('application', 'Sms sender'),
            'sms_text' => Yii::t('application', 'Sms text'),
            'music_file_id' => Yii::t('application', 'Сообщение, при невозможности поставить вызов в очередь'),
            'deleteFile' => Yii::t('application', 'Удалить иконку службы'),
            'is_save_notes' => Yii::t('application', 'Сохранять заметки в текстовом формате'),
            'save_notes_path' => Yii::t('application', 'Название папки'),
            'save_notes_delimiter' => Yii::t('application', 'Разделитель поля'),
            'save_notes_file_format' => Yii::t('application', 'Формат имени'),
            'sla' => Yii::t('application', 'Service Level'),
            'is_need_notes' => Yii::t('application', 'Использовать в службе заметки'),
            'is_sms_timeout' => Yii::t('application', 'Отправлять СМС о превышении времени ожидания'),
            'is_sms_percent' => Yii::t('application', 'Отправлять СМС о падении процента обслуженных'),
            'is_sms_limit' => Yii::t('application', 'Отправлять СМС о превышении порога звонков'),
            'is_empty_group_sms' => Yii::t('application', 'Отправлять СМС при звонках когда в службе нет операторов'),
            'timeout' => Yii::t('application', 'Лимит ожидания в очереди (сек)'),
            'redirect_num' => Yii::t('application', 'Номер переадресации при достижении лимита ожидания или при невозможности поставить вызов в очередь'),
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('folder', $this->folder, true);
		$criteria->compare('callerid', $this->callerid, true);
		$criteria->compare('icon', $this->icon, true);
		$criteria->compare('color', $this->color, true);
		$criteria->compare('qname', $this->qname, true);
        $criteria->compare('music_file_id', $this->music_file_id, true);
        $criteria->compare('deleted', 0);

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => 100,
			),
			'criteria' => $criteria,
		));
	}

    public function getCallDistributionList()
    {
        return [
            null => 'Не выбрано',
            self::CD_RINGALL => 'Одновременно все свободные (ringall)',
            self::CD_LEASTRECENT => 'Наиболее давний вызываемый (leastrecent)',
            self::CD_FEWESTCALLS => 'Наименьшее кол-во обсл. вызовов (fewestcalls)',
            self::CD_RANDOM => 'Случайным образом (random)',
            self::CD_RRMEMORY => 'Циклично с запоминанием последнего ответившего (rrmemory)',
            self::CD_LINEAR => 'По порядку, с первого подключившегося (linear)',
            self::CD_WRANDOM => 'Случайным образом с запоминанием последнего ответившего (wrandom)'
        ];
    }

	public function icon_image()
	{
		if ($this->icon && file_exists(Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $this->icon)) {
			$url = Yii::app()->assetManager->publish(
				Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $this->icon
			);
			echo CHtml::image($url);
		}
		else return '';
	}

    static function getIconUrl($icon = null)
    {
        if (!empty($icon) && file_exists(Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $icon)) {
            $url = Yii::app()->assetManager->publish(
                Yii::app()->params['groupIconDir'] . DIRECTORY_SEPARATOR . $icon
            );
            return $url;
        } else {
            return '';
        }
    }

	public function clearChainedUsers()
	{
		$criteria = new CDbCriteria;
		$criteria->condition = 'group_id=:group_id';
		$criteria->params = array(':group_id' => $this->id);
		if (!GroupUsers::model()->deleteAll($criteria)) {
			VarDumper::dump('Chained user delete failed');
		}
	}
}
