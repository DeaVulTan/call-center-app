<?php
/* @var $this VipController */
/* @var $model Vip */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vip-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('application', 'Fields with <span class="required">*</span> are required.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'organization'); ?>
		<?php echo $form->textField($model,'organization',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'organization'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel1'); ?>
		<?php echo $form->textField($model,'tel1',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'tel1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel2'); ?>
		<?php echo $form->textField($model,'tel2',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'tel2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel3'); ?>
		<?php echo $form->textField($model,'tel3',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'tel3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php echo $form->textArea($model,'icon',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'icon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ivr_id'); ?>
		<?php echo $form->textField($model,'ivr_id',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'ivr_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_of_hello'); ?>
		<?php echo $form->textField($model,'type_of_hello',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'type_of_hello'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo $form->textField($model,'pic',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'pic'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->