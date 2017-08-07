<?php
$this->breadcrumbs=array(
    'Управление правилами'=>array('admin'),
    'Создание правила',
);

$this->menu=array(
    array('label'=>'Управление правилами','url'=>array('admin')),
);
?>

<h1>Создание правила</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>