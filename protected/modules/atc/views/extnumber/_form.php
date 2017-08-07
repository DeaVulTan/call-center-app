<?php
/* @var $this ExtNumberController */
/* @var $model ExtNumber */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ext-number-form',
)); ?>

	<p class="note"><?php echo Yii::t('application','Fields with <span class="required">*</span> are required.');?>
</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'route'); ?>
		<?php echo $form->dropDownList($model, 'route', CHtml::listData($model->listEvents, 'id','name'),
                            array('name'=>"ExtNumber[route]", 'class' => 'eventSel', 'data-id' => '1_'.$model->value));?>
		<?php echo $form->error($model,'route'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
            <span id="value1">
            <?php if($model->isNewRecord):?>
		<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>100)); ?>
            <?php endif;?>
            <?php echo $model->value; ?></span>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row">
            <?php $files = Sound::model()->findAll(array('order' => 'comment'));
                $list = CHtml::listData($files, 'id', 'comment');
                ?>
		<?php echo $form->labelEx($model,'error_file'); ?>
		<?php echo $form->dropDownList($model, 'error_file', $list,
                        array('empty' => 'Select a file')); ?>
		<?php echo $form->error($model,'error_file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model, 'status', array('checked' => $model->status, 'value'=>1, 'uncheckValue'=>0)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->