<?php
/* @var $this NotevaluesController */
/* @var $model NoteValues */

$this->breadcrumbs=array(
	'Note Values'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NoteValues', 'url'=>array('index')),
	array('label'=>'Create NoteValues', 'url'=>array('create')),
	array('label'=>'View NoteValues', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NoteValues', 'url'=>array('admin')),
);
?>

<h1>Update NoteValues <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>