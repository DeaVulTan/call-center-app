<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage groups')=>array('admin'),
	Yii::t('application', 'Chain users to group')
);

$this->menu=array(
    array('label'=>Yii::t('application', 'Create group'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update group'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete group'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage groups'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('application', 'Chain users to group').' '.$model->name; ?></h1>

<?php echo $this->renderPartial('_chainusersform', array('model'=>$model));?>