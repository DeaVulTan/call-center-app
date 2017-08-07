<?php
/* @var $this SipController */
/* @var $model SipDevices */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sip devices')=>array('admin'),
	Yii::t('application', 'Update sip device'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List sip devices'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create sip device'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'View sip device'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Manage sip devices'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>