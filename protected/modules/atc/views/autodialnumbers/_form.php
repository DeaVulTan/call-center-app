<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                   => 'autodial-numbers-form',
    'enableAjaxValidation' => false,
)); ?>

<p class="help-block">Поля помеченные<span class="required"> * </span>обязательны для заполнения.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'autodialid'); ?>
    <?php echo $form->dropDownList($model, 'autodialid',
        CHtml::listData(AutodialMain::model()->findAllByAttributes(array(), array('order' => 'name')), 'id', 'name')); ?>
    <?php echo $form->error($model, 'autodialid'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'number'); ?>
    <?php echo $form->textField($model, 'number', array('size' => 10, 'maxlength' => 45)); ?>
    <?php echo $form->error($model, 'number'); ?>
</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? 'Create' : 'Save',
    )); ?>
</div>

<?php $this->endWidget(); ?>
