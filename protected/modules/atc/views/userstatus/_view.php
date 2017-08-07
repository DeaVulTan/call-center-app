<?php
/* @var $this Usertatusontroller */
/* @var $data UserStatus */
?>

<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('call_deny')); ?>:</b>
    <?php echo CHtml::encode($data->call_deny); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('limit')); ?>:</b>
    <?php echo CHtml::encode($data->limit); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('limit_message')); ?>:</b>
    <?php echo CHtml::encode($data->limit_message); ?>
    <br />

</div>