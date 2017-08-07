<?php

/**
 * Модель для таблицы "queue_table".
 *
 * Доступные колонки в таблице 'queue_table':
 * @property string $name
 * @property string $musiconhold
 * @property string $announce
 * @property string $context
 * @property integer $timeout
 * @property string $monitor_type
 * @property string $monitor_format
 * @property string $queue_youarenext
 * @property string $queue_thereare
 * @property string $queue_callswaiting
 * @property string $queue_holdtime
 * @property string $queue_minutes
 * @property string $queue_seconds
 * @property string $queue_lessthan
 * @property string $queue_thankyou
 * @property string $queue_reporthold
 * @property integer $announce_frequency
 * @property integer $announce_round_seconds
 * @property string $announce_holdtime
 * @property integer $retry
 * @property integer $wrapuptime
 * @property integer $maxlen
 * @property integer $servicelevel
 * @property string $strategy
 * @property string $joinempty
 * @property string $leavewhenempty
 * @property integer $eventmemberstatus
 * @property integer $eventwhencalled
 * @property integer $reportholdtime
 * @property integer $memberdelay
 * @property integer $weight
 * @property integer $timeoutrestart
 * @property string $ringinuse
 * @property integer $setinterfacevar
 * @property integer $welcomemsg
 * @property integer $maxwait
 * @property integer $operatormsg
 * @property integer $moh
 * @property integer $periodic_announce_frequency
 * @property string $queue_callerannounce
 *
 * Связи таблицы:
 * @property Group[] $groups
 */
