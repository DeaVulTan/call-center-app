<?php
/* @var $this IvrController */
/* @var $model MainIvr */
/* @var $form CActiveForm */
?>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', [
        'id' => 'main-ivr-form',
        'enableAjaxValidation' => true,
    ]); ?>

    <p class="note"><?php echo Yii::t('application', 'Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', ['size' => 60, 'maxlength' => 100]); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php $files = Sound::model()->ivr()->findAll(['order' => 'comment']);
        $list = CHtml::listData($files, 'id', 'comment');
        ?>
        <?php echo $form->labelEx($model, 'file'); ?>
        <?php echo $form->dropDownList($model, 'file', $list,
            ['empty' => 'Select a file']); ?>
        <?php echo $form->error($model, 'file'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'timeout'); ?>
        <?php echo $form->textField($model, 'timeout'); ?>
        <?php echo $form->error($model, 'timeout'); ?>
    </div>

    <h2>События</h2>

    <div class="grid-view">
        <table class="items">
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Пункт меню</th>
                <th>Событие</th>
                <th>Параметры</th>
            </tr>
            </thead>
            <tbody id="ivrEventsTable">
            <?php $i = 1; ?>
            <tr class="odd" id="<?php echo $i ?>">
                <td>&nbsp;</td>
                <td><?php $tEvent = ((!$model->isNewRecord && !empty($model->ivrevents)) ?
                        IvrEvents::model()->find('`type_val`=:type_val and `key`=:key and `type`=:type',
                            ['type_val' => $model->id, 'key' => 't', 'type' => 'ivr']) :
                        IvrEvents::model());
                    if (empty($tEvent)) {
                        $tEvent = IvrEvents::model();
                    }
                    echo Yii::t('application', 'Entering timeout');
                    echo $form->hiddenField($tEvent, 'key', ['name' => "IvrEvent[$i][key]", 'value' => 't']);
                    ?></td>
                <td>
                    <?php echo $form->dropDownList($tEvent, 'event', CHtml::listData($model->listEvents, 'id', 'name'),
                        ['name' => "IvrEvent[$i][event]", 'class' => 'eventSel', 'data-id' => $i . '_' . $tEvent->value]); ?>
                </td>
                <td>
                    <span id="value<?php echo $i ?>"><?php echo $tEvent->value; ?></span>
                    <?php $i++; ?>
                </td>
            </tr>
            <tr class="even" id="<?php echo $i ?>">
                <td>&nbsp;</td>
                <td>
                    <?php $tEvent = ((!$model->isNewRecord && !empty($model->ivrevents)) ?
                        IvrEvents::model()->find('`type_val`=:type_val and `key`=:key and `type`=:type',
                            ['type_val' => $model->id, 'key' => 'i', 'type' => 'ivr']) :
                        IvrEvents::model());
                    if (empty($tEvent)) {
                        $tEvent = IvrEvents::model();
                    }
                    echo Yii::t('application', 'Entering error');
                    echo $form->hiddenField($tEvent, 'key', ['name' => "IvrEvent[$i][key]", 'value' => 'i']);
                    ?>
                </td>
                <td>
                    <?php echo $form->dropDownList($tEvent, 'event', CHtml::listData($model->listEvents, 'id', 'name'),
                        ['name' => "IvrEvent[$i][event]", 'class' => 'eventSel', 'data-id' => $i . '_' . $tEvent->value]); ?>
                </td>
                <td><span id="value<?php echo $i ?>"><?php echo $tEvent->value; ?></span>
                    <?php $i++; ?>
                </td>
            </tr>
            <?php if (!$model->isNewRecord): ?>
                <?php foreach ($model->ivrevents as $event):
                    if (!in_array($event->key, ['t', 'i'])):?>
                        <tr class="<? if ($i % 2) echo 'odd'; else echo 'even'; ?>" id="<?php echo $i?>">
                            <td><a href="#" id="deltr<?php echo $i?>" class="delete-row">-</a></td>
                            <td><?php echo $form->dropDownList($event, 'key', CHtml::listData($model->eventKeys, 'id', 'name'),
                                    ['readonly' => true, 'name' => "IvrEvent[$i][key]", 'class' => 'eventKey']); ?></td>
                            <td>
                                <?php echo $form->dropDownList($event, 'event', CHtml::listData($model->listEvents, 'id', 'name'),
                                    ['name' => "IvrEvent[$i][event]", 'class' => 'eventSel', 'data-id' => $i . '_' . $event->value]);?>
                            </td>
                            <td>
                                <span id="value<?php echo $i?>"><?php echo $tEvent->value; ?></span>
                                <?php $i++;?>
                            </td>
                        </tr>
                    <?php endif; endforeach;
            else: ?>
                <tr class="<? if ($i % 2) echo 'odd'; else echo 'even'; ?>" id="<?php echo $i ?>">
                    <td><a href="#" id="deltr<?php echo $i ?>" class="delete-row">-</a></td>
                    <td><?php echo $form->dropDownList(IvrEvents::model(), 'key', CHtml::listData($model->eventKeys, 'id', 'name'),
                            ['readonly' => true, 'name' => "IvrEvent[$i][key]", 'class' => 'eventKey']); ?></td>
                    <td><?php echo $form->dropDownList(IvrEvents::model(), 'event', CHtml::listData($model->listEvents, 'id', 'name'),
                            ['name' => "IvrEvent[$i][event]", 'class' => 'eventSel', 'data-id' => $i . '_0']); ?></td>
                    <td>
                        <span id="value<?php echo $i ?>"><?php echo $tEvent->value; ?></span>
                        <?php $i++; ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <a href="#" id="addtr">+</a>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
