<?php
/* @var $this SoundController */
/* @var $model Sound */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds')=>array('admin'),
	Yii::t('application', 'Hold sound')=>array('mohlist'),
	Yii::t('application', 'Create dir'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Hold sound'), 'url'=>array('mohlist')),
);
?>

<h1><?=Yii::t('application', 'Create dir')?></h1>

<?php echo $this->renderPartial('_formmoh', array('model'=>$model)); ?>