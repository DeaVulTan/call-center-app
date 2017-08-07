<?php
$this->breadcrumbs=array(
	'Call Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CallLog','url'=>array('index')),
	array('label'=>'Manage CallLog','url'=>array('admin')),
);
?>

<h1>Create CallLog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>