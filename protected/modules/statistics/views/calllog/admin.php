<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.reset-button').click(function(){
    location.reload();
});

$('.export-button').click('click',function() {
    window.location = 'admin?' + $('.search-form form').serialize() + '&export=true';
});
");
?>

<h1>Отчеты</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<?php echo CHtml::link('Reset Search','#',array('class'=>'reset-button btn')); ?>
<?php echo CHtml::link('Export','#',array('class'=>'export-button btn')); ?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
        'model' => $model,
        'data' => $data,
    )); ?>
</div><!-- search-form -->

<?php
// array_push($data['show'], array( 'class'=>'bootstrap.widgets.TbButtonColumn'));
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'call-log-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$data['show'],
)); ?>
