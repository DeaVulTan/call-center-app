<?php
/* @var $this SwitchingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage switchings')=>array('admin'),
	Yii::t('application', 'List switchings'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create switching'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage switchings'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'List switchings')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
