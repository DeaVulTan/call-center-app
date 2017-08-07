<?php
/* @var $this Usertatusontroller */
/* @var $model UserStatus */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage user statuses'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create user status'), 'url'=>array('create')),
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

<h1><?php echo Yii::t('application', 'Manage user statuses')?></h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

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
		'name',
		'call_deny',
        'limit',
		array(
			'name'=>'icon',
			'type'=>'html',
			'value'=>'(!empty($data->icon))?CHtml::image(Yii::app()->request->baseUrl."/images/user_status/".$data->icon,""):"no icon"',
			'filter'=>false,
		),
	),

));?>
