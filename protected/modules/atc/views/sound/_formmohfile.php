<?php
/* @var $this SoundController */
/* @var $model MOHFile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mohfile-form',
//	'enableAjaxValidation'=>true,
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model);?>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('rows'=>1, 'cols'=>30)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'soundfile'); ?>
		<?php echo $form->fileField($model, 'soundfile'); ?>
		<?php echo $form->error($model,'soundfile'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Загрузить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->