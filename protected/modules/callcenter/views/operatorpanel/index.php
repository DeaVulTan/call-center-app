<?php
/** @var $this OperatorpanelController */
/** @var $switches string */
/** @var $data string */
/** @var $wsCometSid string */
/** @var $wsChannel string */
/** @var $wsCometUrl string */

$this->breadcrumbs = array(
    Yii::t('application', 'Operator Panel'),
);
?>

<a class="pull-right" href="#" id="resetPanelCfg" style="font-size: 10px; margin-right: 20px; margin-top: -35px;">Сброс</a>

<div ng-controller="operatorPanel">

<?php // Отправка СМС - модальное окно
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'smsSend')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Отправка СМС</h4>
</div>
<div class="modal-body">
    <form action="#" id='smsForm'>
        <input type="hidden" name="smsLinkedId">
        <label for="smsText">Текст СМС</label><textarea name="smsText" style="width:515px"></textarea>
    </form>
</div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Отправить', 'url'=>'#', 'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'btnSmsSend'))); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Отменить', 'url'=>'#', 'htmlOptions'=>array('data-dismiss'=>'modal'))); ?>
</div>
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('smsSendScript', "
    $('#btnSmsSend').click(function(){
        if ($('[name=smsText]').val().length < 3) {
            alert('Заполните текст смс');
            return false;
        }

        $.ajax({
            url: '/callcenter/operatorpanel/sendSms',
            type: 'POST',
            data: $('#smsForm').serialize(),
            success: function(data) {
                alert(data);
            }
        })
    });
");
?>

<?php // Перевод звонка - модальное окно
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'callTransfer')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h4>Перевод звонка</h4>
</div>
<div class="modal-body">
    <form action="#" id='callTransferForm'>
        <input type="hidden" name="callTransferCallId">
        <label for="callTransfer">Оператор</label>
        <select name="operatorId">
            <option ng-repeat="operator in data.online" value="{{operator.user_id}}">{{operator.name}}</option>
        </select>
    </form>
</div>
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Отправить', 'url'=>'#', 'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'btnCallTransfer'))); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Отменить', 'url'=>'#', 'htmlOptions'=>array('data-dismiss'=>'modal'))); ?>
</div>
<?php $this->endWidget(); ?>


