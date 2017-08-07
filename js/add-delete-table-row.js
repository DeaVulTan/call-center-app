//Скриптик для добавления/удаления строк в тег tbody
//Вешаем событие на клик тега a для id addtr и deltr соответственно
$(document).ready(function($){
    

    $("#addtr").on('click', function(){
        var formTbody = $(this).parent().find("tbody#ivrEventsTable");
        var lastTr = formTbody.children("tr").last();
        lastId = parseInt(lastTr.attr('id'));
        newId = lastId+1;
        newTr = lastTr.clone();
        newTr.attr('id',newId);
        eventSel = newTr.find("#IvrEvent_"+lastId+"_event");
        keySel = newTr.find("#IvrEvent_"+lastId+"_key");
        if(!keySel.is('select')) {
            keySel.remove();
            frstTd = newTr.find('td:eq(0)');
            secTd = newTr.find('td:eq(1)');
            secTd.html('');
            keySel= $(JSON.parse($.ajax({
                url:'/atc/ivr/getkeylist',
                type:'POST',
                dataType:'json',
                async:false
            }).responseText).keys);
            delBtn = $('<a>', {href:'#', id:'deltr'+newId, 'class':'delete-row'}).html('-');
            secTd.append(keySel);
            frstTd.append(delBtn);
            delBtn.deleteRow();
        }
        valueSel = newTr.find("#IvrEvent_"+lastId+"_value");
        spanValue = newTr.find("#value"+lastId);
        eventSel.attr("id", "IvrEvent_"+newId+"_event");
        eventSel.attr("name", "IvrEvent["+newId+"][event]");
        eventSel.removeAttr("data_id");
        eventSel.attr("data-id", newId+"_"+0);
        keySel.attr("id", "IvrEvent_"+newId+"_key");
        keySel.attr("name", "IvrEvent["+newId+"][key]");
        valueSel.attr("id", "IvrEvent_"+newId+"_value");
        valueSel.attr("name", "IvrEvent["+newId+"][value]");
        spanValue.attr("id", "value"+newId);
        formTbody.find("select.eventKey > option:selected").each(function(){
            keySel.find("option[value='"+$(this).attr('value')+"']").remove();
        });
        formTbody.append(newTr);
//        $(this).toggleDel();
        $(this).toggleAdd();
        eventSel.setChange();
        return false;
    });
//    $("#deltr").on('click',function(){
//        var formTbody = $(this).parent().find("tbody#ivrEventsTable");
//        var lastTr = formTbody.children("tr").last();
//        lastTr.remove();
//        $(this).toggleDel();
//        $(this).toggleAdd();
//        return false;
//    });
    $('.delete-row').each(function(){
        $(this).deleteRow();
    });
    $('.eventSel').each(function(){
        $(this).bindChange();
    });
    $('.eventSel').on('change', function(){
        $(this).bindChange();
    });
});
jQuery.fn.deleteRow = function(){
    $(this).on('click',function(){
        delEl = $(this).parent().parent();
        delEl.remove();
        $(this).toggleAdd();
        return false;
    });
}
//jQuery.fn.toggleDel = function(){
//    countRows = $(this).parent().find("tbody#ivrEventsTable").children("tr").length;
//    if(countRows < 3) $("#deltr").hide();
//    else $("#deltr").show();
//};
jQuery.fn.toggleAdd = function(){
    countRows = $(this).parent().find("tbody#ivrEventsTable").children("tr").length;
    if(countRows == 14) $("#addtr").hide();
    else $("#addtr").show();
};
jQuery.fn.bindChange = function(){
    event = $(this).find(':selected').attr('value');
    params = $(this).attr('data-id').split('_');
    $.ajax({
        url:'/atc/ivr/getvalue',
        type:'POST',
        dataType:'json',
        async:false,
        data:{pos:params[0],event:event,selected:params[1]},
        success: function(data){if(data)$("#value"+params[0]).html(data.cell);}
        });
};
jQuery.fn.setChange = function(){
    $('.eventSel').on('change', function(){
        $(this).bindChange();
    });
};
