<?php
$this->breadcrumbs=array(
	'Входящие'=>array('inbox'),
	'Создание сообщения',
);

$this->menu=array(
	array('label'=>'Входящие сообщения','url'=>array('inbox')),
	array('label'=>'Исходящие сообщения','url'=>array('outbox')),
);
?>

<h1>Создание сообщения</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>