<?php
/* @var $this SipController */
/* @var $model SipDevices */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>80)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'secret'); ?>
        <?php echo $form->textField($model,'secret',array('size'=>60,'maxlength'=>80)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'callerid'); ?>
        <?php echo $form->textField($model,'callerid',array('size'=>60,'maxlength'=>80)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->