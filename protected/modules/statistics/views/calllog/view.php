<?php
$this->breadcrumbs=array(
	'Call Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CallLog','url'=>array('index')),
	array('label'=>'Create CallLog','url'=>array('create')),
	array('label'=>'Update CallLog','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete CallLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CallLog','url'=>array('admin')),
);
?>

<h1>View CallLog #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cid',
		'dest',
		'dest_number',
		'time_in',
		'time_ans',
		'time_out',
		'group_id',
		'queue',
		'status',
		'filename',
		'uniqueid',
		'linkedid',
		'channel',
		'ans_channel',
		'user_id',
	),
)); ?>
