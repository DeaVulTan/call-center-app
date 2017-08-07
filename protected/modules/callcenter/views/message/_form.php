<?php
/* @var $this MessageController */
/* @var $model Message */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'notes-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'body'); ?>
        <?php echo $form->textArea($model,'body', ['style' => 'width: 648px; height:305px']); ?>
        <?php echo $form->error($model,'body'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model, 'type', ['' => '- тип отправителя -', '1' => 'Персонально','2' => 'Группе', '3' => 'Всем']) ?>
        <?php echo $form->error($model,'body'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'user_id'); ?>
        <?php echo $form->dropDownList($model, 'user_id',
            CHtml::listData(User::model()->findAll(array(
                'select' => 'id, concat(surname, \' \',firstname) as firstname',
                'order'=>'surname, firstname'
            )), 'id','firstname')); ?>
        <?php echo $form->error($model,'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'group_id'); ?>
        <?php echo $form->dropDownList($model,'group_id', CHtml::listData(Group::model()->findAll(array('condition' => 'deleted = 0')), 'id','name')); ?>
        <?php echo $form->error($model,'group_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Send'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    $(document).ready(function(){
        $('#Message_user_id').parent().hide();
        $('#Message_group_id').parent().hide();
    });

    $('#Message_type').change(function(){
        var user_id = $('#Message_user_id').parent();
        var group_id = $('#Message_group_id').parent();

        user_id.hide();
        group_id.hide();
        switch ($(this).val()) {
            case '1':
                user_id.show();
                break;
            case '2':
                group_id.show();
                break;
            default:
        }
    });

</script>