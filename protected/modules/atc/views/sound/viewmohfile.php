<?php
/* @var $this SoundController */
/* @var $model Sound */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds')=>array('admin'),
    Yii::t('application', 'Hold sound')=>array('mohlist'),
	Yii::t('application', 'View sound'),
);

$this->menu=array(
//	array('label'=>'List Sound', 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Hold sound'), 'url'=>array('mohlist')),
//	array('label'=>'Обновить', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Sound', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'comment',
	),
)); ?>
<?php
if(is_file($model->name))
        $this->widget('Jouele', array(
    'file' => Yii::app()->createAbsoluteUrl('atc/sound/download',array('id'=>$model->id, 'type' => 'moh')),
//    'name' => 'The Black Keys — Lonely Boy',
    'htmlOptions' => array(
        'class' => 'jouele-skin-silver',
     )
));
        ?>