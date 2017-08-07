<?php
/* @var $this SoundController */
/* @var $model Sound */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds')=>array('admin'),
	Yii::t('application', 'Update sound'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create sound'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage sounds'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>