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
    <div id="container"></div>


    <!-- Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ĐƠN KÊU OAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea cols="55" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary complain">Đâm đơn</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Bỏ qua</button>
                </div>
            </div>
        </div>
    </div>
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
                var dataCalendar = [
                        @foreach($calendarData as $data)
                    [
                        "{{ $data['work_day'] }}",
                        "{{ $data['start_at'] }}",
                        "{{ $data['end_at'] }}",
                        "{{ $data['type'] }}",
                        "{{ $data['note'] }}",
                    ],
                    @endforeach
                ];
                for (var i = 0; i < total; i++) {
                    cCell = document.createElement("td");
                    var dates = new Date();
                    var getCurrentMonth = dates.getMonth().toString();
                    if (valMonth === getCurrentMonth) {
                        var current_day = dates.getDay();
                        var cells = document.getElementById('calendar').getElementsByTagName('td');
                        cells[current_day].style.backgroundColor = '#222222';
                        cells[current_day].style.color = '#f4f4f4';
                    }

                    if (squares[i] == "last") {
                        cCell.classList.add("blank");
                        cCell.innerHTML += "<div class='dayNumber'>" + dayOfLastMonth++ + "</div>";
                    } else if (squares[i] == "next") {
                        cCell.classList.add("blank");
                        cCell.innerHTML = "<div class='dayNumber'>" + daysOfNextMonth++ + "</div>";
                    } else {
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
                                cCell.setAttribute("class", "data-type-" + element[3]);
                                cCell.innerHTML += "<div class='evt'>" + element[1] + element[2] + "</div>";
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