<?php
$this->breadcrumbs=array(
    'Управление временными диапазонами'=>array('admin'),
    'Редактирование временного диапазона',
);

$this->menu=array(
    array('label'=>'Создание временного диапазона','url'=>array('create')),
    array('label'=>'Управление временными диапазонами','url'=>array('admin')),
);
?>

<h1><?= empty($model->id) ? 'Создание':'Редактирование'?> временного диапазона</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>