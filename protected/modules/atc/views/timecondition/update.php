<?php
$this->breadcrumbs=array(
    'Управление правилами по времени'=>array('admin'),
    'Редактирование правила по времени',
);

$this->menu=array(
    array('label'=>'Создание правила по времени','url'=>array('create')),
    array('label'=>'Управление правилами по времени','url'=>array('admin')),
);
?>

<h1>Редактирование <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>