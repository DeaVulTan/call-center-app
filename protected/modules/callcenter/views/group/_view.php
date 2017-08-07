<?php
/* @var $this GroupController */
/* @var $data Group */
?>

<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('folder')); ?>:</b>
	<?php echo CHtml::encode($data->folder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('callerid')); ?>:</b>
	<?php echo CHtml::encode($data->callerid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('icon')); ?>:</b>
	<?php if($data->icon && file_exists(Yii::app()->params['groupIconDir'].DIRECTORY_SEPARATOR.$data->icon)) echo $this->icon_image($data->icon);
              //else echo Yii:t('application', 'Icon not set'); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php if($data->color) echo CHtml::tag('span', array("style" => "background:#$data->color; width:30px"), "&nbsp;"); ?>
	<br />

</div>