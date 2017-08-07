<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'type' => 'horizontal'
)); ?>

<div class="span2">Name</div>
<div class="span2">Filter</div>
<div class="span1">Show</div>
<div class="span1">Group By</div>
<div class="span2">Aggregation</div>
<?php foreach ($data['fields'] as $field): ?>
    <div class="span2"><?php echo $field ?></div>
    <div class="span2">
        <input type="text" class="span2" name="CallLog[<?php echo $field ?>]" value="<?php echo array_key_exists($field, $data['filter']) ? $data['filter'][$field] : '' ?>">
    </div>
    <div class="span1">
        <?php if (in_array($field, $data['able']['show'])): ?>
            <input type="checkbox" name="Show[<?php echo $field ?>]" <?php echo in_array($field, $data['show']) ? 'checked' : '' ?>>
        <?php endif ?>
    </div>
    <div class="span1">
        <?php if (in_array($field, $data['able']['group'])): ?>
            <input type="checkbox" name="Group[<?php echo $field ?>]" <?php echo in_array($field, $data['group']) ? 'checked' : '' ?>>
        <?php endif ?>
    </div>
    <div class="span2">
        <select class="span1" name="Aggregate[<?php echo $field ?>]" <?php echo (!in_array($field, $data['able']['aggregate'])) ? 'disabled' : '' ?>>
            <?php foreach(array('','sum','avg','min','max') as $val): ?>
                <option value="<?php echo $val ?>" <?php echo (array_key_exists($field, $data['aggregate']) && $data['aggregate'][$field] == $val) ? 'selected=select' : '' ?>><?php echo $val ?></option>
            <?php endforeach ?>
        </select>
    </div>
<?php endforeach ?>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'type'=>'primary',
    'label'=>'Search',
)); ?>

<?php $this->endWidget(); ?>
