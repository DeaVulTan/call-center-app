<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage users')=>array('admin'),
	Yii::t('application', 'Create user')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List users'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Manage users'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create user')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>