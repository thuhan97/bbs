window.addEventListener("load", function () {
    // selectMonths= {"01":"Tháng 1" , "02": "Tháng 2", "03":"Tháng 3", "04":"Tháng 4", "05":"Tháng 5", "06":"Tháng 6", "07": "Tháng 7", "08":"Tháng 8", "09":"Tháng 9","10":"Tháng 10", "11":"Tháng 11", "12":"Tháng 12"};
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth() + 1;
    var currentDate = new Date().getDate();
    $('#year').text(currentYear);

    for (var i = 1; i <= 12; i++) {
        var text = (i < 10) ? "Tháng 0" + i : "Tháng " + i;

        $('#month')
            .append($('<option>', {value: i})
                .text(text));
    }

    $('#month option[value=' + currentMonth + ']').attr('selected', 'selected');
    var i;
    for (i = 1; i <= 31; i++) {
        var text = (i < 10) ? "0" + i : i;
        $('#date').append($('<option>', {value: i})
            .text(text));
    }
    $('#date option[value=' + currentDate + ']').attr('selected', 'selected');

});
var selectInit = false;
$(function () {
    window.start_date = null;
    window.end_date = null;
    var $calendar = $('#calendar-meeting');
    var $month = $('#month');
    var $date = $('#date');

    function renderCalendar() {
        var data = {
                start: window.start_date,
                end: window.end_date,
            },
            month = $month.children("option:selected").val();
        date = $date.children("option:selected").val();
        data.month = month;
        data.date = date;
        $.ajax({
            url: '/get_calendar-booking',
            method: 'GET',
            dataType: 'JSON',
            data: data,
            success: function (response) {
                if (response.code == 200 && response.data.bookings) {
                    $calendar.fullCalendar('removeEvents');
                    var bookings = response.data.bookings;
                    $calendar.fullCalendar('addEventSource', bookings);
                    $calendar.fullCalendar('rerenderEvents');
                }
            }
        });
    }

    $month.change(function () {
        renderCalendar();
    });
    $date.change(function () {
        renderCalendar();
    });

    function resetModal() {
        $("#addMeeting .notice-error").hide();
        $("#addMeeting .error").removeClass('error');
        $("#addMeeting")[0].reset();
        if (selectInit)
            $('.selectpicker').selectpicker('refresh');
    }

    $calendar.fullCalendar({
        header: {
            left: 'prev,next today agendaDay,agendaWeek',
            center: 'title',
            right: ''
        },
        defaultView: 'agendaWeek',
        allDaySlot: false,
        minTime: "07:00",
        maxTime: "21:00",

        defaultDate: moment().format('YYYY-MM-DD'),
        locale: 'vi',
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        height: 720,
        eventRender: function (eventObj, $el) {
            // if (eventObj.has_me)
            //     $el.popover({
            //         title: eventObj.title,
            //         content: eventObj.description,
            //         trigger: 'hover',
            //         placement: 'top',
            //         container: 'body'
            //     });
        },
        viewRender: function (newView, oldView) {
            window.start_date = newView.start.format('Y/M/D');
            window.end_date = newView.end.format('Y/M/D');

            renderCalendar();
        },
        selectable: true,
        select: function (start, end, allDay = false) {
            resetModal();
            //do something when space selected
            $('#start_time').val(moment(start).format('HH:mm'));
            $('#end_time').val(moment(end).format(' HH:mm'));
            $('#days_repeat').val(moment(start).format('YYYY-MM-DD'));

            //Show 'add event' modal
            $('#addModal').modal('show');
            if (!selectInit)
                setTimeout(function () {
                    $(".btn-light").click();
                    selectInit = true;
                }, 300)
        },
        eventClick: function (calEvent, jsEvent, view) {
            var data = {
                'id': calEvent.id,
                'meeting_room_id': calEvent.description,
                'start_time': calEvent.start.format('HH:mm:00'),
                'end_time': calEvent.end.format('HH:mm:00'),
                'date': calEvent.start.format('YYYY-MM-DD'),
            };
            $.ajax({
                url: '/get-booking',
                data: data,
                type: 'GET',
                success: function (data) {
                    if (data) {
                        var booking = data.booking;
                        $('#id_booking').val(calEvent.id);
                        $('#start_date').val(calEvent.start.format('YYYY-MM-DD'));
                        $('#show-title').text(booking.title);
                        $('#show-content').text(booking.content);
                        $('#show-object').text(data.participants.join(', '));
                        $('#show-meeting').text(data.meeting);
                        $('#show-creator').text(booking.creator.name);
                        $('#show-date-create').text(booking.created_at);
                        $('#time').text(booking.start_time.substring(0, 5) + ' - ' + booking.end_time.substring(0, 5));
                        if (booking.users_id == userId) {
                            $('#showModal').find('.modal-footer').show();
                            $('#edit').click(function () {
                                $('#id').val(booking.id);
                                $('#title').val(booking.title);
                                $('#content').val(booking.content);
                                $('#participants').val(booking.participants);
                                $('.selectpicker').selectpicker('refresh');
                                $('#meeting_room_id').val(booking.meeting_room_id);
                                $('#show-creator').val(booking.creator.name);
                                $('#show-date-create').val(booking.created_at);
                                $('#start_time').val(moment(calEvent.start).format('HH:mm'));
                                $('#end_time').val(moment(calEvent.end).format('HH:mm'));
                                $('#days_repeat').val(booking.date);
                                (booking.is_notify == 0) ? $('input[name="is_notify"]').attr('checked', false) : $('input[name="is_notify"]').attr('checked', true);

                                if (data.type == 'PAST') {
                                    $('#repeat').css('display', 'none');
                                } else {
                                    $('input:radio[name="repeat_type"]').filter('[value=' + booking.repeat_type + ']').attr('checked', true);
                                }
                                $('#showModal').modal('hide');
                                $('#addModal').modal();

                            });
                        } else {
                            $('#showModal').find('.modal-footer').hide();
                        }
                        $('#showModal').modal();
                    }
                }
            });
            // delete
            $('#delete').click(function () {
                $.ajax({
                    url: 'delete-booking',
                    data: data,
                    type: 'GET',
                    success: function (data) {
                        $('#deleteModal').modal('hide');
                        $('#message').text('Bạn đã hủy thành công buổi họp!')
                        $('#deleteSuccessModal').modal();
                    },
                    fail: function (data) {
                        $('#deleteModal').modal('hide');
                        $('#message').text('Thao tác hủy không thành công!')
                        $('#deleteSuccessModal').modal();
                    }
                });

            });
        },
        eventAllow: function (dropLocation, item) {
            return item.user_id == userId && item.end.diff(new Date()) >= 0;
        },
        eventDrop: function (calEvent, next) {
            $('#days_repeat').val(calEvent.start.format('YYYY-MM-DD'));
        },
    });
});

