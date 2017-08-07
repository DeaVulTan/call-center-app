<?php
/* @var $this TrunkController */
/* @var $model Trunk */
$this->breadcrumbs=array(
	Yii::t('application', 'Управление транками'),
);

$this->menu=array(
    array('label'=>Yii::t('application', 'Создать транк'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#trunk-devices-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('application', 'Управление транками');?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'trunk-devices-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{update}{delete}',
		),
        array(
            'name' => 'name',
            'value' => 'str_replace("trunk_", "", $data["name"])',
        ),
        'username',
        'host',
        'port',
		'nat',
		'dtmfmode',
		'allow',
        'as_number',
	),
)); ?>
