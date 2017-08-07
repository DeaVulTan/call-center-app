<?php
$this->breadcrumbs=array(
	'Call Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CallLog','url'=>array('index')),
	array('label'=>'Create CallLog','url'=>array('create')),
	array('label'=>'View CallLog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage CallLog','url'=>array('admin')),
);
?>

<h1>Update CallLog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>