<?php
/* @var $this SwitchingController */
/* @var $model Switching */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage switchings')=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('crud', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List switchings'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create switching'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'View switching'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Manage switchings'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>