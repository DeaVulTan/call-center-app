<link rel="stylesheet" href="/js/codemirror/codemirror.css" />
<script src="/js/codemirror/codemirror.js"></script>
<script src="/js/codemirror/sql.js"></script>

<style>
    .CodeMirror {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
</style>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'report-template-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?=Yii::t('application', 'Fields with <span class="required">*</span> are required.')?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->checkBoxRow($model,'is_published'); ?>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->textAreaRow($model,'sql',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <?php echo $form->textAreaRow($model,'translate',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? Yii::t('application', 'Create') : Yii::t('application', 'Save'),
        )); ?>
    </div>
    <a class="btn btn-primary" id="btnCheckResult"><?=Yii::t('application', 'Check report')?></a>

    <div id="divCheckResult" class="form-actions"></div>
<?php $this->endWidget(); ?>

<script language="javascript">
    sqlDoc = CodeMirror.fromTextArea(document.getElementById('ReportTemplate_sql'), {
        mode: 'text/x-mysql',
        indentWithTabs: true,
        smartIndent: true,
        lineNumbers: true,
        matchBrackets : true,
        autofocus: true
    });

    translateDoc = CodeMirror.fromTextArea(document.getElementById('ReportTemplate_translate'), {
        mode: 'text/x-mysql',
        indentWithTabs: true,
        smartIndent: true,
        lineNumbers: true,
        matchBrackets : true,
        autofocus: true
    });

    $('#btnCheckResult').click(function(){
        $('#divCheckResult').html('Обработка...');
        $.post( "/statistics/template/check",
            {
                sql: sqlDoc.getValue(),
                translate: translateDoc.getValue()
            },
            function(response) {
                $('#divCheckResult').html(response.text);
            },
            "json"
        );
    });
</script>
