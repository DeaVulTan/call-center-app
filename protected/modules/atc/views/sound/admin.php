<?php
/* @var $this SoundController */
/* @var $model Sound */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create sound'), 'url'=>array('create')),
    array('label'=>Yii::t('application', 'Hold sound'), 'url'=>array('mohlist')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sound-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('application', 'Manage sounds')?></h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sound-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => Yii::t('application', 'Actions'),
            'template'=>'{update}{delete}{download}',
            'htmlOptions' => array('width' => '63px'),
            'buttons' => array(
                'download' => array(
                    'label'=>'Скачать файл',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/buttons/download.png',
                    'url'=>'Yii::app()->createAbsoluteUrl(\'atc/sound/download\',array(\'id\'=>$data->id))',
                    'visible' => 'is_file(Yii::app()->params[\'soundsDir\'].DIRECTORY_SEPARATOR.$data->name.\'.wav\')',
                ),
            )
		),
		'id',
		'name',
		[
			'name' => 'type',
			'filter' => Sound::$types,
			'value' => function ($data) {
				return Sound::$types[$data->type];
			}
		],
		'comment',
	),
));
?>
