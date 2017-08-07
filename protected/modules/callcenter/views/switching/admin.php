<?php
/* @var $this SwitchingController */
/* @var $model Switching */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#switching-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
/* @var $this NotevaluesController */
/* @var $model NoteValues */


$this->menu = array(
    array('label' => Yii::t('application', 'Create switching'), 'url' => array('create')),
    array('label' => Yii::t('application', 'Group switching'), 'url' => array('group')),
    array('label' => Yii::t('application', 'Import switchings'), 'url' => array('import')),
);
?>
<h1><?php echo Yii::t('application', 'Manage switchings')?></h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php echo CHtml::link(Yii::t('application', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div> <!--search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'switching-grid',
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
//		'id',
        'prefix',
		'number',
		array(
			'name' => 'group_name',
			'value' => '($data->common == 0) ? $data->group->name : "Общая"',
		),
		'name',
		'timeout',
        array(
            'header' => Yii::t('application','Addition'),
            'name' => 'addition',
            'value' => 'empty($data->addition)?"-":$data->addition',

        ),
	),
)); ?>
