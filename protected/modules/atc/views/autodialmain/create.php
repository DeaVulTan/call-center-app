<?php
$this->breadcrumbs = array(
    'Управление заданиями' => array('admin'),
    'Создание',
);

$this->menu = array(
    array('label' => 'Управление заданиями', 'url' => array('admin')),
    array('label' => 'Импорт номеров', 'url' => array('import')),
);
?>

    <h1>Создание задания</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>