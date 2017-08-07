<?php
/* @var $this VipController */
/* @var $model Vip */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage VIPs')=>array('admin'),
	Yii::t('application', 'View VIP')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List VIPs'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create VIP'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update VIP'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete VIP'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage VIPs'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'organization',
		'tel1',
		'tel2',
		'tel3',
		'email',
		'icon',
		'ivr_id',
		'type_of_hello',
		'pic',
	),
)); ?>
