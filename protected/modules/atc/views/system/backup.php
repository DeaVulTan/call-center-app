<h1>Резервное копирование</h1>
<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'setting-select-form',
    'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'action' => 'update'
)); ?>

<a href="createbackup" class="btn btn-success btn-large">Сделать новый бекап</a>

<table class="items table table-striped table-bordered table-condensed">
    <tr>
        <th>Название</th>
        <th>Дата</th>
        <th>Размер (байт)</th>
        <th>Действие</th>
    </tr>

<?php foreach ($backups as $backup) { ?>
    <tr>
        <td><?=$backup['name'];?></td>
        <td><?=$backup['date'];?></td>
        <td><?=$backup['size'];?></td>
        <td>
            <a href="getbackup?name=<?=$backup['name']?>"><i class="icon-download-alt"></i></a>
            <a href="delbackup?name=<?=$backup['name']?>"><i class="icon-trash"></i></a>
        </td>
    </tr>
<?php } ?>
</table>

<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.btn').click(function(){
    window.location.href = '/atc/setting/update/id/' + $('#settingCategory').val();
});
");?>