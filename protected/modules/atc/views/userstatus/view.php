<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage user statuses')=>array('admin'),
	Yii::t('application', 'View user status'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List user statuses'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create user status'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update user status'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete user status'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage user statuses'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'call_deny',
        'limit',
        'limit_message',
		(!empty($model->icon)) ? array('type'=>'image','value'=>'/images/user_status/' . $model->icon, 'label'=>'Uploaded Image', 'cssClass'=>'imagePreview') : 'icon',
	),
)); ?>
