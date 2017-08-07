<?php

/**
 * This is the model class for table "status_log".
 *
 * The followings are the available columns in table 'status_log':
 * @property integer $id
 * @property string $status_name
 * @property string $status_id
 * @property string $user_name
 * @property string $user_id
 * @property string $date_start
 * @property string $date_end
 * @property integer $status
 */
class StatusLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatusLog the static model class
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
		return 'status_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_name, user_name', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('status_name', 'length', 'max'=>255),
			array('user_name', 'length', 'max'=>200),
			array('date_start, date_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status_name, user_name, date_start, date_end, status, user_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'status_name' => 'Status Name',
			'user_name' => 'User Name',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
			'status' => 'Status',
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
		$criteria->compare('status_name',$this->status_name,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    static function setNewStatus($newStatusId = null, $userId = null)
    {
        if (is_null($userId)) {
            $userId = Yii::app()->user->getId();
        }
        /** @var User $user */
        $user = User::model()->findByPk($userId);
        if ($user->status == $newStatusId) {
            return;
        }
        StatusLog::model()->updateAll(['status' => '0', 'date_end' => new CDbExpression('NOW()')], 'status = 1 AND user_id = ' . $userId);

        $statusLog = new StatusLog;
        $statusLog->status_name = (is_null($newStatusId)) ? 'Не в сети' : UserStatus::model()->findByPk($newStatusId)->name;
        $statusLog->status_id   = $newStatusId;
        $statusLog->user_name   = $user->surname . ' ' . $user->firstname;
        $statusLog->user_id     = $userId;
        $statusLog->date_start  = new CDbExpression('NOW()');
        $statusLog->save();
    }
}