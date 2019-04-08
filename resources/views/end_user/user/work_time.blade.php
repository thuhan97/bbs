@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('work_time') !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4 pr-0 select-month-calendar">
            <form name="dateChooser">
                <select id="year" class="w-22 mr-1 browser-default form-control float-left chooseYear"
                        name="chooseYear"
                        onChange="calendar.list()"></select>
                <select name="chooseMonth" onChange="calendar.list()" id="month"
                        class="w-74 mr-1 browser-default custom-select float-right chooseMonth">
                </select>
            </form>
        </div>
        <div class="col-md-8">
            <div class="row mb-4">
                <form method="get">
                    <input hidden name="month">
                    <input hidden name="type" value="di_muon">
                    <button type="button" class="btn btn-danger" onclick="exec_submit(0)">Số buổi đi
                        muộn/sớm: {{$late}}</button>
                </form>
                <form method="get">
                    <input hidden name="month">
                    <input hidden name="type" value="ve_som">
                    <button type="button" class="btn btn-primary" onclick="exec_submit(1)">Số buổi
                        OT: {{$early}}</button>
                </form>
                <form method="get">
                    <input hidden name="month">
                    <input hidden name="type" value="ot">
                    <button type="button" class="btn btn-success" onclick="exec_submit(2)">Số buổi đi muộn +
                        OT: {{$ot}}</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade myModal" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('img/font/gio_lam_viec_popup.png') }}" alt="" width="355px" height="260px">
                </div>
                <br>
                <form action="{{ route('day_off_create') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason">
                        {{--<textarea class="form-control w-90" name="reason" id="" rows="6"--}}
                        {{--placeholder="Nội dung bạn muốn gửi..."></textarea>--}}
                    </div>
                    <div id="event"></div>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- [EVENT] -->
    {{--<div id="event"></div>--}}
    <!-- [CALENDAR] -->
    <div id="container"></div>
    <script type="text/javascript">
        var id = 0;

        function exec_submit(i) {
            var f = document.forms[i];
            if (getParam('month') == null) {
                var d = new Date();
                var m = d.getMonth();
                f.month.value = m + 1;
            } else {
                f.month.value = getParam('month');
            }
            f.action = "/thoi-gian-lam-viec";
            f.submit();
        }

        function getParam(param) {
            var results = new RegExp('[\?&]' + param + '=([^&#]*)').exec(window.location.href);
            if (results == null) {
                return null;
            }
            return decodeURI(results[1]) || 0;
        }

        $('.feedback').click(function () {
            id = $(this).attr('data-id')
        });

        $('.complain').click(function () {
            var message = $('.modal-body textarea').val();
            $('#feedback').modal('hide');
        });


        /**
         *          Create calendar
         */
        var dataCalendar = [
                @foreach($calendarData as $data)
            [
                "{{ $data['work_day'] }}",
                "{{  $data['start_at'] }}",
                "{{ $data['end_at'] }}",
                "{{ $data['type'] }}",
                "{{ $data['note'] }}",
                "{{ $data['attendance-time'] }}",
                "{{ $data['id'] }}",
            ],
            @endforeach
        ];
        var calendar = {
            mName: ["Tháng 01", "Tháng 02", "Tháng 03", "Tháng 04", "Tháng 05", "Tháng 06", "Tháng 07", "Tháng 08", "Tháng 09", "Tháng 10", "Tháng 11", "Tháng 12"],
            valMonth: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            getValMonth: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
            data: null,
            sDay: 0,
            sMth: 0,
            sYear: 0,
            list: function () {
                calendar.sMth = parseInt(document.getElementById("month").value);
                calendar.sYear = parseInt(document.getElementById("year").value);
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
                    days = ["Chủ nhật", "Thứ hai", "Thứ hai", "Thứ ba", "Thứ năm", "Thứ sáu", "Thứ bảy"];
                for (var d of days) {
                    cCell = document.createElement("td");
                    cCell.innerHTML = d;
                    cRow.appendChild(cCell);
                }
                cRow.classList.add("calendar-header");
                cTable.appendChild(cRow);
                cRow = document.createElement("tr");
                cRow.classList.add("calendar-body");

                var total = squares.length;
                var daysOfNextMonth = 1;
                var year = document.getElementById("year");
                var valYear = year.options[year.selectedIndex].value;
                var month = document.getElementById("month");
                var inputMonth = month.options[month.selectedIndex];
                var valMonth = inputMonth.value;
                var getValMonth = inputMonth.dataset.type;
                var lastDateOfLastMonth = valMonth == 0 ? new Date(valYear - 1, 12, 0).getDate() : new Date(valYear, valMonth, 0).getDate();
                var firstDayOfCurrentMonth = new Date(valYear, valMonth, 0).getDay();
                var dayOfLastMonth = lastDateOfLastMonth - firstDayOfCurrentMonth;
                        {{--var dataCalendar = [--}}
                        {{--@foreach($calendarData as $data)--}}
                        {{--[--}}
                        {{--"{{ $data['work_day'] }}",--}}
                        {{--"{{  $data['start_at'] }}",--}}
                        {{--"{{ $data['end_at'] }}",--}}
                        {{--"{{ $data['type'] }}",--}}
                        {{--"{{ $data['note'] }}",--}}
                        {{--"{{ $data['attendance-time'] }}",--}}
                        {{--],--}}
                        {{--@endforeach--}}
                        {{--];--}}
                for (var i = 0; i < total; i++) {
                    cCell = document.createElement("td");
                    cCell.classList.add("calendar-td-body");
                    var dates = new Date();
                    var getCurrentMonth = dates.getMonth().toString();
                    var getCurrentYear = dates.getFullYear().toString();
                    var selectMonthYear = valYear + "-" + valMonth;
                    var currentMonthYear = getCurrentYear + "-" + getCurrentMonth;
                    if (selectMonthYear === currentMonthYear) {
                        var current_day = dates.getDay();
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
                            var daySquares = "0" + squares[i];
                            var dataDate = valYear + "-" + getValMonth + "-" + daySquares;
                        } else {
                            var dataDate = valYear + "-" + getValMonth + "-" + squares[i];
                        }
                        cCell.innerHTML = "<div class='dayNumber'>" + squares[i] + "</div>";
                        dataCalendar.forEach(function (element) {
                            if (element[0] === dataDate) {
                                cCell.classList.add("calendar-body");
                                cCell.setAttribute("class", "calendar-td-body data-type-" + element[3]);
                                cCell.setAttribute("data-type", +element[3]);
                                cCell.innerHTML += "<div class='attendance-time'>" + element[1] + element[5] + element[2] + "</div>";
                                cCell.innerHTML += "<div class='id-reason-time' style='display: none'>" + element[6] + "</div>";
                                cCell.innerHTML += "<div class='reason-time' style='display: none'>" + element[4] + "</div>";
                            }
                        });
                    }
                    cRow.appendChild(cCell);
                    if (i != 0 && (i + 1) % 7 == 0) {
                        cTable.appendChild(cRow);
                        cRow = document.createElement("tr");
                        cRow.classList.add("calendar-body");
                    }
                }
            },

            show: function (el) {
                var getCurrentTime = new Date();
                var currentMY = getCurrentTime.getFullYear() + "-" + getCurrentTime.getMonth();
                var calendarYM = calendar.sYear + "-" + calendar.sMth;
                if (currentMY === calendarYM) {
                    calendar.sDay = el.getElementsByClassName("dayNumber")[0].innerHTML;
                    var time = calendarYM + "-" + calendar.sDay;
                    dataCalendar.forEach(function (element) {
                        var element = document.getElementsByClassName("calendar-td-body");
                        var idReasonTime = el.getElementsByClassName("id-reason-time")[0];
                        var reasonTime = el.getElementsByClassName("reason-time")[0];
                        console.log(idReasonTime != undefined && reasonTime != undefined)
                        if (idReasonTime != undefined && reasonTime != undefined) {
                            calendar.sDay = el.getElementsByClassName("dayNumber")[0].innerHTML;
                            document.getElementById("div-reason").innerHTML =
                                '<div class="row col-md-12">' +
                                '<input hidden name="id" value="' + idReasonTime.innerHTML + '">' +
                                '<div class="row col-md-12 d-flex justify-content-center">' +
                                '<textarea class="form-control w-90" name="reason" rows="6">' + reasonTime.innerHTML + '</textarea>' +
                                '</div>' +
                                '<div class="row col-md-12">' +
                                '<input hidden name="work_day" value="' + time + '">' +
                                '</div>' +
                                '</div>';

                            var container = document.getElementById("event");
                        } else if (currentMY + "-" + getCurrentTime.getDate() <= time) {
                            document.getElementById("div-reason").innerHTML =
                                '<div class="row col-md-12">' +
                                '<div class="row col-md-12 d-flex justify-content-center">' +
                                '<textarea class="form-control w-90" name="reason" rows="6">' + 'Next day' + '</textarea>' +
                                '</div>' +
                                '<div class="row col-md-12">' +
                                '<input name="work_day" value="' + time + '">"' +
                                '</div>' +
                                '</div>';
                        } else {
                            var  calendarMonth = calendar.sMth + 1;
                            document.getElementById("div-reason").innerHTML =
                                '<div class="row col-md-12">' +
                                '<div class="row col-md-12 d-flex justify-content-center">' +
                                '<input hidden name="work_day" value="' + calendar.sYear + "-" + calendarMonth + "-" + calendar.sDay + '">' +
                                '<textarea class="form-control w-90" name="reason" rows="6"></textarea>' +
                                '</div>' +
                                '</div>';
                        }
                        document.getElementById("div-reason").innerHTML
                    });
                    $('.myModal').modal('show');
                }
            },
        };
        window.addEventListener("load", function () {
            var now = new Date(),
                nowMth = now.getMonth(),
                nowYear = parseInt(now.getFullYear());

            var mth = document.getElementById("month");
            for (var i = 0; i < 12; i++) {
                var opt = document.createElement("option");
                opt.value = calendar.valMonth[i];
                opt.setAttribute("data-type", calendar.getValMonth[i]);
                opt.innerHTML = calendar.mName[i];
                if (i == nowMth) {
                    opt.selected = true;
                }
                month.appendChild(opt);
            }

            var year = document.getElementById("year");
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
    </script>
@endsection