<?php
/* @var $this ExtNumberController */
/* @var $model ExtNumber */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage ext numbers')=>array('admin'),
	Yii::t('application', 'Update ext number')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List ext numbers'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create ext number'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'View ext number'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Manage ext numbers'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->number?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>