<?php
/* @var $this VipController */
/* @var $data Vip */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization')); ?>:</b>
	<?php echo CHtml::encode($data->organization); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel1')); ?>:</b>
	<?php echo CHtml::encode($data->tel1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel2')); ?>:</b>
	<?php echo CHtml::encode($data->tel2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel3')); ?>:</b>
	<?php echo CHtml::encode($data->tel3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('icon')); ?>:</b>
	<?php echo CHtml::encode($data->icon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ivr_id')); ?>:</b>
	<?php echo CHtml::encode($data->ivr_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_of_hello')); ?>:</b>
	<?php echo CHtml::encode($data->type_of_hello); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pic')); ?>:</b>
	<?php echo CHtml::encode($data->pic); ?>
	<br />

	*/ ?>

</div>