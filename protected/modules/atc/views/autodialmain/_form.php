<script type="text/javascript" src="/js/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<link href="/js/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script language="JavaScript">
    var myApp = angular.module('MyApp', []);
</script>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                   => 'autodial-main-form',
    'enableAjaxValidation' => false,
));
Yii::app()->getClientScript()->registerScriptFile('/js/timepicker/bootstrap-timepicker.min.js');
Yii::app()->getClientScript()->registerCssFile('/js/timepicker/bootstrap-timepicker.min.css');
?>

<p class="help-block">Поля помеченные<span class="required"> * </span>обязательны для заполнения.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 255)); ?>
<br>
<?php echo $form->checkBoxRow($model, 'record'); ?>
<?php if ($model->record && !empty($model->dir)) { ?>
    <div class="control-group">
        Директория для записей разговоров: <b><?php echo Yii::app()->params['autodialDir'] . $model->dir; ?></b><br><br>
    </div>
<?php } ?>

<?php echo $form->checkBoxRow($model, 'regular'); ?>

<div id="div-regular-time" style="display: none; padding-left: 15px;">
    <div class="control-group">
        <div class="input-append bootstrap-timepicker">
            <input id="AutodialMain_regular_time" name="AutodialMain[regular_time]" type="text" class="input-small"
                   value="<?= $model->regular_time; ?>" maxlength="5">
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        <?php echo $form->error($model, 'regular_time'); ?>
    </div>
</div>
<div id="div-period-intervals">
    <div class="control-group">
        <label class="control-label">Период обзвона</label>
        с
        <div class="input-append date" id="AutodialMain_starttime" data-date="<?= $model->starttime; ?>">
            <input class="span2" type="text" name="AutodialMain[starttime]" value="<?= $model->starttime; ?>"
                   data-format="yyyy-MM-dd hh:mm:ss">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
        по
        <div class="input-append date" id="AutodialMain_stoptime" data-date="<?= $model->stoptime; ?>">
            <input class="span2" type="text" name="AutodialMain[stoptime]" value="<?= $model->stoptime; ?>"
                   data-format="yyyy-MM-dd hh:mm:ss">
            <span class="add-on"><i class="icon-calendar"></i></span>
        </div>
        <script>
            $("#AutodialMain_starttime").datetimepicker();
            $("#AutodialMain_stoptime").datetimepicker();
        </script>
    </div>
    <div class="control-group">
        <label class="control-label">Допустимое время звонка</label>
        с
        <div class="input-append bootstrap-timepicker">
            <input id="AutodialMain_worktimestart" name="AutodialMain[worktimestart]" type="text" class="input-small"
                   value="<?= $model->worktimestart; ?>" maxlength="5">
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        по
        <div class="input-append bootstrap-timepicker">
            <input id="AutodialMain_worktimestop" name="AutodialMain[worktimestop]" type="text" class="input-small"
                   value="<?= $model->worktimestart; ?>" maxlength="5">
            <span class="add-on"><i class="icon-time"></i></span>
        </div>
        <script type="text/javascript">
            $('#AutodialMain_worktimestart').timepicker({
                minuteStep: 1,
                showSeconds: false,
                showMeridian: false,
                defaultTime: false
            });
            $('#AutodialMain_worktimestop').timepicker({
                minuteStep: 1,
                showSeconds: false,
                showMeridian: false,
                defaultTime: false
            });
            $('#AutodialMain_regular_time').timepicker({
                minuteStep: 1,
                showSeconds: false,
                showMeridian: false,
                defaultTime: false
            });
            function checkRegular() {
                if($('#AutodialMain_regular').attr('checked')) {
                    $('#div-regular-time').show();
                    $('#div-period-intervals').hide();
                } else {
                    $('#div-regular-time').hide();
                    $('#div-period-intervals').show();
                }
            }
            checkRegular();
            $('#AutodialMain_regular').change(checkRegular);
        </script>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Дни исключений</label>
    <?php
    foreach ($model->exeption_day_list as $day) {
        echo ' <input type="checkbox" name="AutodialMain[exeption_day_arr][' . $day['id'] . ']" ' . ($day["value"] ? 'checked' : '') . '>' . $day['label'];
    }
    ?>
