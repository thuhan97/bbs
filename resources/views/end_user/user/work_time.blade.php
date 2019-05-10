@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@section('page-title', __l('work_time'))

@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('work_time') !!}
@endsection
@section('content')
    @if(session()->has('day_off_success'))
        @if(session()->get('day_off_success') != '')
            <script>
                swal({
                    title: "Thông báo!",
                    text: "Bạn đã gửi đơn thành công!",
                    icon: "success",
                    button: "Đóng",
                });
            </script>
        @else
            <script>
                swal({
                    title: "Thông báo!",
                    text: "Bạn đã sửa đơn thành công!",
                    icon: "success",
                    button: "Đóng",
                });
            </script>
        @endif
    @endif
    <i class="fa fa-icon-check"></i>
    <form name="dateChooser">
        <div class="row">
            <div class="col-xl-2 col-xxl-1 col-md-2 pr-1">
                <select id="chooseYear" class="mr-1 browser-default form-control float-left chooseYear"
                        name="chooseYear"></select>
            </div>
            <div class="col-xl-2 col-xxl-1 col-md-2 pr-0">
                <select name="chooseMonth" id="chooseMonth"
                        class="mr-1 browser-default custom-select float-right chooseMonth">
                </select>
            </div>
            <div class="col-md-8">
                <div class="row mb-3" id="form-check-time">
                    <button type="button" class="btn btn-danger no-box-shadow mt-0" id="btn-early-late">Số buổi đi
                        muộn/sớm:
                    </button>
                    <button type="button" class="btn btn-primary no-box-shadow mt-0" id="btn-ot">Số buổi OT:
                    </button>
                    <button type="button" class="btn btn-success no-box-shadow mt-0" id="btn-late-ot">Số
                        buổi đi muộn + OT:
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if ($errors->has('start_at'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('start_at') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('end_at'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('end_at') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('work_day'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('work_day') }}</strong>
        </span>
    @endif
    @if ($errors->has('ot_type'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('ot_type') }}</strong>
        </span>
    @endif
    @if ($errors->has('explanation_type'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('explanation_type') }}</strong>
        </span>
    @endif
    <div class="modal fade myModal" id="modal-form" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class='mg-center mg-left-10 modal-title w-100 font-weight-bold pt-2'>Xin phép</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('img/font/gio_lam_viec_popup.png') }}" alt="" width="355px" height="260px">
                </div>
                <br>
                <form action="{{ route('day_off_create_calendar') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div id="event"></div>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- [CALENDAR] -->
    <div id="container"></div>
