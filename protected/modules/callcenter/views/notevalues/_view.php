<?php
/* @var $this NotevaluesController */
/* @var $data NoteValues */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('field_type')); ?>:</b>
	<?php echo CHtml::encode($data->field_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_call_id')); ?>:</b>
	<?php echo CHtml::encode($data->group_call_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value); ?>
	<br />


</div>