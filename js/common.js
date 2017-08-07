function checkMessage() {
    $.ajax({
        url: '/callcenter/message/check',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (checkNewMessages(data)) {
                document.getElementById('newMessageAudio').play();
            }
            var newMessageSpan = $('#newMessageSpan');
            newMessageSpan.html((data == '0') ? '' : '(' + data + ')');
        }
    });
}

function checkNewMessages(count) {
    var currentMessages = $.cookie('currentMessages');
    $.cookie('currentMessages', count, { 'path':'/' });

    // Если это первый заход и кука не была установлена
    if (currentMessages === undefined) {
        return false;
    }

    // Если кол-во не прочитанных уменьшилось или не изменилось
    if (count <= currentMessages) {
        return false;
    }

    return true;
}

checkMessage();
setInterval(checkMessage, 30000);
