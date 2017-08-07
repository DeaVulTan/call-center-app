<?php
/* @var $this NotevaluesController */
/* @var $model NoteValues */

$this->breadcrumbs=array(
	'Note Values'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NoteValues', 'url'=>array('index')),
	array('label'=>'Manage NoteValues', 'url'=>array('admin')),
);
?>

<h1>Create NoteValues</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>