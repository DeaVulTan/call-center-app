<?php
$this->breadcrumbs=array(
    'Управление правилами'=>array('admin'),
    'Редактирование правила',
);

$this->menu=array(
    array('label'=>'Создание правила','url'=>array('create')),
    array('label'=>'Управление правилами','url'=>array('admin')),
);
?>

<h1>Редактирование правила <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>