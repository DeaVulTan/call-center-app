<?php
/* @var $this IvrController */
/* @var $model MainIvr */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage ivrs')=>array('admin'),
	Yii::t('application', 'Create ivr'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Manage ivrs'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create ivr')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>