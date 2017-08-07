<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage user statuses')=>array('admin'),
	Yii::t('application', 'List user statuses'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create user status'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage user statuses'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('application', 'List user statuses')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
