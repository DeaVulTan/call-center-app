<?php
/* @var $this SwitchingController */
/* @var $model Switching */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage switchings')=>array('admin'),
	Yii::t('application', 'Import switchings'),
);

$this->menu = array(
    array('label'=>Yii::t('application', 'Manage switchings'), 'url'=>array('admin')),
);
?>

<h1>Импорт переключений</h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'switching-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<div class="row">
	<label class="required">Файл *.csv, формат: префикс;номер;служба;имя;время вызова;добавочный номер</label>
	<?php echo CHtml::activeFileField($model, 'import_file'); ?>
</div>
<br>
<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('application', 'Save')); ?>
</div>
<?php $this->endWidget(); ?>