var socket = io("https://instadeal.rebusel.com/", { transports: ['websocket'] });
var _token = $('meta[name="csrf-token"]').attr('content');
var uid = $('meta[name="uid"]').attr('content');
var cache = {};

if(uid){
    uid = uid;
}else{
    uid = $("#current-user").val();
}
socket.emit('set-userid', uid);

// socket.on('chat-message', res => {
    // console.log("from globalfunction js chat-message");
    // console.log(res);
// });

$("#show").html(socket);
function ajaxCall(url, data, type) {
    return $.ajax({
        url: url,
        data: data,
        type: type
    });
}

function sendSocketEvent(name, data, receivers) {
    socket.emit('event-send', {
        receivers: receivers,
        name: name,
        data: data
    });
}

function setUserId(uuid) {
    socket.emit('set-userid', uuid);
}

function getTime() {
    date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    hours = hours < 10 ? '0'+hours : hours;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes;
    return strTime;
}

function getDate() {
    let date = new Date();
    return `${date.getFullYear()}-${(date.getMonth() < 10 ? "0" + date.getMonth() : date.getMonth())}-${(date.getDate() < 10 ? "0" + date.getDate() : date.getDate())}`;
}
