<?php
/* @var $this SoundController */
/* @var $model Sound */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'moh-form',
	'enableAjaxValidation'=>true,
//        'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'var_val'); ?>
		<?php echo $form->textField($model,'var_val',array('rows'=>1, 'cols'=>50)); ?>
		<?php echo $form->error($model,'var_val'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->