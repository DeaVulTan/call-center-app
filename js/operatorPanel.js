// разница между серверным временем и локальным
diffTime = false;

$( document ).ready(function(){
    angular.module('MyApp', ['timer', 'angular-websocket'])
        .config(function(WebSocketProvider) {
            var cometSid = angular.element(document.querySelector('#ws-url')).data('wsCometSid');
            var cometUrl = angular.element(document.querySelector('#ws-url')).data('wsCometUrl');
            WebSocketProvider
                .prefix('')
                .uri('ws://' + cometUrl + '/poll?&cometsid=' + cometSid);
        })

        .controller('operatorPanel', function($scope, WebSocket) {
            $scope.calls = [];
            $scope.showAllQueues = false;
            $scope.showAllOperators = false;
            $scope.showAllQueuesTitleBtn = "Показать все";
            $scope.onlineStatus = 0;
            $scope.queues = {};

            // обработка сообщений из WebSocket
            WebSocket.onmessage(function(event) {
                var data = JSON.parse(event.data);
                if (typeof data === 'object') {
                    if (data.body.type == 'opPanel_update') {
                        $.getJSON('/callcenter/operatorpanel/getData', function(panelData) {
                            $scope.updateData(panelData);
                        });
                    }
                }
            });
            WebSocket.onclose(function() {
            });
            WebSocket.onopen(function() {
                var channel = angular.element(document.querySelector('#ws-url')).data('wsChannel');
                WebSocket.send('subscribe:' + channel);
            });
            $scope.redirectCall = function(id){
                $.post('/callcenter/operatorpanel/redirectcall', {'id':id});
            };

            $scope.callPickup = function(id){
                $.post('/callcenter/operatorpanel/callpickup', {'id': id});
            };

            $scope.callTransfer = function(id){
                $('[name="callTransferCallId"]').val(id);
                $('#callTransfer').modal("show");
            };

            $scope.callOverhear = function(id){
                if (confirm("Включить подслушивание?")) {
                    $.post('/callcenter/operatorpanel/calloverhear', {'id': id});
                }
            };

            $scope.callMaster = function(id){
                if (confirm("Включить режим мастер-ученик?")) {
                    $.post('/callcenter/operatorpanel/callmaster', {'id': id});
                }
            };

            $scope.switchQueuesShow = function() {
                $scope.showAllQueues = !$scope.showAllQueues;

                if ($scope.showAllQueues) {
                    $scope.showAllQueuesTitleBtn='Нормальный режим';
                } else {
                    $scope.showAllQueuesTitleBtn='Показать все';
                }
            };

            function getTime(time) {
                var curTime = new Date();
                var dDiff = curTime.getTime() - time.getTime() + diffTime;
                var hours = Math.floor(dDiff / 1000 / 60 / 60);
                var minutes = Math.floor(dDiff / 1000 / 60) % 60;
                var seconds = Math.floor(dDiff / 1000) % 60;

                if ($.isNumeric(hours) && $.isNumeric(minutes) && $.isNumeric(seconds)) {
                    return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes + ':' + (seconds <= 9 ? "0" : "") + seconds;
                }

                return "00:00:00";
            }

            $scope.compareGroup = function(groups) {
                // Если в groups содержится null, то значит это админ
                if ($scope.data.groups == null) {
                    return true;
                }

                for (var key in $scope.data.groups) {
                    if ($.inArray($scope.data.groups[key], groups) > -1) {
                        return true;
                    }
                }

                return false;
            };

            /**
             * Обновление панели оператора на основании переданных данных
             * @param data
             */
            $scope.updateData = function(data) {
                $scope.data = data;
                $scope.$apply();
                diffTime = new Date(data['currentTime']) - new Date();

                if (data && data['noteForms']) {
                    var call_active = [];
                    for (var call in data['noteForms']) {
                        var cc = data['noteForms'][call];
                        call_active.push(cc.linkedid);
                        if ($.inArray(cc.linkedid, $scope.calls) != -1) {
                            continue;
                        }
                        $scope.calls.push(cc.linkedid);
                        $('#tabs_nav_my_call')
                            .append(
                                $('<li></li>')
                                    .html('<a href="#tabCall_'+ cc.linkedid +'" style="color: #' + cc.color + '">' + cc.title + ' ' + (cc.name == null ? '' : cc.name) + '</a>')
                            );
                        $('#tabs_content_my_call')
                            .append(
                                $('<div></div>')
                                    .addClass('tab-pane')
                                    .attr('id', 'tabCall_'+ cc.linkedid)
                                    .html('<img src="/images/sms_send.png" class="send-sms" title="Отправка СМС" style="cursor:pointer; width:28px"><span name="call_time" style="float:right;font-weight:bold;" time="' + cc.time + '" linkedid="' + cc.linkedid + '"></span><br>' + cc.form)
                            );
                        $('#tabs_nav_my_call a:last').tab('show');
                    }

                    $('#tabs_nav_my_call a').click(function (e) {
                        e.preventDefault();
                        $(this).tab('show');
                    });

                    $('span[name=call_time]').not('time-stop').each(function (e) {
                        var linkedid = $(this).attr('linkedid');
                        if ($.inArray(linkedid, call_active) == -1) {
                            $(this).addClass('time-stop');
                        }
                    });

                    $('.send-sms').click(function(){
                        $('[name="smsLinkedId"]').val($(this).parent().attr('id').replace('tabCall_', ''));
                        $('[name="smsText"]').val('');

                        $('#smsSend').modal("show");
                    });

                    $('span[name=call_time]').not('time-stop').each(function (e) {
                        var linkedid = $(this).attr('linkedid');
                        if ($.inArray(linkedid, call_active) == -1) {
                            $(this).addClass('time-stop');
                        }
                    });

                    (function setTimeUpdater() {
                        $('span[name=call_time]').each(function(){
                            var time = new Date($(this).attr('time'));
                            if (!$(this).hasClass('time-stop')) {
                                $(this).html(getTime(time));
                            }
                        });
                        setTimeout(setTimeUpdater,1000);
                    })();
                }
            };

            setTimeout(function() {$scope.updateData($scope.initData)}, 100);
        })
});


