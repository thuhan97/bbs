var bbsChannel = pusher.subscribe('bbs');

//public channel
bbsChannel.bind('App\\Events\\PostNotify', function (data) {
    console.log(JSON.stringify(data));
});
bbsChannel.bind('App\\Events\\ReportCreatedNoticeEvent', function (data) {
    console.log(JSON.stringify(data));
});

var myChannel = pusher.subscribe('private-users.' + userId);

//private channel
myChannel.bind('App\\Models\\User.' + userId, function (data) {
    console.log(JSON.stringify(data));
});
myChannel.bind('App\\Events\\UserNotice', function (data) {
    console.log(JSON.stringify(data));
});
