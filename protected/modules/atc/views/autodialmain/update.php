<?php
$this->breadcrumbs = array(
    'Управление заданиями' => array('admin'),
    'Редактирование',
);

$this->menu = array(
    array('label' => 'Создание задания', 'url' => array('create')),
    array('label' => 'Управление заданиями', 'url' => array('admin')),
    array('label' => 'Импорт номеров', 'url' => array('import')),
);
?>

    <h1>Редактирование задания <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>