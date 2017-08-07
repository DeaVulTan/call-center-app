<?php
/* @var $this ExtNumberController */
/* @var $model ExtNumber */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage ext numbers')=>array('admin'),
	Yii::t('application', 'Create ext number')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Manage ext numbers'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create ext number')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>