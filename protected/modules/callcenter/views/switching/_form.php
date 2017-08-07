<?php
/* @var $this SwitchingController */
/* @var $model Switching */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'switching-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('application','Fields with <span class="required">*</span> are required.');?>
</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'common'); ?>
        <?php echo $form->checkBox($model, 'common'); ?>
        <?php echo $form->error($model,'common'); ?>
    </div>

	<div class="row" id="div_group_id">
		<?php echo $form->labelEx($model,'group_id'); ?>
            <?php
                echo $form->dropDownList($model, 'group_id', CHtml::listData(Group::model()->findAll('deleted = 0' ,array('select' => 'id, name'), array('order'=>' name')), 'id','name')); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeout'); ?>
		<?php echo $form->textField($model,'timeout'); ?>
		<?php echo $form->error($model,'timeout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'addition'); ?>
		<?php echo $form->textField($model,'addition',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'addition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prefix'); ?>
		<?php echo $form->textField($model,'prefix',array('size'=>60,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'prefix'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
	</div>

    <script>
        var switching = $('#Switching_common');
        if (switching.is(':checked')) {
            $('#div_group_id').hide();
        } else {
            $('#div_group_id').show();
        }
            switching.change(function(){
            if($(this).is(':checked')){
                $('#div_group_id').hide();
            } else {
                $('#div_group_id').show();
            }
        });
    </script>

<?php $this->endWidget(); ?>

</div><!-- form -->