<?php
Yii::app()->clientScript->registerScript('callTransferScript', "
    $('#btnCallTransfer').click(function(){
        $.ajax({
            url: '/callcenter/operatorpanel/calltransfer',
            type: 'POST',
            data: $('#callTransferForm').serialize(),
            success: function(data) {
//                alert(data);
            }
        })
    });
");
?>
<span id="ws-url" data-ws-comet-url="<?=$wsCometUrl;?>" data-ws-comet-sid="<?=$wsCometSid;?>" data-ws-channel="<?=$wsChannel;?>"></span>
<table width="100%" id="widget_grid" style="display: none">
    <tr>
        <td class="column col1" nowrap="nowrap">
            <div class="portlet" ng-init='initData=<?=$data;?>; switches=<?=$switches;?>;'>
                <div class="portlet-header">Переключения</div>
                <div class="portlet-content" id="switches">
                    <input class="op-switch-filter" placeholder="Фильтр" ng-model="searchSwitch.text">
                </div>
                <ul ng-repeat="group in switches">
                    <li>
                        <a class="cp-switch-tree-group bolder" ng-click="group.expanded=!group.expanded">{{group.text}}</a>
                        <ul ng-repeat="switch in (group.children | filter:searchSwitch:strict)" ng-if="group.expanded || searchSwitch.text.length > 0">
                            <li>
                                <a class="op-switch-redirect-call" ng-click="redirectCall(switch.id)">{{switch.text}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </td>
        <td class="column third col2" nowrap="nowrap">
            <div class="portlet">
                <div class="portlet-header">Мои звонки</div>
                <div class="portlet-content" id="my_call">
                <ul class="nav nav-tabs" id="tabs_nav_my_call"></ul>
                <div class="tab-content" id="tabs_content_my_call"></div>
                </div>
            </div>
            <div class="portlet">
                <div class="portlet-header">Очереди</div>
                <div class="portlet-content" id="my_queue">
                    <a class="switcher bolder" ng-click="switchQueuesShow()">{{showAllQueuesTitleBtn}}</a>
                    <br/>
                    <input class="op-switch-filter" placeholder="Фильтр" ng-model="searchQueues">
                </div>
                <ul>
                    <li ng-repeat="queue in data.queues" ng-if="showAllQueues || queue.calls.length > 0">
                        <a class="cp-queue-tree-group" ng-click="queue.expanded=!queue.expanded">
                            <span  ng-class="{'bolder': queue.calls.length > 0}">
                                <img style="max-height: 32px" ng-src="{{queue.icon}}">{{queue.title}}
                            </span>
                            <span style="float:right">
                                <span style="color:green">{{queue.is_active}}</span>/<span style="color:orange">{{queue.is_waiting}}</span>/<span style="color:red">{{queue.is_no_active}}</span>
                            </span>
                        </a>
                        <ul>
                            <li ng-repeat="call in (queue.calls | filter:searchQueues:strict)" ng-if="showAllQueues || searchQueues.length > 0 || queue.expanded">
                                <span class="call-status call-status-{{call.status}}">*</span>
                                <span style="color: #{{call.color}}">
                                    {{call.phone}} |
                                    <span ng-if="call.status >= 0"><img style="width:22px" ng-src="/images/user_status/{{call.icon}}"/>{{call.operator}} |
                                    </span>(<timer start-time=call.time>{{hhours}}:{{mminutes}}:{{sseconds}}</timer>)
                                </span>
                                <img title="Перехват вызова" class="icon-pickup" src="/images/buttons/pickup.png" ng-if="call.status != 1" ng-click="callPickup(call.id)"/>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </td>
        <td class="column col3" nowrap="nowrap">
            <div class="portlet" ng-init='statistics=<?=$statistics;?>;'>
                <div class="portlet-header">Статистика</div>
                <div class="portlet-content" id="statistics">
                    <p>
                        <span style="color:orange">{{ statistics.distributed }}</span> |
                        <span style="color:darkgreen">{{ statistics.served }}</span> |
                        <span style="color:darkred">{{ statistics.no_served }}</span> |
                        <span>{{ statistics.percent_served }}</span>
                    </p><p>
                        <span style="color:darkgreen">{{ statistics.online_time }}</span> |
                        <span style="color:orange">{{ statistics.lunch_time }}</span>
                    </p>
                </div>
            </div>
            <div class="portlet" ng-init='statuses=<?= UserStatus::model()->getStatusListJson(); ?>; userStatus=statuses[0];'>
                <div class="portlet-header">Пользователи</div>
                <div class="portlet-content" id="operators">
                    <select ng-model="userStatus" ng-options="status.name for status in statuses"></select>
                </div>
                <ul>
                    <li ng-repeat="operator in data.online" ng-if="userStatus.id == 'all' || (userStatus.id == 'group' && compareGroup(operator.group_ids) ) || userStatus.id == operator.user_status && compareGroup(operator.group_ids)">
                        <a class="cp-queue-tree-group" ng-click="queue.expanded=!queue.expanded">
                            <img style="width:22px" ng-src="/images/user_status/{{operator.icon}}"/>
                            <span  ng-class="{'bolder': operator.calls.length > 0, 'current': operator.is_current}">{{operator.name}}</span>
                        </a>
                        <ul>
                            <li ng-repeat="call in operator.calls">
                                <span class="call-status call-status-{{call.status}}">*</span>
                                <span style="color: #{{call.color}}">
                                    {{call.phone}}|<img style="max-height: 32px" ng-src="{{call.icon}}">{{call.group}}(<timer start-time=call.time>{{hhours}}:{{mminutes}}:{{sseconds}}</timer>)
                                </span>
                                <img title="Перехват вызова" class="icon-pickup" src="/images/buttons/pickup.png" ng-if="call.status != 1" ng-click="callPickup(call.id)"/>
                                <i title="Перевод" class="icon-pickup icon-share-alt" ng-click="callTransfer(call.id)"/></i>
                                <?php if(Yii::app()->user->checkAccess('supervisor')) { ?>
                                <i title="Подслушать" class="icon-pickup icon-headphones" ng-if="call.status == 1" ng-click="callOverhear(call.id)"/></i>
                                <i title="Мастер-ученик" class="icon-pickup icon-eye-close" ng-if="call.status == 1" ng-click="callMaster(call.id)"/></i>
                                <?php } ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
</table>
</div>
