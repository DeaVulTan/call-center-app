<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage users')=>array('admin'),
	Yii::t('application', 'View user')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List users'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create user'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update user'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete user'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage users'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->surname . ' ' . $model->firstname ?></h1>


<?php
$cu = SipDevices::model()->findByAttributes(array("chained_user_id" => $model->id), array("select" => "name"));
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'username',
//		'password',
		'email',
		'firstname',
		'surname',
		'role',
        array(
            'header' => Yii::t('application','Sip Device'),
            'name' => 'sip_device',
            'value' => $cu?$cu->name:'',
        ),
	),
)); ?>
