<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chain-users-form',
//	'enableAjaxValidation'=>true,
)); ?>
	<?php echo $form->errorSummary($model); ?>
<?php // VarDumper::dump($model);?>
	<div class="row">
            <?php 
            $this->widget('ext.widgets.multiselects.XMultiSelects',array(
                    'leftTitle'=>Yii::t('application', 'Chained users'),
                    'leftName'=>'User[chained][]',
                    'leftList'=>User::model()->findGroupChainedUsers($model->id),
                    'rightTitle'=>Yii::t('application', 'Not chained users'),
                    'rightName'=>'User[none][]',
                    'rightList'=>User::model()->findGroupChainedUsers($model->id, false),
                    'size'=>20,
                    'width'=>'100%',
                ));
             ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('application', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->