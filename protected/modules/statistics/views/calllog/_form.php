<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'call-log-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'cid',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'dest',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'dest_number',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'time_in',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'time_ans',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'time_out',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'group_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'queue',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'filename',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'uniqueid',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'linkedid',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'channel',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'ans_channel',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
