<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage templates'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create template'),'url'=>array('create')),
    array('label'=>Yii::t('application', 'Report help'),'url'=>array('help')),
);

?>
<h1><?=Yii::t('application', 'Manage templates')?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'report-template-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
        array(
            'name' => 'is_published',
            'value' => '($data->is_published == 1) ? "Опубликован" : "Не опубликован"',
        ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => Yii::t('application', 'Actions'),
            'template'=>'{update}{delete}',
            'htmlOptions' => array('width' => '58px'),
		),
	),
)); ?>
