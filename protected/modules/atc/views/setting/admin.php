<h1>Системные настройки</h1>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'setting-select-form',
    'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'action' => 'update'
)); ?>

    <label for="settingCategory">Категории настроек:</label>
    <?php echo CHtml::dropDownList('settingCategory', 1, Setting::model()->getCategoryList()); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Редактировать',
    )); ?>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.btn').click(function(){
    window.location.href = '/atc/setting/update/id/' + $('#settingCategory').val();
});
");?>