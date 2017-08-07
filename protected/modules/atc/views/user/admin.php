<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage users')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List users'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Create user'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('application', 'Manage users')?></h1>

<?php echo CHtml::link(Yii::t('application', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div> <!--search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'user-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'header' => Yii::t('application', 'Actions'),
			'template'=>'{update}{delete}',
			'htmlOptions' => array('width' => '58px'),
		),
//		'id',
		'username',
//		'password',
		'email',
		'firstname',
		'surname',
		'role',
		array(
			'header' => Yii::t('application','Sip device'),
			'name' => 'sip_device',
			'value' => 'is_object(SipDevices::model()->findByAttributes(array("chained_user_id" => $data->id))) ? SipDevices::model()->findByAttributes(array("chained_user_id" => $data->id), array("select" => "name"))->name : ""',
			'filter' => false
		),
		
	),
));?>
