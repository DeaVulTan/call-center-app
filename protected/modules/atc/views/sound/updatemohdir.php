<?php
/* @var $this SoundController */
/* @var $model Musiconhold */

$this->breadcrumbs=array(
	Yii::t('application', 'Manage sounds')=>array('admin'),
	Yii::t('application', 'Hold sound')=>array('mohlist'),
	Yii::t('application', 'Update dir'),
);

$this->menu=array(
	array('label'=>Yii::t('application', 'Hold sound'), 'url'=>array('mohlist')),
);
?>

<h1><?php echo $model->var_val?></h1>

<?php echo $this->renderPartial('_formmoh', array('model'=>$model)); ?>

<br>
<h2><?php echo Yii::t('application', 'Update dir')?></h2>
<?php echo $this->renderPartial('mohfilelist', array('model'=>$filemodel, 'mohdir' => $model)); ?>
<br>
<h2><?= Yii::t('application', 'Upload file')?></h2>

<?php echo $this->renderPartial('_formmohfile', array('model'=>$filemodel, 'mohdir' => $model)); ?>