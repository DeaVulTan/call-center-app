<?php
/* @var $this VipController */
/* @var $model Vip */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage VIPs')=>array('admin'),
	Yii::t('application', 'Create VIP')
);

$this->menu=array(
	array('label'=> Yii::t('application', 'List VIPs'), 'url'=>array('index')),
	array('label'=> Yii::t('application', 'Manage VIPs'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create VIP')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>