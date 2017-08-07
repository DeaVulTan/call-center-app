<?php
/* @var $this SipController */
/* @var $model SipDevices */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sip-devices-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo Yii::t('application', 'Fields with <span class="required">*</span> are required.')?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'secret'); ?>
		<?php echo $form->textField($model,'secret',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'secret'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nat'); ?>
		<?php echo $form->dropDownList($model, 'nat', 
						CHtml::listData(array('no' => array('id' => 'no','name' => Yii::t('application', 'No')), 
							'yes' => array('id' => 'yes','name' => Yii::t('application', 'Yes'))), 
								'id','name')); ?>
		<?php echo $form->error($model,'nat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'callerid'); ?>
		<?php echo $form->textField($model,'callerid',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'callerid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dtmfmode'); ?>
		<?php echo $form->dropDownList($model, 'dtmfmode', 
						CHtml::listData($model->dtfmModes, 
								'id','name')); ?>
		<?php echo $form->error($model,'dtmfmode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, Yii::t('application', 'allow audio codecs')); ?>
		<?php echo $form->checkBoxList($model,'allow_audio',CHtml::listData($model->codecsAudio,'id','name'),
						array('template' => '{input}{label}')); ?>
		<?php echo $form->error($model,'allow'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, Yii::t('application', 'allow video codecs')); ?>
		<?php echo $form->checkBoxList($model,'allow_video',CHtml::listData($model->codecsVideo,'id','name'),
			array('template' => '{input}{label}')); ?>
		<?php echo $form->error($model,'allow'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'calllimit'); ?>
		<?php echo $form->textField($model,'calllimit'); ?>
		<?php echo $form->error($model,'calllimit'); ?>
	</div>
		
	<div class="row">
		<?php echo $form->labelEx($model,'videosupport'); ?>
		<?php echo $form->dropDownList($model, 'videosupport', 
						CHtml::listData($model->videoSupports, 
								'id','name')); ?>
		<?php echo $form->error($model,'videosupport'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chained_user_id'); ?>
		<?php echo $form->dropDownList($model, 'chained_user_id',
			CHtml::listData(User::model()->findAll(array(
				'select' => 'id, concat(surname, \' \',firstname) as firstname',
				'condition' => 'not exists (select 1 from sip_devices where chained_user_id = t.id and name not like \'trunk_%\') or id = ' . (empty($model->chained_user_id) ? 0 : $model->chained_user_id),
				'order'=>'surname, firstname'
			)), 'id','firstname') + array(null=>'----- Не прикреплен -----')); ?>
		<?php echo $form->error($model,'chained_user_id'); ?>
	</div>		

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
	</div>

	<script language="javascript">
		$('input[type=submit]').click(function(){
			audioCodecs = $('input[name="SipDevices[allow_audio][]"]:checked');
			if (audioCodecs.length == 0) {
				alert('Должен быть выбран хотя бы один аудио кодек');
				return false;
			}
		})
	</script>

<?php $this->endWidget(); ?>

</div><!-- form -->