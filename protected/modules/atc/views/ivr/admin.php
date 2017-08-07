<?php
/* @var $this IvrController */
/* @var $model MainIvr */

$this->breadcrumbs = [
    Yii::t('application', 'Manage ivrs'),
];

$this->menu = [
    ['label' => Yii::t('application', 'Create ivr'), 'url' => ['create']],
];
?>

<h1><?php echo Yii::t('application', 'Manage ivrs') ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id'=>'sip-devices-grid',
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>[
        [
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>['style'=>'width: 50px'],
        ],
        'name',
        [
            'name' => 'file',
            'value' => 'Sound::model()->findByPk($data->file)->comment',
            'filter' => false,
            'sortable'=>false,
        ],
        [
            'name' => 'timeout',
            'filter' => false,
        ]
    ],
]); ?>


<?php Yii::app()->clientScript->registerScript('delete', "
$('.delete').click(function(){
	if (confirm('Вы уверены, что хотите удалить данный элемент?')) {
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            success: function() {
                location.reload();
            }
        });
	}
	return false;
});
");
?>

