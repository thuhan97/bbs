@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('bookings') !!}
@endsection
@section('content')
    <div class="row my-3">
        <div class="col-5 col-sm-3 pr-0 ">
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
            @foreach($meeting_rooms as $room)
                <span data-toggle="tooltip" title="{!! nl2br($room->description) !!}">
                <i class="fa fa-circle ml-0" style="color: {{$room->color}}"></i> {{$room->name}}
                </span>
            @endforeach
        </div>
    </div>

    <div id="calendar-meeting">
    </div>

    <!-- add booking -->
    <form name="addBooking" action="" id="addBooking" method="post">
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center w-100" id="myModalLabel">Đặt lịch họp</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="color" id="color" value="">
                        <input type="hidden" name="days_repeat" id="days_repeat" value="">
                        <div class="row mb-2">
                            <div class="meeting_room_id col-6">
                                <label class="ml-0">Chọn phòng họp *</label>
                                <select class="form-control browser-default" name="meeting_room_id"
                                        id="meeting_room_id">
                                    <option value="">Chọn phòng họp</option>
                                    @foreach($meeting_rooms as $meeting)
                                        <option value="{{$meeting->id}}">{{$meeting->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6 start_time">

                                        <label class="ml-0">Thời gian bắt đầu *</label>
                                        <div class="  timepicker">
                                            <input class="form-control" name="start" id="start_time" data-format="hh:mm"
                                                   data-provide="timepicker">
                                        </div>
                                    </div>
                                    <div class="col-6 mb-1 end_time">
                                        <label class="ml-0">Thời gian kết thúc *</label>
                                        <div class=" bootstrap-timepicker timepicker">
                                            <input class="form-control  timepicker " name="end" id="end_time"
                                                   data-format="hh:mm" data-provide="timepicker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="title">
                            <lable class="ml-0 mt-3">Tiêu đề *</lable>
                            <input type="text" class="form-control mt-2 mb-3" name="title" id="title"
                                   placeholder="Tiêu đề cuộc họp...">
                        </div>
                        <div class="content">
                            <lable class="ml-0">Nội dung *</lable>
                            <textarea class="form-control mt-2" name="content" id="content"
                                      placeholder="Nội dung cuộc họp ..."></textarea>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12 users_id">
                                <label class="ml-0">Chọn người tham gia *</label>
                                <select class=" selectpicker form-control" multiple data-live-search="true"
                                        name="participants" id="participants" data-none-selected-text
                                        title="Chọn đối tượng">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </br>
                        <div id="#repeat" class="mb-2">
                            <lable class="mr-5">Lặp lại:</lable>
                            <input type="radio" name="repeat_type" id="non_repeat" value="0" checked
                                   style="display: none;">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="materialInline1"
                                       name="repeat_type"
                                       value="1">
                                <label class="form-check-label" for="materialInline1">Tuần</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="materialInline2"
                                       name="repeat_type"
                                       value="2">
                                <label class="form-check-label" for="materialInline2">Tháng</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="materialInline3"
                                       name="repeat_type"
                                       value="3">
                                <label class="form-check-label" for="materialInline3">Năm</label>
                            </div>
                        </div>
                        <div class="mt-0">
                            <div class="form-check pl-0">
                                <input type="checkbox" class="form-check-input" id="is_notify" name="is_notify" checked
                                       value="1">

                                <label class="form-check-label" for="is_notify"> Gửi thông báo cho các thành
                                    viên</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">
                            Đóng
                        </button>
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
            $('[data-toggle="tooltip"]').tooltip();
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
        });
    </script>
    <script type="text/javascript" src="{{asset('js/meeting.js')}}"></script>

@endpush
