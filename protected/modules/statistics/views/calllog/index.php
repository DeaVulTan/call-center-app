<?php
$this->breadcrumbs=array(
	'Call Logs',
);

$this->menu=array(
	array('label'=>'Create CallLog','url'=>array('create')),
	array('label'=>'Manage CallLog','url'=>array('admin')),
);
?>

<h1>Call Logs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
