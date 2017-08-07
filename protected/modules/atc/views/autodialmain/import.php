<?php
$this->breadcrumbs = array(
    'Управление заданиями' => array('admin'),
    'Импорт номеров'
);

$this->menu = array(
    array('label' => 'Управление заданиями', 'url' => array('admin')),
    array('label' => 'Создание задания', 'url' => array('create')),
    array('label' => 'Импорт номеров', 'url' => array('import')),
);
?>

    <h1>Импорт номеров</h1>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'                   => 'autodial-numbers-form',
    'enableAjaxValidation' => false,
    'htmlOptions'          => array('enctype' => 'multipart/form-data'),
)); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'autodialid'); ?>
        <?php echo $form->dropDownList($model, 'autodialid',
            CHtml::listData(AutodialMain::model()->findAllByAttributes(array(), array('order' => 'name')), 'id', 'name')); ?>
        <?php echo $form->error($model, 'autodialid'); ?>
    </div>

    <div class="row">
        <label class="required">Файл *.csv, список номеров на отдельной строке</label>
        <?php echo CHtml::activeFileField($model, 'import_file'); ?>
    </div>
    <br>
    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('application', 'Save')); ?>
    </div>
<?php $this->endWidget(); ?>