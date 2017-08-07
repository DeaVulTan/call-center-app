<?php
/* @var $this SoundController */
/* @var $model Sound */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds')=>array('admin'),
	Yii::t('application', 'Hold sound'),
);

$this->menu=array(
//	array('label'=>'List Sound', 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create dir'), 'url'=>array('createmohdir')),
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

<h1><?=Yii::t('application', 'Hold sound')?></h1>

<?php /* echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
<!--</div> search-form -->

<?php
//Yii::import('ext.jouele.Jouele');
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sound-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template'=>'{delete}{update}{download}',
            'htmlOptions' => array('width' => '63px'),
            'viewButtonUrl' => 'Yii::app()->createAbsoluteUrl(\'atc/sound/viewmohdir\',array(\'id\'=>$data->id))',
            'updateButtonUrl' => 'Yii::app()->createAbsoluteUrl(\'atc/sound/updatemohdir\',array(\'id\'=>$data->id))',
		    'deleteButtonUrl' => 'Yii::app()->createAbsoluteUrl(\'atc/sound/deletemohdir\',array(\'id\'=>$data->id))',
                'buttons' => array(
                    'download' => array(
                        'label'=>'Скачать файл',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/buttons/download.png',
                        'url'=>'Yii::app()->createAbsoluteUrl(\'atc/sound/download\',array(\'id\'=>$data->id))',
                        'visible' => 'is_file(Yii::getPathOfAlias(\'webroot.protected.data.files.sounds\').DIRECTORY_SEPARATOR.$data->var_val.\'.wav\')',
                    ),
                )
		),
		'id',
		'var_val',
	),
));

?>
