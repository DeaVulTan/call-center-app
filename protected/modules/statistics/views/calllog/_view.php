<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cid')); ?>:</b>
	<?php echo CHtml::encode($data->cid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dest')); ?>:</b>
	<?php echo CHtml::encode($data->dest); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dest_number')); ?>:</b>
	<?php echo CHtml::encode($data->dest_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_in')); ?>:</b>
	<?php echo CHtml::encode($data->time_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_ans')); ?>:</b>
	<?php echo CHtml::encode($data->time_ans); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_out')); ?>:</b>
	<?php echo CHtml::encode($data->time_out); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('group_id')); ?>:</b>
	<?php echo CHtml::encode($data->group_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('queue')); ?>:</b>
	<?php echo CHtml::encode($data->queue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('filename')); ?>:</b>
	<?php echo CHtml::encode($data->filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uniqueid')); ?>:</b>
	<?php echo CHtml::encode($data->uniqueid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('linkedid')); ?>:</b>
	<?php echo CHtml::encode($data->linkedid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel')); ?>:</b>
	<?php echo CHtml::encode($data->channel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ans_channel')); ?>:</b>
	<?php echo CHtml::encode($data->ans_channel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>