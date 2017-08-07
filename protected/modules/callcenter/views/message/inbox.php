<?php
/** @var $model Message */

$this->breadcrumbs = array(
    'Входящие сообщения',
);

$this->menu = array(
    array('label' => 'Создание сообщения', 'url' => array('create')),
    array('label' => 'Исходящие сообщения', 'url' => array('outbox')),

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

<h1>Входящие сообщения</h1>

<a class="btn" href="/callcenter/message/readall">Отметить все как прочитанное</a>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'message-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
            'template'=>'{view}',
        ],
        [
            'name' => 'title',
            'type' => 'raw',
            'header' => 'Заголовок',
            'value' => '"<a href=\"/callcenter/message/view/id/".$data->id."\">" . (($data->isNew()) ? "<b>" . $data->title . "</b>" : $data->title) . "</a>"',
        ],
        [
            'header' => 'Отправитель',
            'name' => 'user_id',
            'value' => 'User::model()->getUserFioByPk($data->user_id)',
            'filter' => User::model()->findAllUsers()
        ],
        [
            'name' => 'type',
            'header' => 'Тип',
            'value' => '($data->type == 1) ? "Личное" : (($data->type == 2) ? "Групповое" : "Общее")',
        ],
        'created_at',
    ],
]); ?>
