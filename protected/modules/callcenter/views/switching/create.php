<?php
/* @var $this SwitchingController */
/* @var $model Switching */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage switchings')=>array('admin'),
	Yii::t('application', 'Create switching'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List switchings'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Manage switchings'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create switching');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>