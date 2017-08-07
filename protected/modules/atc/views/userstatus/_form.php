<?php
/* @var $this UserstatusController */
/* @var $model UserStatus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userstatus-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>

	<p class="note"><?php echo Yii::t('application','Fields with <span class="required">*</span> are required.');?>
</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'readonly' => $model->isProtected())); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'call_deny'); ?>
		<?php echo $form->checkBox($model, 'call_deny'); ?>
		<?php echo $form->error($model,'call_deny'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php echo CHtml::activeFileField($model, 'icon'); ?>
		<?php echo $form->error($model,'icon'); ?>
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/user_status/'.$model->icon,"Icon"); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'limit'); ?>
        <?php echo $form->textField($model, 'limit'); ?>
        <?php echo $form->error($model,'limit'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'limit_message'); ?>
        <?php echo $form->textField($model, 'limit_message'); ?>
        <?php echo $form->error($model,'limit_message'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->