<?php
/* @var $this TrunkController */
/* @var $model Trunk */

$this->breadcrumbs=array(
	Yii::t('application', 'Управление транками')=>array('admin'),
	Yii::t('application', 'Редактирование транка'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Создание транка'), 'url'=>array('create')),
	array('label'=>Yii::t('application', 'Управление транками'), 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>