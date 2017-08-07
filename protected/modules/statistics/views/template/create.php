<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage templates')=>array('admin'),
	Yii::t('application', 'Create template'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Manage templates'),'url'=>array('admin')),
    array('label'=>Yii::t('application', 'Report help'),'url'=>array('help')),
);
?>

<h1><?=Yii::t('application', 'Create template')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>