</div>

<?php echo $form->checkBoxRow($model, 'is_predict'); ?>

<div id="div-predict-autocall" style="display: none; padding-left: 15px;">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'predict_group'); ?>
        <?php echo $form->dropDownList($model, 'predict_group',
            array(null => 'Не выбрано') + CHtml::listData(Group::model()->findAllByAttributes(array('deleted' => 0), array('order' => 'name')), 'id', 'name')); ?>
        <?php echo $form->error($model, 'predict_group'); ?>
    </div>

    <?php echo $form->textFieldRow($model, 'predict_add_calls', array('class' => 'span5')); ?>
</div>
<script>
    function checkIsPredict() {
        if($('#AutodialMain_is_predict').attr('checked')) {
            $('#div-predict-autocall').show();
        } else {
            $('#div-predict-autocall').hide();
        }
    }
    checkIsPredict();
    $('#AutodialMain_is_predict').change(checkIsPredict);
</script>
<?php echo $form->textFieldRow($model, 'iter', array('class' => 'span5')); ?>

<?php echo $form->textFieldRow($model, 'callcount', array('class' => 'span5')); ?>

<div class="control-group">
    <?php echo $form->labelEx($model, 'event'); ?>
    <select ng-init="eventTrue='<?= $model->event; ?>'" ng-model="eventTrue" name="AutodialMain[event]">
        <option value="0">Не выбрано</option>
        <option value="1">IVR</option>
        <option value="2">Служба</option>
        <option value="3">Внутренний номер</option>
        <option value="4">Проиграть файл</option>
    </select>

    <?= CHtml::activeDropDownList($model, 'value', CHtml::listData(MainIvr::model()->findAll(), 'id', 'name'), ['ng-if' => "eventTrue == '1'"]); ?>
    <?= CHtml::activeDropDownList($model, 'value', CHtml::listData(Group::model()->findAll('deleted = 0'), 'id', 'name'), ['ng-if' => "eventTrue == '2'"]); ?>
    <?= CHtml::activeDropDownList($model, 'value', CHtml::listData(SipDevices::model()->findAll(), 'id', 'name'), ['ng-if' => "eventTrue == '3'"]); ?>
    <?= CHtml::activeDropDownList($model, 'value', CHtml::listData(Sound::model()->findAll(['condition' => 'type = ' . \Sound::SOUND_TYPE_MAIN, 'order' => 'comment']), 'id', 'comment'), ['ng-if' => "eventTrue == '4'"]); ?>
    <?php echo $form->error($model, 'event'); ?>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'trunk_id'); ?>
    <?php echo $form->dropDownList(
        $model,
        'trunk_id',
        array(null => 'Не выбрано') + CHtml::listData(
            Trunk::model()->findAll(array('select' => 'id, REPLACE(name, \'trunk_\', \'\') as name'), array('order' => 'name')),
            'id', 'name'
        )
    ); ?>
    <?php echo $form->error($model, 'trunk_id'); ?>
</div>

<?php echo $form->textFieldRow($model, 'prefix', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'callerid', array('class' => 'span5', 'maxlength' => 255)); ?>
<?php echo $form->textFieldRow($model, 'iter_delay', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->labelEx($model, 'success_dial'); ?>
<select ng-init="successDial='<?= $model->success_dial; ?>'" ng-model="successDial" name="AutodialMain[success_dial]">
    <option value="1">Отвечен</option>
    <option value="2">Прослушано сек.</option>
    <option value="3">Прослушано полностью</option>
</select>
<div ng-if="successDial == '2'">
    <?php echo $form->textFieldRow($model, 'success_sec', array('class' => 'span5')); ?>
</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? 'Create' : 'Save',
    )); ?>
</div>

<?php $this->endWidget(); ?>
