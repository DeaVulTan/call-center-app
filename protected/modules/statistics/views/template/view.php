<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage templates')=>array('admin'),
	Yii::t('application', 'View template'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create template'),'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update template'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete template'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage templates'),'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'sql',
		'translate',
        array(
            'name' => 'is_published',
            'value' => ($model->is_published) ? "Опубликован" : "Не опубликован",
        ),
	),
)); ?>
