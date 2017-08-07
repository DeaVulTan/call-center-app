<?php

/**
 * This is the model class for table "call_log".
 *
 * The followings are the available columns in table 'call_log':
 * @property string $id
 * @property string $cid
 * @property string $dest
 * @property string $dest_number
 * @property string $time_in
 * @property string $time_ans
 * @property string $time_out
 * @property integer $group_id
 * @property string $queue
 * @property integer $status
 * @property string $filename
 * @property string $uniqueid
 * @property string $linkedid
 * @property string $channel
 * @property string $ans_channel
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property User $user
 *
 * Group by attributes
 * @property array group_by
 * @property array aggregate
 */
class CallLog extends CActiveRecord
{
    protected $show = array();
    protected $group = array();
    protected $aggregate = array();

    /**
     * @param array $show
     */
    public function setShow($show)
    {
        $this->show = $show;
    }

    /**
     * @return array
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * @param mixed $aggregate
     */
    public function setAggregate($aggregate)
    {
        $this->aggregate = $aggregate;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAggregate($key = null)
    {
        if (is_null($key)) {
            return $this->aggregate;
        }

        if (array_key_exists($key, $this->aggregate) && !empty($this->aggregate[$key])) {
            return $this->aggregate[$key];
        }
        return false;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CallLog the static model class
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
		return 'call_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dest_number', 'required'),
			array('group_id, status, user_id', 'numerical', 'integerOnly'=>true),
			array('cid, dest, queue, filename, uniqueid, linkedid, channel, ans_channel', 'length', 'max'=>255),
			array('dest_number', 'length', 'max'=>100),
			array('time_in, time_ans, time_out', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cid, dest, dest_number, time_in, time_ans, time_out, group_id, queue, status, filename, uniqueid, linkedid, channel, ans_channel, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'vip' => array(self::HAS_ONE, 'Vip', array('tel1' => 'cid')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('application', 'ID'),
			'cid' => Yii::t('application', 'Cid'),
			'dest' => Yii::t('application', 'Dest'),
			'dest_number' => Yii::t('application', 'Dest Number'),
			'time_in' => Yii::t('application', 'Time In'),
			'time_ans' => Yii::t('application', 'Time Ans'),
			'time_out' => Yii::t('application', 'Time Out'),
			'group_id' => Yii::t('application', 'Group'),
			'queue' => Yii::t('application', 'Queue'),
			'status' => Yii::t('application', 'Status'),
			'filename' => Yii::t('application', 'Filename'),
			'uniqueid' => Yii::t('application', 'Uniqueid'),
			'linkedid' => Yii::t('application', 'Linkedid'),
			'channel' => Yii::t('application', 'Channel'),
			'ans_channel' => Yii::t('application', 'Ans Channel'),
			'user_id' => Yii::t('application', 'User'),
		);
	}

    public function getGroupableFieldList()
    {
        return array(
            'cid', 'user_id', 'status',
        );
    }

    public function getAggregatableFieldList()
    {
        return array(
            'cid', 'time_in', 'time_ans', 'time_out'
        );
    }

    public function getShowableFieldList()
    {
        return array(
            'cid', 'dest', 'dest_number', 'time_in', 'time_ans', 'time_out', 'group_id', 'status', 'filename', 'linkedid', 'channel', 'user_id',
        );
    }

    public function getDefaultShowAttributes()
    {
        return array(
            'cid', 'dest', 'dest_number', 'time_in', 'time_ans',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cid',$this->cid,true);
		$criteria->compare('dest',$this->dest,true);
		$criteria->compare('dest_number',$this->dest_number,true);
		$criteria->compare('time_in',$this->time_in,true);
		$criteria->compare('time_ans',$this->time_ans,true);
		$criteria->compare('time_out',$this->time_out,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('queue',$this->queue,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('uniqueid',$this->uniqueid,true);
		$criteria->compare('linkedid',$this->linkedid,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('ans_channel',$this->ans_channel,true);
		$criteria->compare('user_id',$this->user_id);


        if (count($this->getGroup()) > 0) {
            $criteria->group = implode(', ', $this->getGroup());
        }

        if (count ($this->getShow()) > 0) {
            $select = array();
            foreach ($this->getShow() as $val) {
                if ($this->getAggregate($val) === false) {
                    $select[] = $val;
                } else {
                    $select[] = $this->getAggregate($val) . "($val) as $val";
                }
            }
            $criteria->select = implode(', ', $select);
        }

		return new CActiveDataProvider($this, array(
			'pagination' => array(
				'pageSize' => 100,
			),
			'criteria'=>$criteria,
		));
	}
}