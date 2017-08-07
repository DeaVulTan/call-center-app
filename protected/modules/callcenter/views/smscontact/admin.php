<?php
/**
 * @var SmsContact $model
 */

$this->breadcrumbs = [
    Yii::t('application', 'Управление контактами')
];

$this->menu = [
    ['label' => Yii::t('application', 'Создание контакта'), 'url' => ['create']],
];
?>

<h1><?= Yii::t('application', 'Управление контактами') ?></h1>

<a class="btn btn-success btn-large" id="btnSmsSendModal">Отправить СМС</a>

<?php // Отправка СМС - модальное окно
$this->beginWidget('bootstrap.widgets.TbModal', ['id'=>'smsSend']); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Отправка СМС</h4>
</div>
<div class="modal-body">
    <form action="#" id='smsForm'>
        <label for="sender">Отправитель <span class="required">*</span></label><input type="text" name="sender"/>
        <label for="number">Номер <span class="required">*</span></label><input type="text" id="smsSendNumber" name="number"/><?= CHtml::dropDownList('contactList', '', SmsContact::getContactList()) ?>
        <label for="text">Сообщение</label><textarea name="text" style="width:515px; height:100px"></textarea>
    </form>
</div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', ['label'=>'Отправить', 'url'=>'#', 'htmlOptions'=> ['id'=>'btnSmsSend']]); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', ['label'=>'Отменить', 'url'=>'#', 'htmlOptions'=> ['data-dismiss'=>'modal']]); ?>
</div>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('smsSendScript', "
    $('#btnSmsSendModal').click(function(){
        $('#smsSend').modal('show');
    });

    $('#btnSmsSend').click(function(){
        $.ajax({
            url: '/callcenter/smscontact/sendsms',
            type: 'POST',
            data: $('#smsForm').serialize(),
            success: function(data) {
                data = jQuery.parseJSON(data);
                alert(data.msg);
                if (data.status == 1) {
                    $('#smsSend').modal('hide');
                }
            }
        })
    });

    $('#contactList').change(function(){
        var contactId = $(this).val();
        if (contactId == '') {
            return;
        }

        $.ajax({
            url: '/callcenter/smscontact/getnumber',
            type: 'POST',
            data: {'id': contactId},
            success: function(data) {
                $('#smsSendNumber').val(data);
            }
        })
    });
");
?>

<?php $this->widget('bootstrap.widgets.TbGridView', [
    'id' => 'sms-contact-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'title',
        'number',
        'description',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ],
    ],
]); ?>