class QueueTable extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return QueueTable статический класс модели
	 */

    public $strategyVariation = array(
        'ringall' => array('id' => 'ringall', 'name' => 'Одновременно все свободные (ringall)'), //rings all available callers (default)
        'leastrecent' => array('id' => 'leastrecent', 'name' => 'Наиболее давний вызываемый (leastrecent)'), //rings the interface that least recently received a call
        'fewestcalls' => array('id' => 'fewestcalls', 'name' => 'Наименьшее кол-во обсл. вызовов (fewestcalls)'), //rings the interface that has completed the fewest calls in this queue
        'random' => array('id' => 'random', 'name' => 'Случайным образом (random)'), //rings a random interface
        'rrmemory' => array('id' => 'rrmemory', 'name' => 'Циклично с запоминанием последнего ответившего (rrmemory)'), //rings members in a round-robin fashion, remembering where we left off last for the next caller
        'linear' => array('id' => 'linear', 'name' => 'По порядку, с первого подключившегося (linear)'), //rings members in the order specified, always starting at the beginning of the list
        'wrandom' => array('id' => 'wrandom', 'name' => 'Случайным образом с запоминанием последнего ответившего (wrandom)'), //rings a random member, but uses the members’ penalties as a weight.
    );
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'queue_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('timeout, wrapuptime, maxlen', 'numerical', 'integerOnly'=>true),
			array('name, musiconhold, strategy', 'length', 'max'=>128),
			array('ringinuse', 'length', 'max'=>3),
			array('queue_callerannounce', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, musiconhold, timeout, wrapuptime, maxlen, strategy', 'safe', 'on'=>'search'),
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
			'groups' => array(self::BELONGS_TO, 'Group', 'qname'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			                'name' => Yii::t('application', 'Name'),
			                'musiconhold' => Yii::t('application', 'Musiconhold'),
//			                'announce' => Yii::t('application', 'Announce'),
//			                'context' => Yii::t('application', 'Context'),
			                'timeout' => Yii::t('application', 'Timeout'),
//			                'monitor_type' => Yii::t('application', 'Monitor Type'),
//			                'monitor_format' => Yii::t('application', 'Monitor Format'),
//			                'queue_youarenext' => Yii::t('application', 'Queue Youarenext'),
//			                'queue_thereare' => Yii::t('application', 'Queue Thereare'),
//			                'queue_callswaiting' => Yii::t('application', 'Queue Callswaiting'),
//			                'queue_holdtime' => Yii::t('application', 'Queue Holdtime'),
//			                'queue_minutes' => Yii::t('application', 'Queue Minutes'),
//			                'queue_seconds' => Yii::t('application', 'Queue Seconds'),
//			                'queue_lessthan' => Yii::t('application', 'Queue Lessthan'),
//			                'queue_thankyou' => Yii::t('application', 'Queue Thankyou'),
//			                'queue_reporthold' => Yii::t('application', 'Queue Reporthold'),
//			                'announce_frequency' => Yii::t('application', 'Announce Frequency'),
//			                'announce_round_seconds' => Yii::t('application', 'Announce Round Seconds'),
//			                'announce_holdtime' => Yii::t('application', 'Announce Holdtime'),
//			                'retry' => Yii::t('application', 'Retry'),
			                'wrapuptime' => Yii::t('application', 'Wrapuptime'),
			                'maxlen' => Yii::t('application', 'Maxlen'),
//			                'servicelevel' => Yii::t('application', 'Servicelevel'),
			                'strategy' => Yii::t('application', 'Strategy'),
//			                'joinempty' => Yii::t('application', 'Joinempty'),
//			                'leavewhenempty' => Yii::t('application', 'Leavewhenempty'),
//			                'eventmemberstatus' => Yii::t('application', 'Eventmemberstatus'),
//			                'eventwhencalled' => Yii::t('application', 'Eventwhencalled'),
//			                'reportholdtime' => Yii::t('application', 'Reportholdtime'),
//			                'memberdelay' => Yii::t('application', 'Memberdelay'),
//			                'weight' => Yii::t('application', 'Weight'),
//			                'timeoutrestart' => Yii::t('application', 'Timeoutrestart'),
//			                'ringinuse' => Yii::t('application', 'Ringinuse'),
//			                'setinterfacevar' => Yii::t('application', 'Setinterfacevar'),
//			                'welcomemsg' => Yii::t('application', 'Welcomemsg'),
//			                'maxwait' => Yii::t('application', 'Maxwait'),
//			                'operatormsg' => Yii::t('application', 'Operatormsg'),
//			                'moh' => Yii::t('application', 'Moh'),
//			                'periodic_announce_frequency' => Yii::t('application', 'Periodic Announce Frequency'),
//			                'queue_callerannounce' => Yii::t('application', 'Queue Callerannounce'),
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('musiconhold',$this->musiconhold,true);
//		$criteria->compare('announce',$this->announce,true);
//		$criteria->compare('context',$this->context,true);
		$criteria->compare('timeout',$this->timeout);
//		$criteria->compare('monitor_type',$this->monitor_type,true);
//		$criteria->compare('monitor_format',$this->monitor_format,true);
//		$criteria->compare('queue_youarenext',$this->queue_youarenext,true);
//		$criteria->compare('queue_thereare',$this->queue_thereare,true);
//		$criteria->compare('queue_callswaiting',$this->queue_callswaiting,true);
//		$criteria->compare('queue_holdtime',$this->queue_holdtime,true);
//		$criteria->compare('queue_minutes',$this->queue_minutes,true);
//		$criteria->compare('queue_seconds',$this->queue_seconds,true);
//		$criteria->compare('queue_lessthan',$this->queue_lessthan,true);
//		$criteria->compare('queue_thankyou',$this->queue_thankyou,true);
//		$criteria->compare('queue_reporthold',$this->queue_reporthold,true);
//		$criteria->compare('announce_frequency',$this->announce_frequency);
//		$criteria->compare('announce_round_seconds',$this->announce_round_seconds);
//		$criteria->compare('announce_holdtime',$this->announce_holdtime,true);
//		$criteria->compare('retry',$this->retry);
		$criteria->compare('wrapuptime',$this->wrapuptime);
		$criteria->compare('maxlen',$this->maxlen);
//		$criteria->compare('servicelevel',$this->servicelevel);
		$criteria->compare('strategy',$this->strategy,true);
//		$criteria->compare('joinempty',$this->joinempty,true);
//		$criteria->compare('leavewhenempty',$this->leavewhenempty,true);
//		$criteria->compare('eventmemberstatus',$this->eventmemberstatus);
//		$criteria->compare('eventwhencalled',$this->eventwhencalled);
//		$criteria->compare('reportholdtime',$this->reportholdtime);
//		$criteria->compare('memberdelay',$this->memberdelay);
//		$criteria->compare('weight',$this->weight);
//		$criteria->compare('timeoutrestart',$this->timeoutrestart);
//		$criteria->compare('ringinuse',$this->ringinuse,true);
//		$criteria->compare('setinterfacevar',$this->setinterfacevar);
//		$criteria->compare('welcomemsg',$this->welcomemsg);
//		$criteria->compare('maxwait',$this->maxwait);
//		$criteria->compare('operatormsg',$this->operatormsg);
//		$criteria->compare('moh',$this->moh);
//		$criteria->compare('periodic_announce_frequency',$this->periodic_announce_frequency);
//		$criteria->compare('queue_callerannounce',$this->queue_callerannounce,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}