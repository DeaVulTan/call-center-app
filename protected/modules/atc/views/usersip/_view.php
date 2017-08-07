<?php
/* @var $this SipController */
/* @var $data SipDevices */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('secret')); ?>:</b>
    <?php echo CHtml::encode($data->secret); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('callerid')); ?>:</b>
    <?php echo CHtml::encode($data->callerid); ?>
    <br />
</div>