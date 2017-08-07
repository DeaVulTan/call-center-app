<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage groups')=>array('admin'),
	Yii::t('application', 'Update group')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List groups'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create group'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'View group'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Qualification of users'), 'url'=>array('qualification', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Manage groups'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'queue' => $queue)); ?>