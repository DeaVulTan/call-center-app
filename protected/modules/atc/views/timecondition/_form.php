<?php /** @var $model TimeCondition */ ?>

<script language="JavaScript">
    var myApp = angular.module('MyApp', []);
</script>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'time-condition-form',
    'enableAjaxValidation' => false,
)); ?>

<p class="note"><?php echo Yii::t('application', 'Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 200)); ?>

<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>Пункт меню</th>
            <th>Событие</th>
            <th>Параметры</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Попал</td>
            <td>
                <select ng-init="eventTrue='<?=$model->event_true;?>'" ng-model="eventTrue" name="TimeCondition[event_true]">
                    <option value="num" ng-click="eventTrue=num">Вызвать номер</option>
                    <option value="sound">Проиграть звуковой файл</option>
                    <option value="ivr">Перевести на IVR</option>
                    <option value="queue">Перевести на очередь</option>
                    <option value="hangup">Отбой</option>
                </select>
            </td>
            <td>
                <?=CHtml::activeTextField($model, 'value_true', ['ng-if' => "eventTrue == 'num'"]);?>
                <?=CHtml::activeDropDownList($model, 'value_true', CHtml::listData(Sound::model()->findAll(), 'id', 'comment'), ['ng-if' => "eventTrue == 'sound'"]);?>
                <?=CHtml::activeDropDownList($model, 'value_true', CHtml::listData(MainIvr::model()->findAll(), 'id', 'name'), ['ng-if' => "eventTrue == 'ivr'"]);?>
                <?=CHtml::activeDropDownList($model, 'value_true', CHtml::listData(Group::model()->findAll(), 'id', 'name'), ['ng-if' => "eventTrue == 'queue'"]);?>
                <span ng-if="eventTrue == 'hangup'">Без параметров</span>
            </td>
        </tr>
        <tr>
            <td>Не попал</td>
            <td>
                <select ng-init="eventFalse='<?=$model->event_false;?>'" ng-model="eventFalse" name="TimeCondition[event_false]">
                    <option value="num" ng-click="eventTrue=num">Вызвать номер</option>
                    <option value="sound">Проиграть звуковой файл</option>
                    <option value="ivr">Перевести на IVR</option>
                    <option value="queue">Перевести на очередь</option>
                    <option value="hangup">Отбой</option>
                </select>
            </td>
            <td>
                <?=CHtml::activeTextField($model, 'value_false', ['ng-if' => "eventFalse == 'num'"]);?>
                <?=CHtml::activeDropDownList($model, 'value_false', CHtml::listData(Sound::model()->findAll(), 'id', 'comment'), ['ng-if' => "eventFalse == 'sound'"]);?>
                <?=CHtml::activeDropDownList($model, 'value_false', CHtml::listData(MainIvr::model()->findAll(), 'id', 'name'), ['ng-if' => "eventFalse == 'ivr'"]);?>
                <?=CHtml::activeDropDownList($model, 'value_false', CHtml::listData(Group::model()->findAll(), 'id', 'name'), ['ng-if' => "eventFalse == 'queue'"]);?>
                <span ng-if="eventFalse == 'hangup'">Без параметров</span>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Создать' : 'Сохранить',
    )); ?>
</div>

<?php $this->endWidget(); ?>
