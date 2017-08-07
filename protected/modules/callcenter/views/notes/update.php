<?php
/* @var $this NotesController */
/* @var $model Notes */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage notes')=>array('admin'),
	Yii::t('application', 'Update note'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create note'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage notes'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>