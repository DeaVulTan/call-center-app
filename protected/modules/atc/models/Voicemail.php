<?php

/**
 * Модель для таблицы "voicemail_users".
 *
 * Доступные колонки в таблице 'voicemail_users':
 * @property integer $uniqueid
 * @property string $customer_id
 * @property string $context
 * @property string $mailbox
 * @property string $password
 * @property string $fullname
 * @property string $email
 * @property string $pager
 * @property string $tz
 * @property string $attach
 * @property string $saycid
 * @property string $dialout
 * @property string $callback
 * @property string $review
 * @property string $operator
 * @property string $envelope
 * @property string $sayduration
 * @property integer $saydurationm
 * @property string $sendvoicemail
 * @property string $delete
 * @property string $nextaftercmd
 * @property string $forcename
 * @property string $forcegreetings
 * @property string $hidefromdir
 * @property string $stamp
 */
class Voicemail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record класс.
	 * @return Voicemail статический класс модели
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
		return 'voicemail_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('stamp', 'required'),
//			array('saydurationm', 'numerical', 'integerOnly'=>true),
//			array('customer_id, mailbox', 'length', 'max'=>11),
//			array('context, email, pager', 'length', 'max'=>50),
//			array('password', 'length', 'max'=>5),
//			array('fullname', 'length', 'max'=>150),
//			array('tz, dialout, callback', 'length', 'max'=>10),
//			array('attach, saycid, review, operator, envelope, sayduration, sendvoicemail, delete, nextaftercmd, forcename, forcegreetings, hidefromdir', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
//			array('uniqueid, customer_id, context, mailbox, password, fullname, email, pager, tz, attach, saycid, dialout, callback, review, operator, envelope, sayduration, saydurationm, sendvoicemail, delete, nextaftercmd, forcename, forcegreetings, hidefromdir, stamp', 'safe', 'on'=>'search'),
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
//			                'uniqueid' => Yii::t('application', 'Uniqueid'),
			                'customer_id' => Yii::t('application', 'Customer'),
			                'context' => Yii::t('application', 'Context'),
			                'mailbox' => Yii::t('application', 'Mailbox'),
			                'password' => Yii::t('application', 'Password'),
//			                'fullname' => Yii::t('application', 'Fullname'),
//			                'email' => Yii::t('application', 'Email'),
//			                'pager' => Yii::t('application', 'Pager'),
//			                'tz' => Yii::t('application', 'Tz'),
//			                'attach' => Yii::t('application', 'Attach'),
//			                'saycid' => Yii::t('application', 'Saycid'),
//			                'dialout' => Yii::t('application', 'Dialout'),
//			                'callback' => Yii::t('application', 'Callback'),
//			                'review' => Yii::t('application', 'Review'),
//			                'operator' => Yii::t('application', 'Operator'),
//			                'envelope' => Yii::t('application', 'Envelope'),
//			                'sayduration' => Yii::t('application', 'Sayduration'),
//			                'saydurationm' => Yii::t('application', 'Saydurationm'),
//			                'sendvoicemail' => Yii::t('application', 'Sendvoicemail'),
//			                'delete' => Yii::t('application', 'Delete'),
//			                'nextaftercmd' => Yii::t('application', 'Nextaftercmd'),
//			                'forcename' => Yii::t('application', 'Forcename'),
//			                'forcegreetings' => Yii::t('application', 'Forcegreetings'),
//			                'hidefromdir' => Yii::t('application', 'Hidefromdir'),
//			                'stamp' => Yii::t('application', 'Stamp'),
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

//		$criteria->compare('uniqueid',$this->uniqueid);
		$criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('context',$this->context,true);
		$criteria->compare('mailbox',$this->mailbox,true);
		$criteria->compare('password',$this->password,true);
//		$criteria->compare('fullname',$this->fullname,true);
//		$criteria->compare('email',$this->email,true);
//		$criteria->compare('pager',$this->pager,true);
//		$criteria->compare('tz',$this->tz,true);
//		$criteria->compare('attach',$this->attach,true);
//		$criteria->compare('saycid',$this->saycid,true);
//		$criteria->compare('dialout',$this->dialout,true);
//		$criteria->compare('callback',$this->callback,true);
//		$criteria->compare('review',$this->review,true);
//		$criteria->compare('operator',$this->operator,true);
//		$criteria->compare('envelope',$this->envelope,true);
//		$criteria->compare('sayduration',$this->sayduration,true);
//		$criteria->compare('saydurationm',$this->saydurationm);
//		$criteria->compare('sendvoicemail',$this->sendvoicemail,true);
//		$criteria->compare('delete',$this->delete,true);
//		$criteria->compare('nextaftercmd',$this->nextaftercmd,true);
//		$criteria->compare('forcename',$this->forcename,true);
//		$criteria->compare('forcegreetings',$this->forcegreetings,true);
//		$criteria->compare('hidefromdir',$this->hidefromdir,true);
//		$criteria->compare('stamp',$this->stamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}