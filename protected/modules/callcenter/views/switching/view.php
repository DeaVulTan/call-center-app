<?php
/* @var $this SwitchingController */
/* @var $model Switching */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage switchings')=>array('admin'),
	Yii::t('application', 'View switching')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List switchings'), 'url'=>array('index')),
    array('label'=>Yii::t('application', 'Create switching'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update switching'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete switching'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage switchings'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'name',
		'prefix',
		'number',
		'addition',
		'timeout',
	),
)); ?>
