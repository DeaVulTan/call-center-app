<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage users')=>array('admin'),
	Yii::t('application', 'Create user')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List users'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create user'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'View user'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Manage users'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->surname . ' ' . $model->firstname; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>