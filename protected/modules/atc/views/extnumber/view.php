<?php
/* @var $this ExtNumberController */
/* @var $model ExtNumber */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage ext numbers')=>array('admin'),
	Yii::t('application', 'View ext number')
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List ext numbers'), 'url'=>array('index')),
    array('label'=>Yii::t('application', 'Create ext number'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Update ext number'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('application', 'Delete ext number'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('application', 'Manage ext numbers'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->number?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'number',
	    array(
                'header' => Yii::t('application','Route'),
                'name' => 'route',
                'value' => $model->listEvents[$model->route]['name']?$model->listEvents[$model->route]['name']:'',

	),
	    array(
                'header' => Yii::t('application','Value'),
                'name' => 'value',
                'value' => $model->value?$model->getRouteValue($model->route,$model->value):'---',

	),
            array(
                'header' => Yii::t('application','Error file'),
                'name' => 'error_file',
                'value' => intval($model->error_file)?Sound::model()->findByPk($model->error_file, array('select' => 'comment'))->comment:'Не указан',

	),
		'status',
	),
)); ?>
