<?php
/* @var $this NotesController */
/* @var $model Notes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'notes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groupId'); ?>
		<?php echo $form->dropDownList($model,'groupId', CHtml::listData(Group::model()->findAll(array('condition' => 'deleted = 0')), 'id','name')); ?>
		<?php echo $form->error($model,'groupId'); ?>
	</div>
	<br>
	<div class="row" ng-controller="notesController" ng-init='fields=<?=$model->getFieldsJson();?>'>
		<label>Поля</label>
		<span class="span3">Название</span>
		<span class="span1">Название</span>
		<span class="span5">Обяз. для заполненеия</span>

		<div ui-sortable ng-model="fields">
			<div ng-repeat="field in fields">
				<span class="icon-random"></span>
				<input type="hidden" name="Notes[fields][{{$index+1}}][id]" value="{{field.id}}">
				<input type="text" title="Название" name="Notes[fields][{{$index+1}}][title]" ng-model="field.title" placeholder="Название">
				<select type="text" title="Тип" name="Notes[fields][{{$index+1}}][type]" ng-model="field.type">
					<option value="text">Текст</option>
					<option value="bool">Чекбокс</option>
					<option value="select">Селект</option>
				</select>
				<input type="checkbox" title="Обязательно для заполнения" name="Notes[fields][{{$index+1}}][required]" ng-model="field.required" ng-if="field.type != 'bool'">
				<input type="text" title="Список пунктов через запятую" name="Notes[fields][{{$index+1}}][options]" ng-model="field.options" ng-if="field.type == 'select'" placeholder="Значения через запятую..">
				<a ng-click="deleteField($index)" class="delete" href=""><i class="icon-trash"></i></a>
			</div>
		</div>

		<a ng-click="createField()" class="btn"><i class="icon-plus"></i> Добавить поле</a>
	</div>
	<br>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->