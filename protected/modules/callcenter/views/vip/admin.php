<?php
/* @var $this VipController */
/* @var $model Vip */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#vip-grid').yiiGridView('update', {
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
    array('label' => Yii::t('application', 'Create VIP'), 'url' => array('create')),
);
?>
<h1><?php echo Yii::t('application', 'Manage VIPs')?></h1>

<?php echo CHtml::link(Yii::t('application', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'vip-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
		'name',
		'organization',
		'tel1',
		'tel2',
		'tel3',
		/*
		'email',
		'icon',
		'ivr_id',
		'type_of_hello',
		'pic',
		*/

	),
)); ?>
