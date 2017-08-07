<?php
/* @var $this TrunkController */
/* @var $model Trunk */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'trunk-devices-form',
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
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>80)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'secret'); ?>
        <?php echo $form->textField($model,'secret',array('size'=>60,'maxlength'=>80)); ?>
        <?php echo $form->error($model,'secret'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'host'); ?>
        <?php echo $form->textField($model,'host',array('size'=>60,'maxlength'=>31)); ?>
        <?php echo $form->error($model,'host'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'port'); ?>
        <?php echo $form->textField($model,'port',array('size'=>60,'maxlength'=>5)); ?>
        <?php echo $form->error($model,'port'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'nat'); ?>
        <?php echo $form->dropDownList(
            $model,
            'nat',
            CHtml::listData(
                array(
                    'no' => array(
                        'id' => 'no',
                        'name' => Yii::t('application', 'No')
                    ),
                    'yes' => array(
                        'id' => 'yes',
                        'name' => Yii::t('application', 'Yes')
                    ),
                ),
                'id',
                'name'
            ));
        ?>
        <?php echo $form->error($model,'nat'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'dtmfmode'); ?>
        <?php echo $form->dropDownList($model, 'dtmfmode', CHtml::listData($model->dtfmModes, 'id','name')); ?>
        <?php echo $form->error($model,'dtmfmode'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, Yii::t('application', 'allow audio codecs')); ?>
        <?php echo $form->checkBoxList($model,'allow_audio',CHtml::listData($model->codecsAudio,'id','name'),
                        array('template' => '{input}{label}')); ?>
        <?php echo $form->error($model,'allow'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, Yii::t('application', 'allow video codecs')); ?>
        <?php echo $form->checkBoxList($model,'allow_video',CHtml::listData($model->codecsVideo,'id','name'),
            array('template' => '{input}{label}')); ?>
        <?php echo $form->error($model,'allow'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'as_number'); ?>
        <?php echo $form->textField($model,'as_number',array('size'=>60,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'as_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_need_registration'); ?>
        <?php echo $form->checkBox($model, 'is_need_registration'); ?>
        <?php echo $form->error($model, 'is_need_registration'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save')); ?>
    </div>

    <script language="javascript">
        $('input[type=submit]').click(function(){
            audioCodecs = $('input[name="Trunk[allow_audio][]"]:checked');
            if (audioCodecs.length == 0) {
                alert('Должен быть выбран хотя бы один аудио кодек');
                return false;
            }
        })
    </script>

<?php $this->endWidget(); ?>

</div><!-- form -->