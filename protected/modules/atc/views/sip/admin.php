<?php
/* @var $this SipController */
/* @var $model SipDevices */
$this->breadcrumbs=array(
	Yii::t('application', 'Manage sip devices'),
);

$this->menu=array(
    array('label'=>Yii::t('application', 'List sip devices'), 'url'=>array('index')),
    array('label'=>Yii::t('application', 'Create sip device'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#sip-devices-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('application', 'Manage sip devices');?></h1>

<?php echo CHtml::link(Yii::t('application', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div> <!--search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'sip-devices-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 50px'),
		),
		'name',
		'nat',
		'callerid',
		'dtmfmode',
		'allow',
		'calllimit',
		array(
			'header' => Yii::t('application','Video support'),
			'name' => 'videosupport',
			'value' => '!empty($data->videoSupports[$data->videosupport])?$data->videoSupports[$data->videosupport]["name"]:null',

		),
		array(
			'header' => Yii::t('application','Chained user'),
			'name' => 'chained_user_id',
			'value' => 'intval($data->chained_user_id)&&is_object(User::model()->findByPk($data->chained_user_id))?User::model()->findByPk($data->chained_user_id, array("select" => "concat(surname,\' \',firstname) as firstname"))->firstname:""',
		),
	),
)); ?>
