<?php
/* @var $this SoundController */
/* @var $model Sound */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', [
		'id' => 'moh-form',
		'enableAjaxValidation' => false,
		'htmlOptions' => ['enctype' => 'multipart/form-data'],
	]); ?>

	<p class="note"><?php echo Yii::t('application', 'Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', ['rows' => 1, 'cols' => 50]); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'type'); ?>
		<?php echo $form->dropDownList($model, 'type', Sound::$types); ?>
		<?php echo $form->error($model, 'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'comment'); ?>
		<?php echo $form->textArea($model, 'comment', ['rows' => 6, 'cols' => 50]); ?>
		<?php echo $form->error($model, 'comment'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'soundfile'); ?>
		<?php echo $form->fileField($model, 'soundfile'); ?>
		<?php echo $form->error($model, 'soundfile'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
