<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $body
 * @property integer $type
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property MessageUser $messageUser
 */
class Message extends CActiveRecord
{
    public $group_id;
    public $user_id;
    public $inbox_user_id;
    public $created_at_from;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id, user_id, type', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
			array('title, body, type, user_id', 'safe'),
			array('title, body, type, user_id, created_at', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'messageUser' => array(self::HAS_ONE, 'MessageUser', 'message_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'body' => 'Содержимое',
            'type' => 'Тип',
            'created_at' => 'Дата создания',
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
        $criteria->select = 'id, title, user_id, body, type, created_at';
		$criteria->compare('id',$this->id);
        $criteria->compare('t.user_id', $this->user_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('body',$this->body,true);
        $criteria->compare('type',$this->type,true);

        if ($this->created_at_from) {
            $criteria->compare('created_at','>' . $this->created_at_from,true);
        }

        if ($this->inbox_user_id) {
            $criteria->with = ['messageUser'];
            $criteria->addCondition('messageUser.user_id = ' . $this->inbox_user_id);
        }

        $criteria->order = "t.id DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
		));
	}

    public function getReadCount()
    {
        $msg = $this->messageUser->findAllByAttributes(['message_id' => $this->id, 'status' => 1]);
        return count($msg);
    }

    public function getAllCount()
    {
        $msg = $this->messageUser->findAllByAttributes(['message_id' => $this->id]);
        return count($msg);
    }

    public function getDirections()
    {
        $dir = $this->messageUser->with(['user'])->findAllByAttributes(['message_id' => $this->id]);
        return $dir;
    }

    public function isNew($userId = null)
    {
        if (is_null($userId)) {
            $userId = Yii::app()->user->getId();
        }
        $messageUser = MessageUser::model()->findByAttributes(['status' => '0', 'message_id' => $this->id, 'user_id' => $userId]);
        if (is_null($messageUser)) {
            return false;
        } else {
            return true;
        }
    }

    public function readAll($userId = null)
    {
        if (is_null($userId)) {
            $userId = Yii::app()->user->getId();
        }
        MessageUser::model()->updateAll(['status' => '1'], 'user_id = ' . intval($userId));
    }

    public function getMessage($id)
    {
        $userId = Yii::app()->user->getId();

        if (!Yii::app()->user->checkAccess('admin') && 
            MessageUser::model()->findByAttributes(['message_id' => $id, 'user_id' => $userId]) == null &&
            Message::model()->findByAttributes(['id' => $id, 'user_id' => $userId]) == null
        ) {
            throw new CHttpException(404, 'Not found');
        }

        return self::findByPk($id);
    }
}