$('#booking').click(function (event) {
    event.preventDefault();
    var repeat_type = $('[name="repeat_type"]:checked').val();
    var days_repeat = $('#days_repeat').val();
    var participants = [];
    $.each($(".selectpicker option:selected"), function () {
        participants.push($(this).val());
    });

    var meeting_room_id = $('#meeting_room_id').val();
    if (meeting_room_id == 1) $('#color').val('blue');
    else if (meeting_room_id == 2) $('#color').val('green');
    else if (meeting_room_id == 3) $('#color').val('orange');
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var title = $('#title').val();
    var content = $('#content').val();
    var is_notify = $('input[name="is_notify"]:checked').val();
    is_notify = (is_notify) ? is_notify : "0";
    var _token = $('#_token').val();
    var color = $('#color').val();
    var id = $('#id').val();
    if (id > 0) var url = '/sua-phong-hop/' + id;
    else var url = '/them-phong-hop';
    $("#addMeeting .error").removeClass('error');
    $("#addMeeting .notice-error").hide();

    $.ajax({
        url: url,
        type: "post",
        data: {
            "_token": _token,
            "participants[]": participants,
            "meeting_room_id": meeting_room_id,
            "title": title,
            "content": content,
            "start_time": start_time,
            "end_time": end_time,
            "repeat_type": repeat_type,
            "is_notify": is_notify,
            "days_repeat": days_repeat,
            "color": color
        },

        success: function (data) {
            if (data.status == 422) {
                if (data.errors.participants) {
                    $('.btn-light').addClass("error");
                    $('.selectpicker').change(function () {
                        $('.btn-light').removeClass("error");
                    });

                }
                $.each(data.errors, function (i, error) {
                    var el = $('#' + i);
                    el.addClass("error");
                    el.change(function () {
                        $(this).removeClass("error");
                    });
                });
                $("#addMeeting .notice-error").show();
            } else if (data.status == 500) {
                if (data.duplicate) {
                    $('#meeting_room_id').addClass("error");
                    $('#alert_message').html('Phòng họp đã sử dụng trong thời gian được chọn. <br /> Vui lòng chọn lại!')
                    $('#alertModal').modal();
                } else if (data.unauthorized) {
                    $('#alert_message').html('Bạn không có quyền sửa lịch họp này!')
                    $('#alertModal').modal();
                }
            } else if (data.success) {
                console.log(data.success)
                location.reload();
            }
        },
        error: function (data) {

        }
    });

});


$('#deleteMessage').click(function () {
    $('#showModal').modal('hide');
    $('#deleteModal').modal();
});


$('#ok').click(function () {
    $('#deleteSuccessModal').modal('hide');
    location.reload();
});
$('#cancel').click(function () {
    $('#deleteModal').modal('hide');
    $('#showModal').modal();
});
