<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'outgoing-rule-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note"><?php echo Yii::t('application','Fields with <span class="required">*</span> are required.');?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'len',array('class'=>'span5')); ?>

    <?php echo $form->textFieldRow($model,'prefix',array('class'=>'span5','maxlength'=>100)); ?>

    <?php echo $form->textFieldRow($model,'cut',array('class'=>'span5')); ?> кол-во символов в начале номера

    <?php echo $form->textFieldRow($model,'add',array('class'=>'span5','maxlength'=>255)); ?> в начало номера

    <?php echo $form->textFieldRow($model,'callerid',array('class'=>'span5','maxlength'=>255)); ?>

    <?php echo $form->labelEx($model,'trunk'); ?>
    <?php echo $form->dropDownList($model,'trunk',
        array(null => 'Не выбрано') + CHtml::listData(Trunk::model()->findAll(array('select' => 'id, REPLACE(name, \'trunk_\', \'\') as name'), array('order' => 'name')), 'id', 'name')); ?>
    <?php echo $form->error($model,'trunk'); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
        )); ?>
    </div>

<?php $this->endWidget(); ?>
