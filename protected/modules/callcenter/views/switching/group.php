<?php
/* @var $this SwitchingController */
/* @var $model Switching */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage switchings')=>array('admin'),
	Yii::t('application', 'Group switching'),
);
?>

<h1><?php echo Yii::t('application', 'Group switching')?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'switching-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="row" id="div_group_id">
	<label for="Switching_group_id">Служба</label>
	<?php echo $form->dropDownList($model, 'group_id', $groups, array('empty' => 'Выберите службу...')); ?>
</div>

<div class="row">
	<label class="required">Префикс</label>
	<input name="Switching[prefix]" id="Switching_prefix" type="text">
</div>


<div class="row">
	<label class="required">Время вызова оператора в очереди (сек)</label>
	<input name="Switching[timeout]" id="Switching_timeout" type="text" value="0">
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('application', 'Save')); ?>
</div>
<?php $this->endWidget(); ?>