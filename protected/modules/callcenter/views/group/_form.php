<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
/* @var $queue QueueTable */
?>
<script src="/js/minicolors/jquery.minicolors.js"></script>
<link rel="stylesheet" href="/js/minicolors/jquery.minicolors.css">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<p class="note"><?php echo Yii::t('application','Fields with <span class="required">*</span> are required.');?>
</p>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($queue); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder'); ?>
		<?php echo $form->textField($model,'folder',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'folder'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'callerid'); ?>
		<?php echo $form->textField($model,'callerid',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'callerid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iconFile'); ?>
		<?php echo $form->fileField($model,'iconFile'); ?>
		<?php echo $form->error($model,'iconFile'); ?>
                <?php if($model->icon) echo $this->icon_image($model->icon); ?>
	</div>
    <br/>
    <div class="row">
        <?php echo $form->labelEx($model,'deleteFile'); ?>
        <?php echo $form->checkBox($model, 'deleteFile'); ?>
        <?php echo $form->error($model,'deleteFile'); ?>
    </div>
    <br/>

	<div class="row">
		<?php echo $form->labelEx($model,'color'); ?>
		<?php echo $form->textField($model,'color',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'color'); ?>
	</div>

	<script language="javascript">
		$('#Group_color').minicolors();
	</script>

	<div class="row">
		<?php echo $form->labelEx($queue,'musiconhold'); ?>
        <?php echo $form->dropDownList($queue,'musiconhold',
            CHtml::listData(Musiconhold::model()->findAllByAttributes(array('var_name' => 'comment'), array('order' => 'var_val')), 'category', 'var_val')); ?>
		<?php echo $form->error($queue,'musiconhold'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($queue,'timeout'); ?>
		<?php echo $form->textField($queue,'timeout',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($queue,'timeout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($queue,'wrapuptime'); ?>
		<?php echo $form->textField($queue,'wrapuptime',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($queue,'wrapuptime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($queue,'maxlen'); ?>
		<?php echo $form->textField($queue,'maxlen',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($queue,'maxlen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($queue,'strategy'); ?>
		<?php echo $form->dropDownList($queue,'strategy', CHtml::listData($queue->strategyVariation, 'id', 'name')); ?>
		<?php echo $form->error($queue,'strategy'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_sms_auto_send'); ?>
        <?php echo $form->checkBox($model, 'is_sms_auto_send'); ?>
        <?php echo $form->error($model,'is_sms_auto_send'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_sms_send_period'); ?>
        <?php echo $form->dropDownList($model,'is_sms_send_period', [0 => 'Не используется', 1=>'Час', 2=>'День', 3=>'Неделя', 4=>'Месяц']); ?>
        <?php echo $form->error($model,'is_sms_send_period'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'sms_sender'); ?>
        <?php echo $form->textField($model,'sms_sender',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'sms_sender'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'sms_text'); ?>
        <?php echo $form->textArea($model,'sms_text',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'sms_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'timeout'); ?>
        <?php echo $form->textField($model,'timeout',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'timeout'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'redirect_num'); ?>
        <?php echo $form->textField($model,'redirect_num',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'redirect_num'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'music_file_id');?>
        <?php echo $form->dropDownList($model,'music_file_id', Sound::model()->getSoundFileList()) ?>
        <?php echo $form->error($model,'music_file_id'); ?>
    </div>

<?php
Yii::app()->clientScript->registerScript('toggle_save_notes', "
$('#Group_is_save_notes').on('click', function(){
	$('#control-group-save-notes').toggle();
});
$('[data-toggle]').tooltip();
$('#Group_save_notes_path').keyup(function(){
    $('#dir-path').html($(this).val());
});
");
?>
<style>
.tooltip-inner {
    white-space:pre-wrap;
    text-align: left;
}
</style>

    <div class="row">
        <?php echo $form->labelEx($model,'is_save_notes'); ?>
        <?php echo $form->checkBox($model, 'is_save_notes'); ?>
        <?php echo $form->error($model,'is_save_notes'); ?>
    </div>

    <div id="control-group-save-notes" <?php echo empty($model->is_save_notes) ? 'style="display: none;"' : '' ?>>
        <br>
        <div class="row">
            Путь до папки с файлами:<br>
            <b><?php echo Yii::app()->params['save_notes_path']; ?>/</b><span id="dir-path"><?php echo $model->save_notes_path; ?></span>
        </div>
        <br>
        <div class="row">
            <?php echo $form->labelEx($model,'save_notes_path'); ?>
            <?php echo $form->textField($model,'save_notes_path',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'save_notes_path'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'save_notes_delimiter'); ?>
            <?php echo $form->textField($model,'save_notes_delimiter',array('size'=>60,'maxlength'=>32)); ?>
            <i class="icon-question-sign" style="white-space: nowrap;" data-toggle="tooltip" title="любой разделитель, включая \n, \r, \t"></i>
            <?php echo $form->error($model,'save_notes_delimiter'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'save_notes_file_format'); ?>
            <?php echo $form->textField($model,'save_notes_file_format',array('size'=>60,'maxlength'=>100)); ?>
            <i class="icon-question-sign" style="white-space: nowrap;" data-toggle="tooltip" title="пример формата: {date}_{id}_{customer_phone}.txt
параметры должны быть со скобками
{date} - YYYMMDDHHmmss
{id} - linkedid разговора
{customer_phone} - телефон или имя клиента
для того чтобы все заметки писались в один файл, имя файла должно быть без параметров"></i>
            <?php echo $form->error($model,'save_notes_file_format'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'sla'); ?>
        <?php echo $form->textField($model,'sla', ['size'=>60,'maxlength'=>32]); ?>
        <?php echo $form->error($model,'sla'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_need_notes'); ?>
        <?php echo $form->checkBox($model, 'is_need_notes'); ?>
        <?php echo $form->error($model,'is_need_notes'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_sms_percent'); ?>
        <?php echo $form->checkBox($model, 'is_sms_percent'); ?>
        <?php echo $form->error($model,'is_sms_percent'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_sms_limit'); ?>
        <?php echo $form->checkBox($model, 'is_sms_limit'); ?>
        <?php echo $form->error($model,'is_sms_limit'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_empty_group_sms'); ?>
        <?php echo $form->checkBox($model, 'is_empty_group_sms'); ?>
        <?php echo $form->error($model,'is_empty_group_sms'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