/**
 * Кнопка закрытия формы опроса при звонке
 */
$('.op-noteform-close').live('click', function(){
    var form = $(this).parent();
    var callId = form.find('input[name=linkedid]').attr('value');
    $('#tabCall_' + callId).remove();
    $('#tabs_nav_my_call').children('li.active').remove();
    $('#tabs_nav_my_call a:last').tab('show');
});

/**
 * Кнопка сохранения формы отчета при звонке
 */
$('#noteForm').live('submit', function() {
    var form = $(this);
    var callId = form.find('input[name=linkedid]').attr('value');
    $.post($('#noteForm').attr('action'), form.serialize(), function(data) {
        if (data === 'ok') {
            $('#tabCall_' + callId).remove();
            $('#tabs_nav_my_call').children('li.active').remove();
            $('#tabs_nav_my_call a:last').tab('show');
        }
        else {
            form.append('<br /><div class="alert in alert-block fade alert-error"><a class="close" data-dismiss="alert">×</a>' + data + '</div>');
        }
    });
    return false;
});


/**********************************************************
 Сохранение и загрузка текущего состояния панели оператора
 **********************************************************/
var defaultPanelCfg = {
    'col1': {
        width: '33%',
        widgets: ['switches']
    },
    'col2': {
        width: '33%',
        widgets: ['my_call', 'my_queue']
    },
    'col3': {
        width: '33%',
        widgets: ['statistics', 'operators']
    }
};

$(document).ready(function() {
    // Если переносить из одного столбца в другой, то update срабатывает 2 раза, это решает проблему
    var sortableUpdateLock = false;

    (function heartbeat() {
        $.ajax({
            url: '/',
            type: 'GET'
        }).always(function() {
            setTimeout(heartbeat, 120000);
        });
    }());

    /**
     * Получение текущего состояния панели оператора
     * @returns {{col1: *, col2: *, col3: *}}
     */
    function getWidgetPosition() {
        function getColInfo(col) {
            var widgets = [];
            if (col.find('#switches').length > 0) {
                widgets.push('switches');
            }
            if (col.find('#my_call').length > 0) {
                widgets.push('my_call');
            }
            if (col.find('#my_queue').length > 0) {
                widgets.push('my_queue');
            }
            if (col.find('#operators').length > 0) {
                widgets.push('operators');
            }
            if (col.find('#statistics').length > 0) {
                widgets.push('statistics');
            }

            return {
                'width': (Math.round(col.width() / $('#content').width() * 100)) + '%',
                'widgets': widgets
            };
        }

        return {
            'col1': getColInfo($('.col1')),
            'col2': getColInfo($('.col2')),
            'col3': getColInfo($('.col3'))
        };
    }

    /**
     * Настройка панели оператора в соотв. с переданными дастройками
     * @param data
     */
    function setWidgetPosition(data) {
        function setColumn (col, data) {
            var widthColPx = $('#content').width() / 100 * data.width.replace('%', '');
            col.css('width', widthColPx + 'px');
            if (!data.widgets || data.widgets.length == 0) {
                return;
            }

            for (var widget in data.widgets) {
                $('#' + data.widgets[widget]).parent().appendTo(col);
            }
        }

        setColumn($('.col1'), data.col1);
        setColumn($('.col2'), data.col2);
        setColumn($('.col3'), data.col3);
        resetColResizable();
    }

    /**
     * Инициализация изменяемости панели оператора
     */
    function resetColResizable() {
        var table = $('#widget_grid');
        table.colResizable({disable:true});
        table.colResizable({
            liveDrag:true,
            minWidth:200,
            onResize: function() {
                saveColCfg();
            }
        });
        table.show();
    }

    /**
     * Сохранение текущего состояния панели оператора в бд
     */
    function saveColCfg() {
        $.ajax({
            url: '/callcenter/operatorpanel/savepanelcfg',
            type: 'POST',
            data: getWidgetPosition(),
            success: function() {
                sortableUpdateLock = false;
            }
        });
    }

    /**
     * Загрузка последнего сохраненного состояния панели оператора из бд
     * если в бд нет данных, то выставляется состояние по умолчанию
     */
    function loadColCfg() {
        $.ajax({
            url: '/callcenter/operatorpanel/loadpanelcfg',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data) {
                    data = defaultPanelCfg;
                }
                setWidgetPosition(data);
            }
        });
    }

    /**
     * Кнопка сброса на строек панели оператора на настройки по умолчанию
     */
    $('#resetPanelCfg').click(function(){
        if (confirm("Сбросить настройки панели оператора?")) {
            setWidgetPosition(defaultPanelCfg);
            saveColCfg();
        }
    });

    resetColResizable();
    loadColCfg();

    /**
     * Инициализация возможности переноса виджетов по панели оператора
     */
    $(".column").sortable({
        connectWith:".column",
        handle: '.portlet-header',
        update: function() {
            if (sortableUpdateLock == false) {
                sortableUpdateLock = true;
                saveColCfg();
            }
        }
    });

    $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
        .find(".portlet-header")
        .addClass("ui-widget-header ui-corner-all")
        .end()
        .find(".portlet-content");
});
