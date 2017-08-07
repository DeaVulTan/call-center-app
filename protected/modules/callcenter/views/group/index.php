<?php
/* @var $this GroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage groups')=>array('admin'),
	Yii::t('application', 'List groups')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create group'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage groups'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'List groups')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
