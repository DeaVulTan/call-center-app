<?php
$this->breadcrumbs = array(
    'Управление правилами по времени',
);

$this->menu = array(
    array('label' => 'Создание правила по времени', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('time-condition-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Управление правилами по времени</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'time-condition-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}{delete}',
        ],
        'name',
        [
            'name' => 'event_true',
            'value' => 'TimeCondition::model()->getEventName($data->event_true)'
        ],
        [
            'name' => 'value_true',
            'value' => 'TimeCondition::getEventValue($data->event_true, $data->value_true)',
        ],
        [
            'name' => 'event_true',
            'value' => 'TimeCondition::model()->getEventName($data->event_false)'
        ],
        [
            'name' => 'value_false',
            'value' => 'TimeCondition::getEventValue($data->event_false, $data->value_false)',
        ],
    ],
]); ?>
