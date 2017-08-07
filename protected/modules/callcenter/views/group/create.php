<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage groups')=>array('admin'),
	Yii::t('application', 'Create group')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Manage groups'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create group');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'queue' => $queue)); ?>