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
        <?php echo $form->labelEx($model,'callerid'); ?>
        <?php echo $form->textField($model,'callerid',array('size'=>60,'maxlength'=>80)); ?>
        <?php echo $form->error($model,'callerid'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'chained_user_id'); ?>
        <?php echo $form->dropDownList($model, 'chained_user_id',
            CHtml::listData(User::model()->findAll(
                array('condition' => 'not exists (select 1 from sip_devices where chained_user_id = t.id and name not like \'trunk_%\') or id = ' . (empty($model->chained_user_id) ? 0 : $model->chained_user_id),
                      'select' => 'id, concat(surname, \' \', firstname) as firstname',
                      'order'=>'surname, firstname')
            ), 'id','firstname') + array(null=>'----- Не прикреплен -----')); ?>
        <?php echo $form->error($model,'chained_user_id'); ?>
    </div>        

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->
