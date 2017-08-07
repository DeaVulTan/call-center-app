<?php
/* @var $this SipController */
/* @var $data SipDevices */
?>

<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secret')); ?>:</b>
	<?php echo CHtml::encode($data->secret); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nat')); ?>:</b>
	<?php echo CHtml::encode($data->nat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('callerid')); ?>:</b>
	<?php echo CHtml::encode($data->callerid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dtmfmode')); ?>:</b>
	<?php echo CHtml::encode($data->dtmfmode); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fromuser')); ?>:</b>
	<?php echo CHtml::encode($data->fromuser); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailbox')); ?>:</b>
	<?php echo CHtml::encode($data->mailbox); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow')); ?>:</b>
	<?php echo CHtml::encode($data->allow); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calllimit')); ?>:</b>
	<?php echo CHtml::encode($data->calllimit); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('chained_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->chained_user_id); ?>
	<br />

	*/ ?>

</div>