<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage groups')=>array('admin'),
	Yii::t('application', 'View group')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create group'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update group'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete group'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage groups'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'folder',
		'callerid',
//		'icon',
		array(
			'name' => 'icon', 
			'type'=>'image',
			'value' => Yii::app()->assetManager->publish(Yii::app()->params['groupIconDir'].DIRECTORY_SEPARATOR.$model->icon),
			'visible'=>($model->icon && file_exists(Yii::app()->params['groupIconDir'].DIRECTORY_SEPARATOR.$model->icon))?true:false,
		),
		array(
				'name' => 'color', 
				'type'=>'raw',
				'value' => '<span style="background: #'.$model->color.'">&nbsp;&nbsp;&nbsp;</span>',
			),
	),
)); ?>
