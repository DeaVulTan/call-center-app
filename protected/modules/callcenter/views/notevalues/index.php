<?php
/* @var $this NotevaluesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Note Values',
);

$this->menu=array(
	array('label'=>'Create NoteValues', 'url'=>array('create')),
	array('label'=>'Manage NoteValues', 'url'=>array('admin')),
);
?>

<h1>Note Values</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
