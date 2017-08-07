<?php
/* @var $this ExtNumberController */
/* @var $data ExtNumber */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />

	<b><?php
	echo CHtml::encode($data->getAttributeLabel('route')); ?>:</b>
	<?php echo CHtml::encode($data->listEvents[$data->route]['name']); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value?$data->getRouteValue($data->route,$data->value):'---'); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('error_file')); ?>:</b>
	<?php echo CHtml::encode(is_object(Sound::model()->findByPk($data->error_file))?Sound::model()->findByPk($data->error_file)->comment:'---'); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>