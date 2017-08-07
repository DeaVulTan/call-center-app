<?php
/* @var $this SipController */
/* @var $model SipDevices */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sip devices')=>array('admin'),
	Yii::t('application', 'View sip device'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List sip devices'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create sip device'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update sip device'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete sip device'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage sip devices'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php
$cu = User::model()->findByPk($model->chained_user_id, array('select' => 'firstname'));
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'secret',
		'nat',
		'callerid',
		'dtmfmode',
		'fromuser',
		'mailbox',
		'allow',
		'username',
		'calllimit',
            array(
                'header' => Yii::t('application','Chained user'),
                'name' => 'chained_user_id',
                'value' => $cu?$cu->firstname:'',
		
            ),
	),
)); ?>
