<?php
$this->breadcrumbs=array(
	'Исходящие сообщения',
);

$this->menu=array(
    array('label'=>'Создание сообщения','url'=>array('create')),
    array('label'=>'Входящие сообщения','url'=>array('inbox')),

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

<h1>Исходящие сообщения</h1>

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
            'name' => 'type',
            'header' => 'Прочитанно',
            'value' => '$data->getReadCount() . "/" . $data->getAllCount()',
        ),
        'created_at',
    ),
)); ?>
