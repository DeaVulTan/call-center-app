<?php
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'mohfile-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search($mohdir),
//	'filter'=>$model,
	'columns'=>array(
		'comment',
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => 'Действия',
            'template'=>'{delete}{download}',
            'htmlOptions' => array('width' => '63px'),
            'viewButtonUrl' => 'Yii::app()->createAbsoluteUrl(\'atc/sound/viewmohfile\',array(\'id\'=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createAbsoluteUrl(\'atc/sound/delete\',array(\'id\'=>$data->id, \'type\' => \'moh\'))',
            'buttons' => array(
                'download' => array(
                    'label'=>'Скачать файл',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/buttons/download.png',
                    'url'=>'Yii::app()->createAbsoluteUrl(\'atc/sound/download\',array(\'id\'=>$data->id, \'type\' => \'moh\'))',
                    'visible' => 'is_file($data->name)',
                ),
            )
		),
	),
));
?>
