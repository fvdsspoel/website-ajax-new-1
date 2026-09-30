var id = $('#last-convo').val();
var send_to = $('#send-to').val();
var agent_id = $('#agent-id').val();
var product_id = null;
if(id){
    var compose_new = false;
}else{
    var compose_new = true;
}
var conversation = null;
var uid = parseInt($("#current-user").val());

var temp_receivers = [];

$(document).on('click', '.view-conversation', function() {
    id = $(this).attr('value');
    $(this).removeClass('unread');
    $('.view-conversation').removeClass('active');
    $(this).addClass('active');
    $.get(`/chats/show/${id}`, function(res) {
        conversation = res;
        console.log(res);
        $('#send-to').val(res.created_by.id);
        compose_new = false;
        $('#title').html(res.title);
        $('#compose').hide();
        $('#chats').show();
        $('#chats').empty();
        let bubb = `<div class="sent p-2"><div class="chat-msg">Hi! How can we help you?</div></div>`
        $('#chats').append(bubb);
        for (const m of res.messages) {
            chatBubbles(m);
        }
    })
    .fail((err) => {
        showHttpErrorAlert(err);
    })
});

$(document).ready(function() {
    $("#chat-modal").hide();
    $("#chat-modal .close").click(function () {
        $("#chat-modal").hide();
        $(".btn-chat").show();
    });
});

function chatProperty(pid){
    // alert(pid);
    $('#sub-title').text('Inquiry for ' + $('#product-name').val());
    product_id = pid;
    id = $('#product-convo-id').val();
    $("#chat-modal").show();
    $(".btn-chat").hide();
    $(this).removeClass('unread');
    $('.view-conversation').removeClass('active');
    $(this).addClass('active');
    if (id != '') {
        compose_new = false;
        $.get(`/chats/show/${id}`, function(res) {
            conversation = res;
            $('#title').html(res.title);
            $('#compose').hide();
            $('#chats').show();
            $('#chats').empty();
            let bubb = `<div class="receive p-2"><div class="chat-msg">Hi! How can we help you?</div></div>`
            $('#chats').append(bubb);
            $('#chats').scrollTop($('#chats')[0].scrollHeight);
            for (const m of res.messages) {
                chatBubbles(m);
            }
        })
            .fail((err) => {
                if (err.status == 401) {
                    showErrorAlert('Error', 'Please Login First!');
                } else {
                    showHttpErrorAlert(err);
                }
            });
    } else {
        compose_new = true;
        $('#compose').hide();
        $('#chats').show();
        $('#chats').empty();
        let bubb = `<div class="receive "><div class="chat-msg">Hi! How can we help you?</div></div>`
        $('#chats').append(bubb);
        $('#chats').scrollTop($('#chats')[0].scrollHeight);
    }
}

function chat(){
    product_id = null;
    id = $('#last-convo').val();
    $('#sub-title').text('Ajax Trading Corporation');
	$("#chat-modal").show();
    $(".btn-chat").hide();
    $(this).removeClass('unread');
    $('.view-conversation').removeClass('active');
    $(this).addClass('active');
    if (id != '') {
        compose_new = false;
        $.get(`/chats/show/${id}`, function(res) {
            conversation = res;
            console.log(res);
            $('#title').html(res.title);
            $('#compose').hide();
            $('#chats').show();
            $('#chats').empty();
            let bubb = `<div class="receive p-2"><div class="chat-msg">Hi! How can we help you?</div></div>`
            $('#chats').append(bubb);
            $('#chats').scrollTop($('#chats')[0].scrollHeight);
            for (const m of res.messages) {
                chatBubbles(m);
            }
        })
            .fail((err) => {
                if (err.status == 401) {
                    showErrorAlert('Error', 'Please Login First!');
                } else {
                    showHttpErrorAlert(err);
                }
            });
    } else {
        compose_new = true;
        $('#compose').hide();
        $('#chats').show();
        $('#chats').empty();
        let bubb = `<div class="receive "><div class="chat-msg">Hi! How can we help you?</div></div>`
        $('#chats').append(bubb);
        $('#chats').scrollTop($('#chats')[0].scrollHeight);
    }
}

