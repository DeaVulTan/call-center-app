<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'time-rule-form',
    'enableAjaxValidation'=>false,
));
Yii::app()->getClientScript()->registerScriptFile('/js/timepicker/bootstrap-timepicker.min.js');
Yii::app()->getClientScript()->registerCssFile('/js/timepicker/bootstrap-timepicker.min.css');
?>

    <p class="note"><?php echo Yii::t('application','Fields with <span class="required">*</span> are required.');?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model,'condition_id');?>
    <?php echo $form->dropDownList($model,'condition_id',  TimeCondition::model()->getConditionList()) ?>
    <?php echo $form->error($model,'condition_id'); ?>

    <?php echo $form->labelEx($model,'time');?>
    с <div class="input-append bootstrap-timepicker">
        <input id="time_from" name="TimeRule[time_from]" type="text" class="input-small" value="<?=$model->time_from;?>">
        <span class="add-on"><i class="icon-time"></i></span>
    </div>
    по <div class="input-append bootstrap-timepicker">
        <input id="time_to" name="TimeRule[time_to]" type="text" class="input-small" value="<?=$model->time_to;?>">
        <span class="add-on"><i class="icon-time"></i></span>
    </div>
    <script type="text/javascript">
        $('#time_from').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false,
            defaultTime: false
        });
        $('#time_to').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false,
            defaultTime: false
        });
    </script>

    <?php echo $form->labelEx($model,'dow');?>
    с <?php echo $form->dropDownList($model,'dow_from', CHtml::listData($model->listDow, 'id','name')) ?>
    по <?php echo $form->dropDownList($model,'dow_to',  CHtml::listData($model->listDow, 'id','name')) ?>

    <?php echo $form->labelEx($model,'dom');?>
    с <?php echo $form->dropDownList($model,'dom_from', $model->listDom(true)) ?>
    по <?php echo $form->dropDownList($model,'dom_to',  $model->listDom()) ?>

    <?php echo $form->labelEx($model,'mon');?>
    с <?php echo $form->dropDownList($model,'mon_from', CHtml::listData($model->listMon, 'id','name')) ?>
    по <?php echo $form->dropDownList($model,'mon_to',  CHtml::listData($model->listMon, 'id','name')) ?>


    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
        )); ?>
    </div>

<?php $this->endWidget(); ?>
