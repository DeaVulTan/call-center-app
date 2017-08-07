<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage user statuses')=>array('admin'),
	Yii::t('application', 'Update user status'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List user statuses'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create user status'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'View user status'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Manage user statuses'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>