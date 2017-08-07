<?php /** @var Setting[] $models */ ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
    'id' => 'setting-form',
    'enableAjaxValidation' => false,
]); ?>

<?php /**
 * '','Звонок в службу, в которой нет операторов (сообщение)'
 * '','Звонок в службу, в которой нет операторов (телефон)'
 * '','Звонок в службу, в которой нет операторов (email)'
 * '','Время ожидания абонента (сообщение)'
 * '','Время ожидания абонента (предельное значение)'
 * '','Время ожидания абонента (телефон)'
 * '','Время ожидания абонента (email)'
 * '','Процент обслуженных вызовов ниже установленного предела (сообщение)'
 * '','Процент обслуженных вызовов ниже установленного предела (предельное значение)'
 * '','Процент обслуженных вызовов ниже установленного предела (телефон)'
 * '','Процент обслуженных вызовов ниже установленного предела (email)'
 * '','Количество звонков в службу превысило предел (сообщение)'
 * '','Количество звонков в службу превысило предел (телефон)'
 * '','Количество звонков в службу превысило предел (email)'
 * '','Падение канала Е1 (Down) (сообщение)'
 * '','Падение канала Е1 (Down) (телефон)'
 * '','Падение канала Е1 (Down) (email)'
 * '','Падение канала Е1 (Up) (сообщение)'
 * '','Падение канала Е1 (Up) (телефон)'
 * '','Падение канала Е1 (Up) (email)'
 * '','Уровень заполнения жесткого диска для отправки сообщения (сообщение)'
 * '','Уровень заполнения жесткого диска для отправки сообщения (предельное значение)'
 * '','Уровень заполнения жесткого диска для отправки сообщения (телефон)'
 * '','Уровень заполнения жесткого диска для отправки сообщения (email)'

 */ ?>
<style>
    .controls input{
        display: block;
    }
    .controls textarea{
        width: 100%;
    }
    .controls label{
        margin-top: 20px;
        font-size: 16pt;
    }
</style>
<div class="controls">
<?php
echo CHtml::label('Звонок в службу, в которой нет операторов', false);
echo $form->errorSummary($models['sys_msg_call_to_empty_group_text']);
echo CHtml::textArea($models['sys_msg_call_to_empty_group_text']->name, $models['sys_msg_call_to_empty_group_text']->value, ['placeholder' => 'Сообщение']);
echo $form->errorSummary($models['sys_msg_call_to_empty_group_phone']);
echo CHtml::textField($models['sys_msg_call_to_empty_group_phone']->name, $models['sys_msg_call_to_empty_group_phone']->value, ['placeholder' => 'Телефон']);
echo $form->errorSummary($models['sys_msg_call_to_empty_group_email']);
echo CHtml::textField($models['sys_msg_call_to_empty_group_email']->name, $models['sys_msg_call_to_empty_group_email']->value, ['placeholder' => 'Email']);

echo CHtml::label('Процент обслуженных вызовов ниже установленного предела', false);
echo $form->errorSummary($models['sys_msg_percent_call_served_limit_low_text']);
echo CHtml::textArea($models['sys_msg_percent_call_served_limit_low_text']->name, $models['sys_msg_percent_call_served_limit_low_text']->value, ['placeholder' => 'Сообщение']);
echo $form->errorSummary($models['sys_msg_percent_call_served_limit_low_limit']);
echo CHtml::textField($models['sys_msg_percent_call_served_limit_low_limit']->name, $models['sys_msg_percent_call_served_limit_low_limit']->value, ['placeholder' => 'Предельное значение']);
echo $form->errorSummary($models['sys_msg_percent_call_served_limit_low_phone']);
echo CHtml::textField($models['sys_msg_percent_call_served_limit_low_phone']->name, $models['sys_msg_percent_call_served_limit_low_phone']->value, ['placeholder' => 'Телефон']);
echo $form->errorSummary($models['sys_msg_percent_call_served_limit_low_email']);
echo CHtml::textField($models['sys_msg_percent_call_served_limit_low_email']->name, $models['sys_msg_percent_call_served_limit_low_email']->value, ['placeholder' => 'Email']);

echo CHtml::label('Количество звонков в службу превысило предел', false);
echo $form->errorSummary($models['sys_msg_call_count_high_text']);
echo CHtml::textArea($models['sys_msg_call_count_high_text']->name, $models['sys_msg_call_count_high_text']->value, ['placeholder' => 'Сообщение']);
echo $form->errorSummary($models['sys_msg_call_count_high_phone']);
echo CHtml::textField($models['sys_msg_call_count_high_phone']->name, $models['sys_msg_call_count_high_phone']->value, ['placeholder' => 'Телефон']);
echo $form->errorSummary($models['sys_msg_call_count_high_email']);
echo CHtml::textField($models['sys_msg_call_count_high_email']->name, $models['sys_msg_call_count_high_email']->value, ['placeholder' => 'Email']);

echo CHtml::label('Уровень заполнения жесткого диска для отправки сообщения', false);
echo $form->errorSummary($models['sys_msg_hdd_free_space_warning_text']);
echo CHtml::textArea($models['sys_msg_hdd_free_space_warning_text']->name, $models['sys_msg_hdd_free_space_warning_text']->value, ['placeholder' => 'Сообщение']);
echo $form->errorSummary($models['sys_msg_hdd_free_space_warning_limit']);
echo CHtml::textField($models['sys_msg_hdd_free_space_warning_limit']->name, $models['sys_msg_hdd_free_space_warning_limit']->value, ['placeholder' => 'Предельное значение']);
echo $form->errorSummary($models['sys_msg_hdd_free_space_warning_phone']);
echo CHtml::textField($models['sys_msg_hdd_free_space_warning_phone']->name, $models['sys_msg_hdd_free_space_warning_phone']->value, ['placeholder' => 'Телефон']);
echo $form->errorSummary($models['sys_msg_hdd_free_space_warning_email']);
echo CHtml::textField($models['sys_msg_hdd_free_space_warning_email']->name, $models['sys_msg_hdd_free_space_warning_email']->value, ['placeholder' => 'Email']);

echo CHtml::label('Настройки рассылки писем', false);
echo $form->errorSummary($models['sys_msg_mailer_smtp']);
echo CHtml::textField($models['sys_msg_mailer_smtp']->name, $models['sys_msg_mailer_smtp']->value, ['placeholder' => 'SMTP-север']);
echo $form->errorSummary($models['sys_msg_mailer_port']);
echo CHtml::textField($models['sys_msg_mailer_port']->name, $models['sys_msg_mailer_port']->value, ['placeholder' => 'Порт']);
echo $form->errorSummary($models['sys_msg_mailer_address']);
echo CHtml::textField($models['sys_msg_mailer_address']->name, $models['sys_msg_mailer_address']->value, ['placeholder' => 'Адреса отправителя']);
?>
</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', [
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Сохранить',
    ]); ?>
</div>

<?php $this->endWidget(); ?>
