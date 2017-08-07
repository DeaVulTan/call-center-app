<?php
$this->breadcrumbs = array(
    'Управление номерами' => array('admin'),
);

$this->menu = array(
    array('label' => 'Создание номера', 'url' => array('create')),
);
?>

<h1>Управление номерами для автообзвона</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'           => 'autodial-numbers-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name' => 'autodialid',
            'type' => 'raw',
            'value' => function ($data) {
                return AutodialMain::model()->findByPk($data->autodialid)->name;
            },
            'filter' => CHtml::listData(AutodialMain::model()->findAll(), 'id', 'name')
        ),
        'number',
        'trytime',
        'iter',
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty(AutodialNumbers::model()->status_list[$data->status])) {
                    return $data->status;
                }

                return AutodialNumbers::model()->status_list[$data->status];
            },
            'filter' => AutodialNumbers::model()->status_list
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => Yii::t('application', 'Actions'),
            'template'=>'{update}{delete}',
            'htmlOptions' => array('width' => '58px'),
        ),
    ),
)); ?>