function chatBubbles(m) {
	let bubble = ``;
    if (m.created_by.id == uid) {
        if ((m.deleted_users_array != null) && ((m.deleted_users_array.includes('0')) || (m.deleted_users_array.includes(uid)))) {
            bubble = `<div class="sent" id="msg${m.id}" data-toggle="tooltip" title="${m.formatted_date}"><div class="chat-msg deleted">This message was deleted</div></div>`;
        } else {
            bubble = `<div class="sent" id="msg${m.id}" data-toggle="tooltip" title="${m.formatted_date}"><div class="chat-msg">${m.message} <span class="dt-formatted">${m.formatted_date}</span> </div></div>`;
        }
    } else {
        if ((m.deleted_users_array != null) && ((m.deleted_users_array.includes('0')) || (m.deleted_users_array.includes(uid)))) {
            bubble = `<div class="receive " id="msg${m.id}" data-toggle="tooltip" title="${m.formatted_date}"><div class="chat-msg deleted">This message was deleted</div></div>`;
        } else {
            bubble = `<div class="receive " id="msg${m.id}" data-toggle="tooltip" title="${m.formatted_date}"><div class="chat-msg">${m.message} <span class="dt-formatted">${m.formatted_date}</span> </div></div>`;
        }
    }
	$('#chats').append(bubble);
	$('#chats').scrollTop($('#chats')[0].scrollHeight);
}

function sendMessage(){
    product_type = $('#product-type').val() ?? 'Buildable';
    if (/\S/.test($('#message_text').val())) {
        if (compose_new == true) {
            if (send_to == null) {
                showErrorAlert('Warning', 'Please select a recipient');
                return;
            }
            showLoader('Sending', 'Please wait...');
            $.ajax({
                type: "post",
                url: "/chats/store",
                data: {
                    _token: _token,
                    send_to: send_to,
                    agent_id:agent_id,
                    message: $('#message_text').val(),
                    auto_reply: 1,
                    product_id:product_id,
                    product_type:product_type
                },
                dataType: 'JSON',
                beforeSend: function () {
                    $("#chatMessageSendBtn").attr('disabled', 'disabled');
                },
                success: function (res) {
                    Swal.close();
                    // console.log(res);
                    id = res.id;
                    compose_new = false;
                    $("#chatMessageSendBtn").removeAttr('disabled');
                    $('#message_text').val(null);
                    temp_receivers = res.receivers;
                    uid = res.sender.id;
                    setUserId(uid);
                    sendSocketEvent('new-chat', res, res.receivers);
                    if (res.auto_reply !== undefined) {
                        sendSocketEvent('chat-message', res.auto_reply, res.receivers);
                    }
                },
                error: function(err) {
                    console.log(err);
                    if (err.status == 401) {
                        showErrorAlert('Error', 'Please Login First!');
                    } else {
                        showHttpErrorAlert(err);
                    }
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "/chats/message",
                data: {
                    _token: _token,
                    cid: id,
                    message: $('#message_text').val(),
                    auto_reply: 1
                },
                dataType: 'JSON',
                success: function (res) {
                    $('#message_text').val(null);
                    sendSocketEvent('chat-message', res, getReceivers());
                    if (res.auto_reply !== undefined) {
                        sendSocketEvent('chat-message', res.auto_reply, getReceivers());
                    }
                },
                error: function(error) {
                    showHttpErrorAlert(error);
                }
            });
        }
    }
}

socket.on('new-chat', res => {

    id = res.id;
    temp_receivers = res.receivers;
    let bubble = ``;
    if (res.sender.id == uid) {
        bubble = `<div class="sent" data-toggle="tooltip" title="${res.date}"><div class="chat-msg">${res.last_message} <span class="dt-formatted">${res.date}</span> </div></div>`;
    } else {
        bubble = `<div class="receive " data-toggle="tooltip" title="${res.date}"><div class="chat-msg">${res.last_message} <span class="dt-formatted">${res.date}</span> </div></div>`;
    }

    $('#chats').append(bubble);
    $('#chats').scrollTop($('#chats')[0].scrollHeight);
});

socket.on('chat-message', res => {
    if (id == res.conversation_id) {
        chatBubbles(res);
    } else {
        if (res.created_by.id !== uid) {
            $(`#conversation-${res.conversation_id}`).addClass('unread');
        }
    }
    $(`#conversation-${res.conversation_id}`).prependTo('#messages');
    $(`#conversation-${res.conversation_id}`).find('.date').html(res.formatted_date);
    $(`#conversation-${res.conversation_id}`).find('.message').html(res.message);
});

socket.on('delete-msg', res => {
    let title = res.title;
    let elementid = "msg"+res.id;
    if (res.created_by.id == uid) {
    }

    if ((res.deleted_users_array.includes('0')) || (res.deleted_users_array.includes(uid))) {
        let d_html = `<div class="chat-msg deleted">This message was deleted</div>`;
        $('#'+elementid).html(d_html);
    } else {
    }

});

function getReceivers() {
    let receivers = [];
    if(temp_receivers.length == 0){
        for (const member of conversation.members) {
            receivers.push(member.user_id.id);
        }
    }else{
        receivers = temp_receivers;
    }

    return receivers;
}
