Notification.requestPermission();

$(function () {

    var bbsChannel = pusher.subscribe('bbs');

//public channel
    bbsChannel.bind('App\\Events\\PostNotify', function (notice) {
        var data = notice.data;
        myNotify.pushNotify('Thông báo', data.name, null, data.url, data.logo_url);
    });

    bbsChannel.bind('App\\Events\\MeetingNoticeEvent', function (notice) {
        var data = notice.data;
        if (data.user_ids.indexOf(userId) >= 0)
            myNotify.pushNotify(data.title, data.content, null, data.url, data.logo_url);
    });

    bbsChannel.bind('App\\Events\\WorkExperienceNoticeEvent', function (notice) {
        var data = notice.data;
        myNotify.pushNotify(data.name +' đã chia sẻ kinh nghiệm làm việc', data.introduction, data.image_url, data.url, data.logo_url);
    });


    var myChannel = pusher.subscribe('private-users.' + userId);

//private channel
    myChannel.bind('App\\Models\\User.' + userId, function (data) {
        console.log(JSON.stringify(data));
    });
    myChannel.bind('App\\Events\\UserNotice', function (data) {
        console.log(JSON.stringify(data));
    });
    myChannel.bind('App\\Events\\ReportCreatedNoticeEvent', function (notice) {
        var data = notice.data;
        myNotify.pushNotify(data.title, data.content, data.image_url, data.url, data.logo_url);
    });
    myChannel.bind('App\\Events\\ReportReplyNoticeEvent', function (notice) {
        var data = notice.data;
        myNotify.pushNotify(data.title, data.content, data.image_url, data.url, data.logo_url);
        if (window.commentReport) {
            window.commentReport(data.id, data.name, data.image_url, data.content);
        }
    });
    myChannel.bind('App\\Events\\SuggestionNotifyEvent', function (notice) {
        var data = notice.data;
        myNotify.pushNotify(data.title, data.content, data.image_url, data.url, data.logo_url);
    });

    var $notification = $("#notification");
    var $btnBell = $("#btnNotification");
    var $lblBagde = $(".lblNotifyBagde");

    var MyNotify = function notify() {

    };

    MyNotify.prototype.pushNotify = function (title, content, image, link, icon) {
        if (!image) image = window.system_image;
        if (!link) link = location.origin;
        if (!icon) icon = 'fa fa-flag black-text';
        content = strip(content);
        //add to notification list
        var $template = $("#notification_template").children().first().clone();
        $template.find('.notice-title').text(title);
        $template.find('.notice-text').text(content);
        $template.find('.notice-icon').addClass(icon);
        $template.find('.rounded-circle').attr('src', image);

        $notification.prepend($template);
        $template.click(function () {
            location.href = link;
        });
        var $time = $template.find('.time-subcribe');
        $time.attr('data-time', (new Date()).toLocaleString());
        $time.text('Vừa xong');
        subcribeList.push($time[0]);
        this.increaseUnread();

        this.ringing();
        //web notification

        if (Notification.permission === "granted") {
            var notification = new Notification("[BBS] " + title, {body: content, icon: image});
            notification.onclick = function () {
                window.open(link);
            }
        }
    };

    MyNotify.prototype.increaseUnread = function () {
        //increase unread count
        var unreadCount = $lblBagde.attr('data-count');
        unreadCount++;
        $lblBagde.attr('data-count', unreadCount).text(unreadCount).show();
    };

    MyNotify.prototype.ringing = function () {
        //ringing bell
        var $bell = $btnBell.find('.bell');
        $bell.addClass('ring');
        window.setTimeout(function () {
            $bell.removeClass('ring');
        }, 3000)
    };

    window.myNotify = new MyNotify();

    function strip(html) {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }
});
