<?php
/* @var $this NotevaluesController */
/* @var $model NoteValues */

$this->breadcrumbs = array(
    Yii::t('application', 'Manage notevalues')
);


?>

<h1><?php echo Yii::t('application', 'Manage notevalues')?></h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'note-values-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'afterAjaxUpdate' => 'reinstallDatePicker',
    'columns' => array(
        array(
            'header' => Yii::t('application', 'Date'),
            'name' => 'callLog.time_in',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'name' => 'callLog_time_in',
                'language' => 'ru',
                //'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', // (#2)
                'htmlOptions' => array(
                    'id' => 'datepicker_for_due_date',
                    'size' => '10',
                ),
                'defaultOptions' => array(// (#3)
                    'showOn' => 'focus',
                    'dateFormat' => 'YYYY-mm-dd',
                    'yearRange'=>'-70:+0',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showButtonPanel' => true,
                )
            ), true),
        ),
        array(
            'header' => Yii::t('application', 'Group'),
            'name' => 'gc_qname',
            'value' => '(!empty($data->callLog))?$data->callLog->queue:"no queue"',
            'filter' => CHtml::listData(Group::model()->findAll(array('condition' => 'deleted = 0')), 'qname', 'qname')
        ),
        array(
            'header' => Yii::t('application', 'Operator'),
            'name' => 'gc_user_username',
            'value' => '(!empty($data->callLog->user))?$data->callLog->user->username:"no user"',
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username')
        ),
        array(
            'header' => Yii::t('application', 'Note'),
            'name' => 'field_type_name',
            'value' => '$data->fieldType->name',
            'filter' => CHtml::listData($qfilter, 'id', 'name')
        ),
        array(
            'header' => Yii::t('application', 'Notevalue'),
            'name' => 'value',
        ),
        array(
            'header' => Yii::t('application', 'Call Id'),
            'name' => 'linkedid',
        ),
        array(
            'header' => 'Абонент',
            'value' => '(!empty($data->callLog)) ? ((!empty($data->callLog->vip)) ? $data->callLog->vip->name : $data->callLog->cid) : ""',
        ),
    ),
));
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_due_date').datepicker();
}
");
?>
