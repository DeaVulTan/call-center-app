<?php
$this->breadcrumbs = array(
    'Управление номерами' => array('admin'),
    'Редактирование',
);

$this->menu = array(
    array('label' => 'Создание номер', 'url' => array('create')),
    array('label' => 'Управление номерами', 'url' => array('admin')),
);
?>

    <h1>Редактирование нормера <?php echo $model->number; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>