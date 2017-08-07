<?php

/**
 * This is the model class for table "musiconhold".
 *
 * The followings are the available columns in table 'musiconhold':
 * @property string $id
 * @property integer $cat_metric
 * @property integer $var_metric
 * @property string $filename
 * @property string $category
 * @property string $var_name
 * @property string $var_val
 * @property string $commented
 */
class Musiconhold extends CActiveRecord
{
    public $dir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Musiconhold the static model class
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
		return 'musiconhold';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('var_val', 'required'),
			array('cat_metric, var_metric', 'numerical', 'integerOnly'=>true),
			array('filename, category, var_name, var_val, commented', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cat_metric, var_metric, filename, category, var_name, var_val, commented', 'safe', 'on'=>'search'),
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
//                    'files' => array(self::BELONGS_TO, 'MOHFile', array('context_id' => 'cat_metric')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('application', 'ID'),
			'cat_metric' => Yii::t('application', 'Cat Metric'),
			'var_metric' => Yii::t('application', 'Var Metric'),
			'filename' => Yii::t('application', 'Filename'),
			'category' => Yii::t('application', 'Category'),
			'var_name' => Yii::t('application', 'Var Name'),
			'var_val' => Yii::t('application', 'Var Val'),
			'commented' => Yii::t('application', 'Commented'),
		);
	}

        public function insert() {
            if(!$this->getIsNewRecord())
              throw new CDbException(Yii::t('yii','The active record cannot be inserted to database because it is not new.'));
            if($this->beforeSave())
            {
                            $sql_metric="SELECT MAX(cat_metric) FROM ".$this->tableName();
                            $sql = "INSERT INTO ".$this->tableName()." ( `cat_metric`, `var_metric`, `filename`, `category`, `var_name`, `var_val`, `commented`) VALUES
                                    ( :cat_metric, 0, 'musiconhold.conf', :category, 'mode', 'files', ''),
                                    ( :cat_metric, 0, 'musiconhold.conf', :category, 'directory', :dir, ''),
                                    ( :cat_metric, 0, 'musiconhold.conf', :category, 'random', 'yes', ''),
                                    ( :cat_metric, 0, 'musiconhold.conf', :category, 'comment', :var_val, '');";
                            $command = Yii::app()->db->createCommand($sql);
                            $metric = Yii::app()->db->createCommand($sql_metric);

                            $category="moh_".time();
                            $cat_name= Yii::app()->params['uploadDir'].DIRECTORY_SEPARATOR."moh_".time();
                            mkdir($cat_name, 0777);

                            $command->prepare();
                            $command->bindValue('cat_metric', $metric->queryScalar()+1);
                            $command->bindValue('category', $category);
                            $command->bindValue('dir', $cat_name);
                            $command->bindValue('var_val', $this->var_val);
                            $this->cat_metric = $metric->queryScalar()+1;

                            $command->execute();
                            $command->reset();
                            $metric->reset();

              $this->afterSave();
              $this->setIsNewRecord(false);
              $this->setScenario('update');
                     return true;
            }

            return false;
        }

      public function delete()
      {
          if($this->beforeDelete()) {
            MOHFile::model()->deleteAll("context_id = :context", array('context' => ''));

            $sql="DELETE FROM ".$this->tableName()." WHERE cat_metric=:cat_metric";
            $command = Yii::app()->db->createCommand($sql);
	    $command->prepare();
	    $command->bindValue('cat_metric', $this->cat_metric);
	    $command->execute();
            $command->reset();
	    $this->afterDelete();
	    return true;
        }
	return false;
     }

     /**
      * Перед удалением записей - удалим каталог в ФС
      */
     public function beforeDelete() {
        $dir = $this->getDir();
        if (file_exists($dir))
        {
	    FileHelper::removeDirRecursive($dir);
        }
	parent::beforeDelete();
	return true;
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
                $criteria->condition  = 'var_name =:var_name';
                $criteria->params = array('var_name' => 'comment');
		$criteria->compare('id',$this->id,true);
		$criteria->compare('var_val',$this->var_val,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getDir() {
            $sql="SELECT var_val FROM ".$this->tableName()." WHERE cat_metric=:cat_metric AND var_name='directory'";
            $command = Yii::app()->db->createCommand($sql);
            $command->prepare();
            $command->bindValue('cat_metric', $this->cat_metric);
            $dir =  $command->queryScalar();
            $command->reset();
            return $dir;
        }
}