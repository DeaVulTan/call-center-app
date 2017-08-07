<?php
/* @var $this NotesController */
/* @var $model Notes */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage notes')=>array('admin'),
	Yii::t('application', 'Create note'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Manage notes'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create note')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>