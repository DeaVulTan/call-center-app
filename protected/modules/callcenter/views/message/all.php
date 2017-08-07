<?php
$this->breadcrumbs=array(
	'Все сообщения',
);

$this->menu=array(
    array('label'=>'Создание сообщения','url'=>array('create')),
    array('label'=>'Входящие сообщения','url'=>array('inbox')),
    array('label'=>'Исходящие сообщения','url'=>array('outbox')),

);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('message-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Все сообщения</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'message-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'title',
            'type' => 'raw',
            'header' => 'Заголовок',
            'value' => '"<a href=\"/callcenter/message/view/id/".$data->id."\">" . (($data->isNew()) ? "<b>" . $data->title . "</b>" : $data->title) . "</a>"',
        ),
        array(
            'name' => 'type',
            'header' => 'Тип',
            'value' => '($data->type == 1) ? "Личное" : (($data->type == 2) ? "Групповое" : "Общее")',
        ),
        array(
            'header' => 'Прочитанно',
            'value' => '$data->getReadCount() . "/" . $data->getAllCount()',
        ),
        array(
            'name' => 'created_at',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'name' => 'created_at_from',
                'value' => $model->created_at_from,
                'language' => 'ru',
                'htmlOptions' => array(
                    'id' => 'datepicker_for_due_date',
                    'size' => '10',
                ),
                'defaultOptions' => array(
                    'showOn' => 'focus',
                    'dateFormat' => 'YYYY-mm-dd',
                    'yearRange'=>'-70:+0',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showButtonPanel' => true,
                )
            ), true),
        ),
    ),
)); ?>
