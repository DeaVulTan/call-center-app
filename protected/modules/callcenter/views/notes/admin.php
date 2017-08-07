<?php
/* @var $this NotesController */
/* @var $model Notes */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#notes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


$this->menu = [
	['label' => Yii::t('application', 'Create note'), 'url' => ['create']],
];
?>
<h1><?php echo Yii::t('application', 'Manage notes') ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
	'id' => 'notes-grid',
	'type' => 'striped bordered condensed',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => [
		[
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'header' => Yii::t('application', 'Actions'),
			'template' => '{update}{delete}',
			'htmlOptions' => ['width' => '63px'],
		],
		'name',
		[
			'name' => 'group.name',
			'header' => Yii::t('application', 'Group')
		],
	],
]); ?>
