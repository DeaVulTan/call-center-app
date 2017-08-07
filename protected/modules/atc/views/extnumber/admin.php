<?php
/* @var $this ExtNumberController */
/* @var $model ExtNumber */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage ext numbers'),
);

$this->menu=array(
		array('label'=>Yii::t('application', 'Create ext number'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ext-number-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('application', 'Manage ext numbers');?></h1>

<?php echo CHtml::link(Yii::t('application', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div> <!--search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'ext-number-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
				'header' => Yii::t('application', 'Actions'),
				'template'=>'{update}{delete}',
				'htmlOptions' => array('width' => '58px'),
		),
		'id',
		'number',
		 array(
				'header' => Yii::t('application','Route'),
				'name' => 'route',
				'value' => '$data->listEvents[$data->route][\'name\']?$data->listEvents[$data->route][\'name\']:
					\'Роут не задан\'',
		),
		array(
				'header' => Yii::t('application','Value'),
				'name' => 'value',
				'value' => '$data->value?$data->getRouteValue($data->route,$data->value):\'---\'',
		),
			array(
				'header' => Yii::t('application','Error File'),
				'name' => 'error_file',
				'value' => 'Sound::model()->findByPk($data->error_file, array(\'select\' => \'comment\'))?
					Sound::model()->findByPk($data->error_file, array(\'select\' => \'comment\'))->comment:
					\'Запись звукового файла не найдена\'',
		),
		array(
				'header' => Yii::t('application','Status'),
				'name' => 'status',
				'type'=>'raw',
				'value' => '$data->status?"<span style=\"color:green\">Вкл</span>":"<span style=\"color:red\">Выкл</span>"',
		)
	),
)); ?>
