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
    @if(session()->has('permission_error'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Đơn đã được phê duyệt!",
                icon: "error",
                button: "Đóng",
            });
        </script>
    @endif
    @if(session()->has('wt_permission_success'))
        @if(session()->get('wt_permission_success') != '')
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
        <div class="row m-t-20 mt-1">
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

    @if ($errors->has('status'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('status') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('type'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('type') }}</strong>
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
        <br>
    @endif
    @if ($errors->has('project_id'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('project_id') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('explanation_type'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('explanation_type') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('reason'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('reason') }}</strong>
        </span>
        <br>
    @endif
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
    @if ($errors->has('wt_ask_permission'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('wt_ask_permission') }}</strong>
        </span>
        <br>
    @endif
    <div class="modal fade myModal" id="modal-form" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class='mg-center mg-left-10 modal-title w-100 font-weight-bold pt-2 title-wt-modal-approve'>Xin
                        phép</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                @include('elements.ask_permission_image')
                <form action="{{ route('work_time.ask_permission') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div id="event"></div>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send btn-send-permission">GỬI ĐƠN</button>
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
                    }

                    function makeModal() {
                        calendar.sDay = el.getElementsByClassName("dayNumber")[0].innerHTML;
                        if (el.getElementsByClassName("data-id")[0]) {
                            document.getElementById("div-reason").innerHTML =
                                '<div class="row col-md-12 append-reason">' +
                                '<div class="col-md-12 d-flex justify-content-center">' +
                                '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                '    <label for="ot-project" class="wt-input-late">OT dự án </label>' +
                                '    <input type="radio" id="ot-project" class="user-radio2 radio-modal-work-time wt-input-late" name="ot_type"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '</div>' +
                                '<div class="user col-md-4 pl-0 pr-0 text-center">' +
                                '    <label for="ot-other">OT cá nhân </label>' +
                                '    <input id="ot-other" type="radio" class="user-radio3 radio-modal-work-time"  name="ot_type"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '</div>' +
                                '</div>' +
                                '        <div class="col-md-6">\n' +
                                '            <div class="form-group ">\n' +
                                '                <label for="start_at">Thời gian kết thúc *</label>\n' +
                                '                <div class="input-group date">\n' +
                                '                    <input type="time" class="form-control pull-right" autocomplete="off"\n' +
                                '                           name="start_at"\n' +
                                '                           value=""\n' +
                                '                           id="start_at">\n' +
                                '                </div>\n' +
                                '            </div>\n' +
                                '        </div>\n' +
                                '        <div class="col-md-6">\n' +
                                '            <div class="form-group ">\n' +
                                '                <label for="end_at">Thời gian bắt đầu *</label>\n' +
                                '                <div class="input-group date">\n' +
                                '                    <input type="time" class="form-control pull-right"\n' +
                                '                           name="end_at" autocomplete="off"\n' +
                                '                           value=""\n' +
                                '                           id="end_at">\n' +
                                '                </div>\n' +
                                '            </div>\n' +
                                '        </div>\n' +
                                '<input type="hidden" name="work_day" class="work_day" value="' + dataWorkDay + '">' +
                                '<input hidden name="explanation_type" value="4">' +
                                '<input hidden name="status" value="" class="wt-status">' +
                                '<textarea class="form-control wt-textarea-reason" name="reason" rows="6" placeholder="Nội dung bạn muốn gửi..."></textarea>' +
                                '</div>';
                        } else {
                        }
                        document.getElementById("div-reason").innerHTML =
                            '<div class="row col-md-12 append-reason">' +
                            '<div class="col-md-12 d-flex justify-content-center row">' +
                            '<div class="row col-12">' +
                            '<div class="user col-md-6 pl-0 pr-0 text-center my-2 mt-3">' +
                            '    <input type="radio" id="ot-project" class="user-radio2 radio-modal-work-time" name="ot_type"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                            '    <label for="ot-project">OT Dự án </label>' +
                            '</div>' +
                            '<div class="user col-md-6 pl-0 pr-0 text-center my-2 mt-3">' +
                            '    <input id="ot-other" type="radio" class="user-radio3 radio-modal-work-time"  name="ot_type" style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                            '    <label for="ot-other">OT Cá nhân </label>' +
                            '</div>' +
                            '</div>' +
                            '   <select class="browser-default form-control project_id ml-4 mb-2" name="project_id">' +
                            '       <option value="0">Chọn dự án</option>' +
                            '   </select>' +
                            '</div>' +
                            '        <div class="col-md-6 my-2 pl-4">\n' +
                            '            <div class="form-group ">\n' +
                            '                <label for="start_at">Thời gian bắt đầu *</label>\n' +
                            '                <div class="<!--input-group date-->">\n' +
                            '                    <input type="time" class="form-control pull-right w-95" autocomplete="off"\n' +
                            '                           name="start_at"\n' +
                            '                           value=""\n' +
                            '                           id="start_at">\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '        <div class="col-md-6 my-2">\n' +
                            '            <div class="form-group ">\n' +
                            '                <label for="end_at">Thời gian kết thúc *</label>\n' +
                            '                <div class="<!--input-group date-->">\n' +
                            '                    <input type="time" class="form-control pull-right w-95"\n' +
                            '                           name="end_at" autocomplete="off"\n' +
                            '                           value=""\n' +
                            '                           id="end_at">\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '<input type="hidden" name="work_day" class="work_day" value="' + getDataTime + '">' +
                            '<input type="hidden" name="checkOtType" class="checkOtType" value="">' +
                            '<textarea class="form-control wt-textarea-reason wt-textarea-check-ot" name="reason" rows="6" placeholder="Nội dung bạn muốn gửi..."></textarea>' +
                            '</div>';
                    }

                    if (parseInt(calendarYM) >= parseInt(currentMY)) {
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
                                '<input hidden name="wt_ask_permission" class="wt_ask_permission" value="">' +
                                '<input hidden name="wt_ask_permission_ot" class="wt_ask_permission_ot" value="">' +
                                '<input hidden name="wt_ask_permission_ot_project" class="wt_ask_permission_ot_project" value="">' +
                                '<input type="hidden" class="work_day" name="work_day" value="' + getDataTime + '">' +
                                '<div class="user col-md-4 pl-0 pr-0 my-2 text-center mt-3">' +
                                '    <input type="radio" id="late" class="user-radio2 radio-modal-work-time" name="explanation_type" value="1"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '    <label for="late">Xin đi muộn </label>' +
                                '</div>' +
                                '<div class="user col-md-4 pl-0 pr-0 my-2 text-center mt-3">' +
                                '    <input  id="early" type="radio" class="user-radio3 radio-modal-work-time"  name="explanation_type" value="2"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '    <label for="early">Xin về sớm </label>' +
                                '</div>' +
                                '   <div class="user col-md-4 pl-2 pr-0 my-2 text-center mt-3">' +
                                '       <input type="radio" id="ot" class="user-radio1 radio-modal-work-time" name="explanation_type" value="4"  style="position: relative;opacity: 1;pointer-events: inherit"/>' +
                                '       <label for="ot">Xin OT</label>' +
                                '   </div>' +
                                '<div class="user col-md-6 my-2">' +
                                '   <select class="browser-default form-control float-left ot_type" name="ot_type">' +
                                '       <option value="">Loại OT</option>' +
                                '       <option value="1">OT dự án</option>' +
                                '       <option value="2">OT cá nhân</option>' +
                                '   </select>' +
                                '</div>' +
                                '<div class="user col-md-6 my-2">' +
                                '   <select class="browser-default form-control float-left project_id" name="project_id">' +
                                '       <option value="0">Chọn dự án</option>' +
                                '   </select>' +
                                '</div>' +
                                '        <div class="col-md-6 my-2">\n' +
                                '            <div class="form-group ">\n' +
                                '                <label for="start_at">Thời gian bắt đầu *</label>\n' +
                                '                <div class="input-group date">\n' +
                                '                    <input type="time" class="form-control pull-right" autocomplete="off"\n' +
                                '                           name="start_at"\n' +
                                '                           value=""\n' +
                                '                           id="start_at">\n' +
                                '                </div>\n' +
                                '            </div>\n' +
                                '        </div>\n' +
                                '        <div class="col-md-6 my-2">\n' +
                                '            <div class="form-group ">\n' +
                                '                <label for="end_at">Thời gian kết thúc *</label>\n' +
                                '                <div class="input-group date">\n' +
                                '                    <input type="time" class="form-control pull-right"\n' +
                                '                           name="end_at" autocomplete="off"\n' +
                                '                           value=""\n' +
                                '                           id="end_at">\n' +
                                '                </div>\n' +
                                '            </div>\n' +
                                '        </div>\n' +
                                '<textarea class="form-control my-2 wt-textarea-reason wt-textarea-current-day" name="reason" rows="6" placeholder="Nội dung bạn muốn gửi..."></textarea>' +
                                '</div>';

                            $('.user-radio3').change(function () {
                                $('.user .demo').remove();
                            });
                            $('.user-radio2').change(function () {
                                $('.user .demo').remove();
                            });

                            $('.user-radio1').change(function () {
                                $('.wt_ask_permission').attr('value', 'true');
                                $('.wt_ask_permission_ot').attr('value', 'true');
                                $.ajax({
                                    url: '{{ route('work_time.get_project') }}',
                                    type: 'GET',
                                    dataType: 'JSON',
                                    data: {
                                        // 'work_day': lateWorkDay,
                                        // 'explanationType': explanationType,
                                    },
                                    success: function (responds) {
                                        responds.forEach(function (element) {
                                            $('.project_id').append('<option value="' + element.id + '">' + element.name + '</option>');
                                        });
                                    }
                                });
                                $('.user .demo').remove();

                                if ($('.ot:checked')) {
                                    $('.ot_type, .project_id,#start_at,#end_at').prop('disabled', false);
                                } else {
                                    $('.ot_type, .project_id,#start_at,#end_at').prop('disabled', true);
                                }
                                $(".ot_type").on('change', function () {
                                    var explanationOtType = $(this).val(),
                                        work_day = $('.work_day').val();
                                    if (explanationOtType === '1') {
                                        $('.wt_ask_permission_ot_project').attr('value', 'true');
                                    } else {
                                        $('.wt_ask_permission_ot_project').attr('value', 'false');
                                    }

                                    $.ajax({
                                        url: '{{ route('work_time.detail_ask_permission') }}',
                                        type: 'GET',
                                        dataType: 'JSON',
                                        data: {
                                            'work_day': work_day,
                                            'explanationOtType': explanationOtType,
                                        },
                                        success: function (respond) {
                                            if (respond.reason) {
                                                var note = respond.reason
                                            } else {
                                                note = ''
                                            }
                                            $('#start_at').val(respond.start_at);
                                            $('#end_at').val(respond.end_at);
                                            $(".project_id option").each(function (data) {
                                                if (respond.project_id === $(this).val()) {
                                                    $(this).attr('selected', true)
                                                } else {
                                                    $(this).attr('selected', false)
                                                }
                                            });
                                            $('.project_id').val(respond.project_id);
                                            if (explanationOtType === '2') {
                                                $('.project_id').prop('disabled', true);
                                            } else {
                                                $('.project_id').prop('disabled', false);
                                            }
                                            if (respond.status === 1) {
                                                $('.title-wt-modal-approve').text('Đơn đã được duyệt');
                                                $('.wt-textarea-reason,.btn-send-permission,.project_id,.ot_type,#start_at,#end_at').prop('disabled', true);
                                            } else if (respond.status === 0 || respond.status === 2) {
                                                $('.title-wt-modal-approve').text('Xin phép');
                                                $('.wt-textarea-reason,.btn-send-permission,.project_id,.ot_type,#start_at,#end_at').prop('disabled', false);
                                            }

                                            $('.wt-textarea-reason').text(note)
                                        }
                                    });
                                })
                            });

                            $('.ot_type, .project_id,#start_at,#end_at').prop('disabled', true);
                        } else {
                            makeModal()
                        }
                    }
                    $('.project_id,#start_at,#end_at').prop('disabled', true);
                    $('#ot-project,#ot-other').on('click', function () {
                        var otThis = $(this);
                        if (otThis.attr('id') === 'ot-other') {
                            otThis.attr('value', 1);
                            $('.checkOtType').attr('value', 1)
                            $('.project_id option[value!="0"]').remove();
                            $('.project_id').prop('disabled', true)
                            $('#start_at,#end_at').prop('disabled', false)
                        } else if (otThis.attr('id') === 'ot-project') {
                            otThis.attr('value', 2);
                            $('.checkOtType').attr('value', 2)
                            $('.project_id,#start_at,#end_at').prop('disabled', false)
                        }
                        // $('.project_id,#start_at,#end_at').prop('disabled', false);
                        var lateWorkDay = $('.work_day').val(),
                            explanationOtType = $(this).val();
                        $.ajax({
                            url: '{{ route('work_time.detail_ask_permission') }}',
                            type: 'GET',
                            dataType: 'JSON',
                            data: {
                                'work_day': lateWorkDay,
                                'explanationOtType': explanationOtType,
                            },
                            success: function (respond) {
                                if (respond.project) {
                                    var projectName = respond.project
                                } else {
                                    var projectName = respond;
                                }
                                $('.project_id option[value!=0]').remove();

                                projectName.forEach(function (element) {
                                    if (otThis.attr('id') === 'ot-project') {
                                        $('.project_id').append('<option value="' + element.id + '">' + element.name + '</option>');
                                    }
                                });

                                if (respond.status === 1) {
                                    $('.title-wt-modal-approve').text('Đơn đã được duyệt');
                                    $('.wt-textarea-reason,.btn-send-permission,#start_at,#end_at').prop('disabled', true);
                                } else {
                                    $('.title-wt-modal-approve').text('Xin phép');
                                    $('.wt-textarea-reason,.btn-send-permission').prop('disabled', false);
                                }
                                
                                $('#start_at').val(respond.start_at);
                                $('#end_at').val(respond.end_at);
                                if (respond.status === undefined) {
                                    var reason = '';
                                } else {
                                    var reason = respond.reason;
                                }
                                $('.wt-status').attr('value', respond.status);
                                $('.wt-textarea-reason').text(reason);
                            }
                        });
                    });

                    $('#late,#early').on('click', function () {
                        $('.wt_ask_permission').attr('value', 'true');
                        var lateWorkDay = $('.work_day').val(),
                            explanationType = $(this).val();
                        $.ajax({
                            url: '{{ route('work_time.detail_ask_permission') }}',
                            type: 'GET',
                            dataType: 'JSON',
                            data: {
                                'work_day': lateWorkDay,
                                'explanationType': explanationType,
                            },
                            success: function (respond) {
                                if (respond.status != 1) {
                                    $('.title-wt-modal-approve').text('Xin phép');
                                    $('.wt-textarea-reason,.btn-send-permission').prop('disabled', false)
                                    $('#start_at,#end_at').val('')
                                }
                                if (respond.note) {
                                    var note = respond.note
                                } else {
                                    note = ''
                                }
                                $('.wt-textarea-reason').text(note)
                            }
                        });

                        $('.ot_type, .project_id,#start_at,#end_at').prop('disabled', true);
                        $('.project_id option[value!="0"]').remove();
                        $('.wt-late-reason').remove()
                    });

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
                    opt.setAttribute("data-month", calendar.getValMonth[i]);
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
                    getValMonth = inputMonth.dataset.month,
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
                        cCell.addEventListener("click", function () {
                            $('.title-wt-modal-approve').text('Xin phép');
                            $('.btn-send-permission').prop('disabled', false);
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
                                    $(this).append('<p class="data-status" hidden>' + data.status + '</p>');
                                }
                            });
                        });
                        let type_1 = $('#calendar .data-type-1').length,
                            type_2 = $('#calendar .data-type-2').length,
                            type_4 = $('#calendar .data-type-4').length,
                            type_5 = $('#calendar .data-type-5').length,
                            earlyOt = type_1 + type_5;
                            Ot = type_4 + type_5;
                        console.log(earlyOt);
                        $("#btn-early-late").text('Số buổi đi muộn: ' + earlyOt);
                        $("#btn-ot").text('Số buổi OT: ' + Ot);
                        $("#btn-late-ot").text('Số buổi về sớm: ' + type_2);
                    },
                    error: (data) => {
                        console.log(data.status);
                    },
                });
            };
        })
    </script>
@endpush
@push('extend-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush

@push('extend-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
@endpush
