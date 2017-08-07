<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage templates')=>array('admin'),
	Yii::t('application', 'Update template'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Create template'),'url'=>array('create')),
	array('label'=>Yii::t('application', 'View template'),'url'=>array('view','id'=>$model->id)),
    array('label'=>Yii::t('application', 'View report'),'url'=>'/statistics/template/report/?id=' . $model->id),
	array('label'=>Yii::t('application', 'Manage templates'),'url'=>array('admin')),
    array('label'=>Yii::t('application', 'Report help'),'url'=>array('help')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>