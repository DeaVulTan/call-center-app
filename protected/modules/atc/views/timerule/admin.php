<?php
$this->breadcrumbs=array(
    'Управление временными диапазонами',
);

$this->menu=array(
    array('label'=>'Создание временного диапазона','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('time-rule-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Управление временными диапазонами</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'time-rule-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => Yii::t('application', 'Actions'),
            'template'=>'{update}{delete}',
            'htmlOptions' => array('width' => '58px'),
        ),
        'condition_id',
        'time',
        array(
            'name' => 'dow',
            'value' => 'TimeRule::model()->getShortName("listDow", $data["dow"])',
        ),
        'dom',
        array(
            'name' => 'mon',
            'value' => 'TimeRule::model()->getShortName("listMon", $data["mon"])',
        ),
    ),
)); ?>
