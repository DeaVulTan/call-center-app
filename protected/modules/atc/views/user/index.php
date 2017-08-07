<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage users')=>array('admin'),
	Yii::t('application', 'Create user')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create user'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Manage users'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Create user')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
