@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('bookings') !!}
@endsection
@section('content')
    <div class="row my-3">
        <div class="col-5 pr-0 ">
            <form>
                <div class="row">
                    <div class="input-group col-7 float-left">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="year"></span>
                        </div>
                        <select name="month" onChange="" id="month"
                                class=" mr-1 browser-default custom-select form-control float-right">
                        </select>
                    </div>
                    <div class="input-group col-5">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Ngày</span>
                        </div>
                        <select name="date" onChange="" id="date"
                                class=" mr-1 browser-default custom-select form-control float-left">
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6 mt-2">
            <i class="fa fa-circle text-primary ml-3"></i> Phòng họp 01
            <i class="fa fa-circle text-success ml-3"></i> Phòng họp 02
            <i class="fa fa-circle text-warning ml-3"></i> Phòng họp 03
        </div>
    </div>

    <div id="calendar-meeting">
    </div>

    <!-- add booking -->
    <form name="addBooking" action="" id="addBooking" method="post">
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">

                    <div class="modal-body">
                        <h4 class="text-center font-weight-bold ">Đặt lịch họp</h4>
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="color" id="color" value="">
                        <input type="hidden" name="days_repeat" id="days_repeat" value="">
                        <div class="title">
                            <lable class="m-3">Tiêu đề *</lable>
                            <input type="text" class="form-control mt-2 mb-3" name="title" id="title"
                                   placeholder="Tiêu đề cuộc họp...">
                        </div>
                        <div class="content">
                            <lable class="ml-3 mt-1">Nội dung *</lable>
                            <textarea class="form-control mt-2" name="content" id="content"
                                      placeholder="Nội dung cuộc họp ..."></textarea>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6 users_id">
                                <label class="ml-3">Chọn đối tượng *</label>
                                <select class=" selectpicker form-control" multiple data-live-search="true"
                                        name="participants" id="participants" data-none-selected-text
                                        title="Chọn đối tượng">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 meeting_room_id">
                                <label class="ml-3">Chọn phòng họp *</label>
                                <select class="form-control browser-default" name="meeting_room_id" id="meeting_room_id">
                                    <option value="">Chọn phòng họp</option>
                                    @foreach($meeting_rooms as $meeting)
                                        <option value="{{$meeting->id}}">{{$meeting->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6 start_time">

                                <label class="ml-3">Thời gian bắt đầu *</label>
                                <div class="  timepicker">
                                    <input class="form-control" name="start" id="start_time" data-format="hh:mm"
                                           data-provide="timepicker">
                                </div>
                            </div>
                            <div class="col-6 mb-1 end_time">
                                <label class="ml-3">Thời gian kết thúc *</label>
                                <div class=" bootstrap-timepicker timepicker">
                                    <input class="form-control  timepicker " name="end" id="end_time"
                                           data-format="hh:mm" data-provide="timepicker">
                                </div>
                            </div>
                        </div>
                        <div id="#repeat">
                            <lable class="mr-5">Chọn định kỳ:</lable>
                            <input type="radio" name="repeat_type" id="non_repeat" value="0" checked
                                   style="display: none;">
                            <label class="radio-inline">
                                <input type="radio" name="repeat_type" id="year" value="3"><span>Năm</span>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="repeat_type" id="month" value="2"><span>Tháng</span>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="repeat_type" id="week" value="1"><span>Tuần</span>
                            </label>
                        </div>
                        </br>
                        <div class="mt-0">
                            <input type="checkbox" name="is_notify" class="" value="1" checked="true"
                                   id="is_notify"><span> Chọn thông báo cho các thành viên</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="booking">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- show modal -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">

            <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">

                <div class="modal-body">
                    <h4 class="text-center font-weight-normal ">Lịch họp</h4>
                    <input type="hidden" name="id" id="id_booking" value="">
                    <input type="hidden" name="start_date" id="start_date" value="">
                    <h6 class="font-weight-normal ">Tiêu đề:</h6>
                    <p id="show-title"></p>

                    <h6 class="font-weight-normal">Nội dung:</h6>
                    <p id="show-content"></p>
                    <h6 class="font-weight-normal">Đối tượng:</h6>
                    <p id="show-object"></p>
                    <h6 class="font-weight-normal">Phòng họp:</h6>
                    <p id="show-meeting"></p>
                    <h6 class="font-weight-normal">Thời gian:</h6>
                    <p id="time"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="edit">Sửa lịch</button>
                    <button class="btn btn-danger" id="deleteMessage">Hủy lịch</button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">

            <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">

                <div class="modal-body">
                    <h6>Bạn có chắc chắn muốn xóa buổi họp này không?</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-white" id="cancel">Hủy</button>
                    <button class="btn btn-danger" id="delete">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- success modal -->
    <div class="modal fade" id="deleteSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">

            <div class="modal-content" style="width: 450px;padding: 5px;margin-top: 100px;font-size: 13px;">

                <div class="modal-body">
                    <h6 id="message" class="text-center"></h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="ok">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('extend-css')
    <link href="{{asset('bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet"/>
    <link href="{{asset('bootstrap-datetimepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet"/>
    <link href="{{ asset('fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/meeting.css')}}">
@endpush
@push('extend-js')
    <script type="text/javascript" src="{{asset('mdb/js/bootstrap.js')}}"></script>
    <script src="{{asset('bootstrap-select/js/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{asset('bootstrap-datetimepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="">
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });
        $('#start_time').timepicker({
            // 12 or 24 hour
            showInputs: false,
            showMeridian: false
        });
        $('#end_time').timepicker({
            // 12 or 24 hour
            showInputs: false,
            showMeridian: false
        });

    </script>
    <script type="text/javascript" src="{{asset('js/meeting.js')}}"></script>

@endpush
