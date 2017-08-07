<?php
/** @var Message $model */

$this->breadcrumbs=array(
    'Входящие'=>array('inbox'),
    'Просмотр сообщения',
);

$this->menu=array(
    array('label'=>'Создание сообщения','url'=>array('create')),
    array('label'=>'Входящие сообщения','url'=>array('inbox')),
    array('label'=>'Исходящие сообщения','url'=>array('outbox')),
);
?>

<h1>Просмотр сообщения "<?php echo $model->title; ?>"</h1>



<?php
    echo CHtml::label('Заголовок', 'title');
    echo CHtml::textField('title', $model->title, ['disabled'=>'true']);

    echo CHtml::label('Отправитель', 'user_id');
    echo CHtml::textField('user_id', User::model()->getUserFioByPk($model->user_id), ['disabled'=>'true']);

    echo CHtml::label('Текст', 'body');
    echo CHtml::textArea('body', $model->body, ['disabled'=>'true', 'style'=>'width:500px; height:305px', 'rows'=>6]);

    echo '<table class="table-bordered"><thead><th style="width:200px;">Фамилия</th><th style="width:150px;">Имя</th><th>Статус</th></thead>';
    foreach ($model->getDirections() as $dir) {
        echo '<tr><td>' . $dir->user->surname . '</td>';
        echo '<td>' . $dir->user->firstname . '</td>';
        echo '<td>' . (($dir->status == '1') ? "Прочтено": "Не прочтено") . '</td></tr>';
    }
    echo '</table>';
?>
