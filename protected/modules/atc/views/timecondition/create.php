<?php
$this->breadcrumbs=array(
    'Управление правилами по времени'=>array('admin'),
    'Создание правила по времени',
);

$this->menu=array(
    array('label'=>'Управление правилами по времени','url'=>array('admin')),
);
?>

<h1>Создание правила по времени</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>