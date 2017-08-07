<?php
/* @var $this SipController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sip devices')=>array('admin'),
	Yii::t('application', 'List sip devices'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create sip device'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage sip devices'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'List sip devices')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
