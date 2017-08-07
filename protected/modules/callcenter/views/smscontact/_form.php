<?php
/**
 * @var SmsContact $model
 * @var TbActiveForm $form
 */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
    'id' => 'sms-contact-form',
    'enableAjaxValidation' => false,
]); ?>

<?= Yii::t('application', 'Fields with <span class="required">*</span> are required.') ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'title', ['class' => 'span5', 'maxlength' => 64]); ?>

<?php echo $form->textFieldRow($model, 'number', ['class' => 'span5', 'maxlength' => 16]); ?>

<?php echo $form->textFieldRow($model, 'description', ['class' => 'span5', 'maxlength' => 256]); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', [
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Создать' : 'Сохранить',
    ]); ?>
</div>

<?php $this->endWidget(); ?>
