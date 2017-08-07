<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
	'id' => 'setting-form',
	'enableAjaxValidation' => false,
]); ?>

<?php foreach ($models as $model): ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo CHtml::label($model->title, $model->name); ?>
	<?php if (strlen($model->value) < 40) {
		echo CHtml::textField($model->name, $model->value);
	} else {
		echo CHTML::textArea($model->name, $model->value, ['style' => 'width:100%']);
	}
	?>
<?php endforeach; ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', [
		'buttonType' => 'submit',
		'type' => 'primary',
		'label' => 'Сохранить',
	]); ?>
</div>

<?php $this->endWidget(); ?>
