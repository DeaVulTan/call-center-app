<?php
/* @var $this NotevaluesController */
/* @var $model NoteValues */

$this->breadcrumbs=array(
	'Note Values'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NoteValues', 'url'=>array('index')),
	array('label'=>'Create NoteValues', 'url'=>array('create')),
	array('label'=>'Update NoteValues', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NoteValues', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NoteValues', 'url'=>array('admin')),
);
?>

<h1>View NoteValues #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'field_type',
		'group_call_id',
		'value',
	),
)); ?>
