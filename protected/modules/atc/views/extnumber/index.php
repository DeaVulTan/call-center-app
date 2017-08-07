<?php
/* @var $this ExtNumberController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage ext numbers')=>array('admin'),
	Yii::t('application', 'List ext numbers')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create ext number'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage ext numbers'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'List ext numbers')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