@endsection
@push('extend-js')
    <script type="text/javascript">
        $(function () {
            var date = new Date(),
                current_year = date.getFullYear(), current_month = date.getMonth(),
                month = document.getElementById("chooseMonth"),
                year = document.getElementById("chooseYear");
            const currentDate = date.getDate();
            const currentMonth = date.getMonth();
            const currentYear = date.getFullYear();
            const currenFullTime = currentYear + '-' + currentMonth + '-' + currentDate;

            var showCalendar = function () {
                current_year = $("#chooseYear").val();
                current_month = $("#chooseMonth").val();
                showCalendar();
                renderCalendar(current_year, current_month);
            };

            $("#chooseMonth, #chooseYear").change(showCalendar);
            var calendar = {
                mName: ["Tháng 01", "Tháng 02", "Tháng 03", "Tháng 04", "Tháng 05", "Tháng 06", "Tháng 07", "Tháng 08", "Tháng 09", "Tháng 10", "Tháng 11", "Tháng 12"],
                valMonth: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
                getValMonth: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                data: null,
                sDay: 0,
                sMth: 0,
                cMth: 1,
                sYear: 0,
                list: function () {
                    showCalendar();
                    renderCalendar(current_year, current_month);
                },
                show: function (el) {
                    let currentMY = parseInt(currentYear) + parseInt(currentMonth),
                        calendarYM = calendar.sYear + calendar.sMth,
                        getDataTime = el.getAttribute("data-time"),
                        calendarFullTime = el.getAttribute("calendar-time"),
                        fullTime = new Date(calendarFullTime),
                        timeGetDay = new Date(getDataTime),
                        currentFullTime = new Date(currenFullTime);
                    if (el.getElementsByClassName("data-id")[0]) {
                        var dataReason = el.getElementsByClassName("data-reason")[0].innerHTML,
                            dataID = el.getElementsByClassName("data-id")[0].innerHTML,
                            dataWorkDay = el.getElementsByClassName("data-work-day")[0].innerHTML,
                            dataUserID = el.getElementsByClassName("data-user-id")[0].innerHTML,
                            dataType = el.getElementsByClassName("data-type")[0].innerHTML;
                        dataTypeOT = el.getElementsByClassName("data-ot-type")[0].innerHTML;
                        switch (true) {
                            case parseInt(dataTypeOT) === 1:
                                var projectOT = 'selected';
                                var otherOT = '';
                                break;
                            case parseInt(dataTypeOT) === 2:
                                var otherOT = 'selected';
                                var projectOT = '';
                                break;
                            default:
                                var projectOT = '',
                                    otherOT = '';
                        }

                        switch (true) {
                            case parseInt(dataType) === 1:
                                var data_nomal = '',
                                    data_late = 'checked',
                                    data_early = '',
                                    data_ot = '';
                                break;
                            case parseInt(dataType) === 2:
                                var data_nomal = '',
                                    data_late = '',
                                    data_early = 'checked';
                                ot = '';
                                break;
                            case parseInt(dataType) === 4:
                                var data_nomal = '';
                                data_late = '',
                                    data_early = '',
                                    data_ot = 'checked';
                                break;
                            default:
                                var late = '',
                                    early = '',
                                    ot = '';
                        }
                    }

                    function makeMoal() {
                        calendar.sDay = el.getElementsByClassName("dayNumber")[0].innerHTML;
                        if (el.getElementsByClassName("data-id")[0]) {
                            document.getElementById("div-reason").innerHTML =
                                '<div class="row col-md-12">' +
                                '<div class="row col-md-12">' +
                                '<div class="col-md-12 d-flex justify-content-center">' +
                                '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                '    <label for="late">Xin đi muộn </label>' +
                                '    <input ' + data_late + ' type="radio" id="late" class="user-radio2 radio-modal-work-time" name="explanation_type" value="1"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '</div>' +
                                '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                '    <label for="early">Xin về sớm </label>' +
                                '    <input ' + data_early + ' id="early" type="radio" class="user-radio3 radio-modal-work-time"  name="explanation_type" value="2"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '</div>' +
                                '</div>' +
                                '<input hidden name="id" value="' + dataID + '">' +
                                '<input hidden name="user_id" value="' + dataUserID + '">' +
                                '<input hidden name="work_day" value="' + dataWorkDay + '">' +
                                '<textarea class="form-control" name="reason" rows="6" placeholder="Nội dung bạn muốn gửi...">' + dataReason + '</textarea>' +
                                '</div>' +
                                '<div class="row col-md-12">' +
                                '</div>' +
                                '</div>';
                        } else {
                            document.getElementById("div-reason").innerHTML =
                                '<div class="row col-md-12">' +
                                '<div class="row col-md-12">' +
                                '<div class="col-md-12 d-flex justify-content-center">' +
                                '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                '    <label for="late">Xin đi muộn </label>' +
                                '    <input ' + data_late + ' type="radio" id="late" class="user-radio2 radio-modal-work-time" name="explanation_type" value="1"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '</div>' +
                                '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                '    <label for="early">Xin về sớm </label>' +
                                '    <input ' + data_early + ' id="early" type="radio" class="user-radio3 radio-modal-work-time"  name="explanation_type" value="2"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '</div>' +
                                '</div>' +
                                '<input hidden name="work_day" value="' + getDataTime + '">' +
                                '<input hidden name="type" value="1">' +
                                '<textarea class="form-control" name="reason" rows="6" placeholder="Nội dung bạn muốn gửi..."></textarea>' +
                                '</div>' +
                                '<div class="row col-md-12">' +
                                '</div>' +
                                '</div>';
                        }
                    }

                    if (parseInt(calendarYM) >= parseInt(currentMY)) {
                        if (timeGetDay.getDay() === 0 || timeGetDay.getDay() === 6 || currentFullTime === fullTime || calendarFullTime === currenFullTime) {
                            if (currentFullTime <= fullTime) {
                                if (dataWorkDay) {

                                    var workDay = dataWorkDay,
                                        id = dataID,
                                        dataReason = dataReason;
                                } else {
                                    var workDay = getDataTime,
                                        id = '',
                                        dataReason = '',
                                        dataID = '';
                                }
                                document.getElementById("div-reason").innerHTML =
                                    '<div class="row col-md-12">' +
                                    '<input hidden name="id" value="' + dataID + '">' +
                                    '<input type="hidden" name="work_day" value="' + getDataTime + '">' +
                                    '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                    '    <label for="late">Xin đi muộn </label>' +
                                    '    <input ' + data_late + ' type="radio" id="late" class="user-radio2 radio-modal-work-time" checked name="explanation_type" value="1"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                    '</div>' +
                                    '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                    '    <label for="early">Xin về sớm </label>' +
                                    '    <input ' + data_early + ' id="early" type="radio" class="user-radio3 radio-modal-work-time"  name="explanation_type" value="2"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                    '</div>' +
                                    '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                    '    <label for="ot">Xin OT</label>' +
                                    '    <input ' + data_ot + ' type="radio" id="ot" class="user-radio1 radio-modal-work-time" name="explanation_type" value="4"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                    '</div>' +
                                    '<textarea class="form-control mt-4" name="reason" rows="6" placeholder="Nội dung bạn muốn gửi...">' + dataReason + '</textarea>'
                                '</div>';
                                $('.user-radio3').change(function () {
                                    $('.user .demo').remove();
                                });
                                $('.user-radio2').change(function () {
                                    $('.user .demo').remove();
                                });
                                $('.user-radio1').change(function () {
                                    $('.user .demo').remove();
                                    $('.user-radio1:checked').parent().append('' +
                                        '<div class="demo"><select class="browser-default form-control float-left w-95"\n' +
                                        'name="ot_type"><option value="1" ' + projectOT + '>OT dự án</option><option value="2" ' + otherOT + '>OT cá nhân</option></select></div>');
                                });
                                $('.user-radio1:checked').parent().append('' +
                                    '<div class="demo"><select class="browser-default form-control float-left w-95"\n' +
                                    'name="ot_type"><option value="1" ' + projectOT + '>OT dự án</option><option value="2" ' + otherOT + '>OT cá nhân</option></select></div>');

                            } else {
                                makeMoal()
                            }
                        } else {
                            makeMoal();
                        }
                    }
                    if (parseInt(calendarYM) >= parseInt(currentMY)) {
                        $('.myModal').modal('show');
                    }
                },
            };
            window.addEventListener("load", function () {

                nowYear = parseInt(currentYear);

                for (var i = 0; i < 12; i++) {
                    var opt = document.createElement("option");
                    opt.value = calendar.valMonth[i];
                    opt.setAttribute("data-type", calendar.getValMonth[i]);
                    opt.innerHTML = calendar.mName[i];
                    if (i == currentMonth) {
                        opt.selected = true;
                    }
                    month.appendChild(opt);
                }

                for (var i = nowYear - 1; i <= nowYear; i++) {
                    var opt = document.createElement("option");
                    opt.value = i;
                    opt.innerHTML = i;
                    if (i == nowYear) {
                        opt.selected = true;
                    }
                    year.appendChild(opt);
                }
                calendar.list();
            });
            var showCalendar = function () {
                calendar.sMth = parseInt(month.value);
                calendar.sYear = parseInt(year.value);
                var daysInMth = new Date(calendar.sYear, calendar.sMth + 1, 0).getDate(),
                    startDay = new Date(calendar.sYear, calendar.sMth, 1).getDay(),
                    endDay = new Date(calendar.sYear, calendar.sMth, daysInMth).getDay();
                calendar.data = localStorage.getItem("calendar-" + calendar.sMth + "-" + calendar.sYear);
                if (calendar.data == null) {
                    localStorage.setItem("calendar-" + calendar.sMth + "-" + calendar.sYear, "{}");
                    calendar.data = {};
                } else {
                    calendar.data = JSON.parse(calendar.data);
                }

                var squares = [];
                if (startDay != 0) {
                    for (var i = 0; i < startDay; i++) {
                        squares.push("last");
                    }
                }

                for (var i = 1; i <= daysInMth; i++) {
                    squares.push(i);
                }

                if (endDay != 6) {
                    var blanks = endDay == 0 ? 6 : 6 - endDay;
                    for (var i = 0; i < blanks; i++) {
                        squares.push("next");
                    }
                }
                var container = document.getElementById("container"),
                    cTable = document.createElement("table");
                cTable.id = "calendar";
                container.innerHTML = "";

                container.appendChild(cTable);
                var cRow = document.createElement("tr"),
                    cCell = null,
                    days = ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];
                for (var d of days) {
                    cCell = document.createElement("td");
                    cCell.innerHTML = d;
                    cRow.appendChild(cCell);
                }

                cRow.classList.add("calendar-header");
                cTable.appendChild(cRow);
                cRow = document.createElement("tr");
                cRow.classList.add("calendar-body");

                var total = squares.length,
                    daysOfNextMonth = 1,
                    valYear = year.options[year.selectedIndex].value,
                    inputMonth = month.options[month.selectedIndex],
                    valMonth = inputMonth.value,
                    getValMonth = inputMonth.dataset.type,
                    lastDateOfLastMonth = valMonth == 0 ? new Date(valYear - 1, 12, 0).getDate() : new Date(valYear, valMonth, 0).getDate(),
                    firstDayOfCurrentMonth = new Date(valYear, valMonth, 0).getDay(),
                    dayOfLastMonth = lastDateOfLastMonth - firstDayOfCurrentMonth;

                for (var i = 0; i < total; i++) {
                    cCell = document.createElement("td");
                    cCell.classList.add("calendar-td-body");
                    var selectMonthYear = valYear + "-" + valMonth,
                        currentMonthYear = currentYear.toString() + "-" + currentMonth.toString();
                    if (selectMonthYear === currentMonthYear) {
                        var current_day = date.getDay();
                        var cells = document.getElementById('calendar').getElementsByTagName('td');
                        cells[current_day].style.backgroundColor = '#222222';
                        cells[current_day].style.color = '#f4f4f4';
                    }

                    if (squares[i] == "last") {
                        cCell.classList.add("blank");
                        cCell.setAttribute("disabled", "true");
                        cCell.innerHTML += "<div class='dayNumber calendar-td-body'>" + dayOfLastMonth++ + "</div>";
                    } else if (squares[i] == "next") {
                        cCell.classList.add("blank");
                        cCell.innerHTML = "<div class='dayNumber calendar-td-body'>" + daysOfNextMonth++ + "</div>";
                    } else {
                        cCell.addEventListener("dblclick", function () {
                            calendar.show(this);
                        });
                        var n = squares[i].toString().length;
                        if (n < 2) {
                            cCell.innerHTML = "<div class='dayNumber'>" + "0" + squares[i] + "</div>";
                            cCell.setAttribute("data-time", valYear + "-" + getValMonth + "-" + "0" + squares[i]);
                            cCell.setAttribute("calendar-time", valYear + "-" + valMonth + "-" + squares[i]);

                        } else {
                            cCell.innerHTML = "<div class='dayNumber'>" + squares[i] + "</div>";
                            cCell.setAttribute("data-time", valYear + "-" + getValMonth + "-" + squares[i]);
                            cCell.setAttribute("calendar-time", valYear + "-" + valMonth + "-" + squares[i]);
                        }
                    }
                    cRow.appendChild(cCell);
                    if (i != 0 && (i + 1) % 7 == 0) {
                        cTable.appendChild(cRow);
                        cRow = document.createElement("tr");
                        cRow.classList.add("calendar-body");
                    }
                }
            };
            var renderCalendar = function (year, month) {
                $.ajax({
                    url: '/thoi-gian-lam-viec-api',
                    dataType: 'json',
                    method: 'get',
                    data: {
                        year: current_year,
                        month: parseInt(current_month) + 1,
                    },
                    success: (respond) => {
                        let dataRes = respond.data,
                            dataModal = respond.dataModal;
                        dataRes.forEach(function (data) {
                            let work_day = data.work_day,
                                work_time = data.start_at + ' - ' + data.end_at;
                            $('.calendar-td-body').each(function () {
                                const data_time = $(this).data('time');
                                if (data_time === work_day) {
                                    $(this).addClass("data-type-" + data.type);
                                    $(this).addClass("type" + data.type);
                                    $(this).addClass("hasData");
                                    $(this).append('<p>' + work_time + '</p>');
                                }
                            });
                        });

                        dataModal.forEach(function (data) {
                            if (data.note != null) {
                                var note = data.note;
                            } else {
                                var note = '';
                            }
                            const work_day = data.work_day;
                            $('.calendar-td-body').each(function () {
                                const data_time = $(this).data('time');
                                if (data_time === work_day) {
                                    $(this).append('<p class="data-id" hidden>' + data.id + '</p>');
                                    $(this).append('<p class="data-user-id" hidden>' + data.user_id + '</p>');
                                    $(this).append('<p class="data-reason" hidden>' + note + '</p>');
                                    $(this).append('<p class="data-work-day" hidden>' + data.work_day + '</p>');
                                    $(this).append('<p class="data-ot-type" hidden>' + data.ot_type + '</p>');
                                    $(this).append('<p class="data-type" hidden>' + data.type + '</p>');
                                }
                            });
                        });
                        let type_1 = $('#calendar .data-type-1').length,
                            type_2 = $('#calendar .data-type-2').length,
                            type_4 = $('#calendar .data-type-4').length,
                            type_5 = $('#calendar .data-type-5').length,
                            earlyLate = type_1 + type_2;
                        $("#btn-early-late").text('Số buổi đi muộn/sớm: ' + earlyLate);
                        $("#btn-ot").text('Số buổi OT: ' + type_4);
                        $("#btn-late-ot").text('Số buổi đi muộn + OT: ' + type_5);
                    },
                    error: (data) => {
                        console.log(data.status);
                    },
                });
            };
        })
    </script>
@endpush
