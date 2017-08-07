<?php
$this->breadcrumbs = array(
    'Управление номерами' => array('admin'),
    'Создание',
);

$this->menu = array(
    array('label' => 'Управление номерами', 'url' => array('admin')),
);
?>

    <h1>Создание номера</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>