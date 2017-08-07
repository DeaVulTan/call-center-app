<?php
/* @var $this VipController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage VIPs')=>array('admin'),
	Yii::t('application', 'List VIPs')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create VIP'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage VIPs'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'List VIPs')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
