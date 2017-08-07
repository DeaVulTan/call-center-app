<?php
$this->breadcrumbs=array(
    'Управление правилами',
);

$this->menu=array(
    array('label'=>'Создание правила','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('outgoing-rule-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Управление правилами</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'outgoing-rule-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update}{delete}',
        ),
        'name',
        [
            'header' => Yii::t('application', 'Шаблон номера'),
            'filter' => null,
            'value' => '$data->getNumberTemplate()',
        ],
        'cut',
        'add',
        'callerid',
        [
            'header' => Yii::t('application','Транк'),
            'name' => 'trunk',
            'filter' => CHtml::listData(Trunk::model()->findAll(array('select' => 'id, REPLACE(name, \'trunk_\', \'\') as name'), array('order' => 'name')), 'id', 'name'),
            'value' => '!empty($data->trunk)?str_replace("trunk_", "", Trunk::model()->findByPk($data->trunk)->name):null',
        ],
    ),
)); ?>
