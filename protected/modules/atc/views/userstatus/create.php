
<?php
$this->breadcrumbs=array(
	Yii::t('application', 'Manage user statuses')=>array('admin'),
	Yii::t('application', 'Create user status'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'List user statuses'), 'url'=>array('index')),
	array('label'=>Yii::t('application', 'Manage user statuses'), 'url'=>array('admin')),
);
?>

<h1><?=Yii::t('application', 'Create user status')?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>