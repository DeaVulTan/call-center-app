<?php
/* @var $this GroupController */
/* @var $model Group */

if (Yii::app()->user->checkAccess('adminServices')) {
    $this->menu=array(
        array('label'=>Yii::t('application', 'Create group'), 'url'=>array('create')),
    );
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').on('click', function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').on('submit', function(){
	$('#group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

function goModal() {
    $('#mymodal').dialog('open');
}
");
?>
<h1><?php echo Yii::t('application', 'Manage groups');?></h1>

<?php echo CHtml::link(Yii::t('application', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div> <!--search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'group-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'header' => Yii::t('application', 'Actions'),
            'template'=>'{update}{delete}{chained_users}{qualification_users}',
            'htmlOptions' => array('width' => '80px'),
            'buttons' => array(
                'chained_users' => array(
                    'label'=>Yii::t('application', 'Chained user'),
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/buttons/users.png',
                    'url'=>'Yii::app()->createAbsoluteUrl(\'callcenter/group/chainuser\',array(\'id\'=>$data->id))',
                ),
                'qualification_users' => array(
                    'label'=>'<i class="icon-thumbs-up" title="' . Yii::t('application', 'Qualification of users') . '"></i>',
                  //  'imageUrl'=>Yii::app()->request->baseUrl.'/images/buttons/users.png',
                    'url'=>'Yii::app()->createAbsoluteUrl(\'callcenter/group/qualification\',array(\'id\'=>$data->id))',
                    'htmlOptions' => array('class' => 'icon-thumbs-up'),
                ),
                'update' => [
                    'visible' => 'Yii::app()->user->checkAccess(\'adminServices\')'
                ],
                'delete' => [
                    'visible' => 'Yii::app()->user->checkAccess(\'adminServices\')'
                ],
            ),
		),
//		'id',
		'name',
		'folder',
		'callerid',
        array(
            'name' => 'icon', 
            'type'=>'raw',
            'value' => '$data->icon_image()',
        ),
        array(
            'name' => 'color',
            'type'=>'raw',
            'value' => 'CHtml::tag(\'div\', array("style" => "background:#$data->color; width:50px"), "&nbsp;")',
            ),
        'qname0.musiconhold',
        'qname0.timeout',
//        'qname0.musiconhold',
		
	),
)); ?>
<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'mymodal',
    'options'=>array(
        'title'=>'Modal Dialog',
        'width'=>400,
        'height'=>200,
        'autoOpen'=>false,
        'resizable'=>false,
        'modal'=>true,
        'overlay'=>array(
            'backgroundColor'=>'#000',
            'opacity'=>'0.5'
        ),
        'buttons'=>array(
            'OK'=>'js:function(){alert("OK");}',
            'Cancel'=>'js:function(){$(this).dialog("close");}',
        ),
    ),
));
//    echo $this->renderPartial('_chainusersform', array('model'=>$model));
//echo 'Тут будет форма выбора юзеров';
$this->endWidget('zii.widgets.jui.CJuiDialog');?>
