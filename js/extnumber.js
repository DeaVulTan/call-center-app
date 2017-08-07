//Скриптик для добавления/удаления строк в тег tbody
//Вешаем событие на клик тега a для id addtr и deltr соответственно
$(document).ready(function($){
    $('.eventSel').on('change', function(){
        $(this).bindChange();
    });
    $('.eventSel').each(function(){
        $(this).bindChange();
    });
});

jQuery.fn.bindChange = function(){
    event = $(this).find(':selected').attr('value');
    params = $(this).attr('data-id').split('_');
    $.ajax({
        url:'/atc/extnumber/getvalue',
        type:'POST',
        dataType:'json',
        async:false,
        data:{pos:params[0],event:event,selected:params[1]},
        success: function(data){
            if(data)$("#value"+params[0]).html(data.cell);
        }
        });
};