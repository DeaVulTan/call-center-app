<?php
/* @var $this SoundController */
/* @var $model Sound */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds')=>array('admin'),
	Yii::t('application', 'Create sound'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Manage sounds'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create sound')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>