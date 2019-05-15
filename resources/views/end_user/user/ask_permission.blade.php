@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('ask_permission') !!}
@endsection
@section('content')
    @if(session()->has('create_permission_success'))
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
    @if(session()->has('approver_success') || session()->has('reject_success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã duyệt đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif
    @if ($errors->has('work_day'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('work_day') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('type'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('type') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('permission_type'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('permission_type') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('status'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('status') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('creator_id'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('creator_id') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('reason_reject'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('reason_reject') }}</strong>
        </span>
        <br>
    @endif
    @if ($errors->has('work_time_explanation_id'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('work_time_explanation_id') }}</strong>
        </span>
        <br>
    @endif
    <div class="row mb-4">
        <div class="col-md-4">
            <h2>Xin phép cá nhân</h2>
        </div>
        <div class="col-md-8 text-right">
            <button onclick="location.href='{{route("day_off")}}?t=1'"
                    class="btn btn-success no-box-shadow waves-effect waves-light float-right" id="btn-off">
                Xin nghỉ phép
            </button>
            <button type="button"
                    class="d-none d-xl-block btn btn-primary no-box-shadow approve-btn-ot waves-effect waves-light float-right"
                    id="btn-late-ot">
                Xin OT
            </button>
            <button type="button" class="approve-btn-early btn btn-warning no-box-shadow waves-light float-right"
                    id="btn-late">
                Xin về sớm
            </button>
            <button type="button" class="approve-btn-late btn btn-danger no-box-shadow waves-light float-right"
                    id="btn-late">
                Xin đi muộn
            </button>
        </div>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel555" role="tab">Xin phép</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel666" role="tab">Xin OT</a>
        </li>
    </ul>
    <!-- Nav tabs -->

    <!-- Tab panels -->
    <div class="tab-content">
        <!-- Panel 1 -->
        <div class="tab-pane fade in show active" id="panel555" role="tabpanel">
            <table id="contactTbl" class="table table-striped table-bordered">
                <colgroup>
                    <col style="">
                    <col style="">
                    <col style="">
                    <col style="">
                </colgroup>
                <thead class="grey lighten-2">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Ngày</th>
                    <th>Hình thức</th>
                    <th>Nội dung</th>
                    <th>Nội dung từ chối</th>
                    <th class="text-center">Trạng Thái</th>
                </tr>
                </thead>
                <tbody>

                @foreach($askPermission as $increment => $item)
                    <tr>
                        <th class="text-center">{{ $increment+1 }}</th>
                        <th class="text-center">{{ $item['work_day'] ?? '' }}</th>
                        <td>
                            {{--{{$item->type_name}}aaa--}}
                            @if($item['type'] == 0)
                                Bình thường
                            @elseif($item['type'] == 1)
                                Đi muộn
                            @elseif($item['type'] == 2)
                                Về sớm
                            @elseif($item['type'] == 4)
                                @if($item['ot_type'] == 1)
                                    OT dự án
                                @elseif($item['ot_type'] == 2)
                                    OT cá nhân
                                @endif
                            @endif
                        </td>
                        <td>{!! $item['note'] ?? '' !!}</td>
                        <td>{!! $item['reason_reject'] ?? '' !!}</td>
                        <td class="text-center td-approve">
                            @if($item['work_times_explanation_status'] == array_search('Đã duyệt', OT_STATUS))
                                <i class="fas fa-grin-stars fa-2x text-success"
                                   title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                            @elseif($item['work_times_explanation_status'] == array_search('Chưa duyệt', OT_STATUS))
                                <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                            @elseif($item['work_times_explanation_status'] == array_search('Từ chối', OT_STATUS))
                                <i class="fas fa-frown fa-2x text-danger"
                                   title="{{ $item->workTimeApprover->name ?? ''  }}"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- Panel 1 -->

        <!-- Panel 2 -->
        <div class="tab-pane fade" id="panel666" role="tabpanel">

            <table id="contactTbl" class="table table-striped table-bordered">
                <colgroup>
                    <col style="">
                    <col style="">
                    <col style="">
                    <col style="">
                </colgroup>
                <thead class="grey lighten-2">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Ngày</th>
                    <th>Hình thức</th>
                    <th>Nội dung</th>
                    <th>Nội dung từ chối</th>
                    <th class="text-center">Trạng Thái</th>
                </tr>
                </thead>
                <tbody>

                @foreach($otTimes as $increment => $item)
                    <tr>
                        <th class="text-center">{{ $increment+1 }}</th>
                        <th class="text-center">{{ $item['work_day'] ?? '' }}</th>
                        <td>
                            {{--{{$item->type_name}}aaa--}}
                            @if($item['type'] == 0)
                                Bình thường
                            @elseif($item['type'] == 1)
                                Đi muộn
                            @elseif($item['type'] == 2)
                                Về sớm
                            @elseif($item['type'] == 4)
                                @if($item['ot_type'] == 1)
                                    OT dự án
                                @elseif($item['ot_type'] == 2)
                                    OT cá nhân
                                @endif
                            @endif
                        </td>
                        <td>{!! $item['note'] ?? '' !!}</td>
                        <td>{!! $item['reason_reject'] ?? '' !!}</td>
                        <td class="text-center td-approve">
                            @if($item['work_times_explanation_status'] == array_search('Đã duyệt', OT_STATUS))
                                <i class="fas fa-grin-stars fa-2x text-success"
                                   title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                            @elseif($item['work_times_explanation_status'] == array_search('Chưa duyệt', OT_STATUS))
                                <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                            @elseif($item['work_times_explanation_status'] == array_search('Từ chối', OT_STATUS))
                                <i class="fas fa-frown fa-2x text-danger"
                                   title="{{ $item->workTimeApprover->name ?? ''  }}"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <!-- Panel 2 -->

    </div>
    <!-- Tab panels -->

    @can('team-leader')
        @if($dataLeader->isNotEmpty())
            <h1>Danh sách xin phép</h1>
            <table id="contactTbl" class="table table-striped table-bordered">
                <colgroup>
                    <col style="">
                    <col style="">
                    <col style="">
                    <col style="">
                </colgroup>
                <thead class="grey lighten-2">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Ngày</th>
                    <th>Tên nhân viên</th>
                    <th>Hình thức</th>
                    <th>Nội dung</th>
                    <th>Nội dung từ chối</th>
                    <th class="text-center" style="width: 10%;">Trạng Thái</th>
                </tr>
                </thead>
                <?php $increment = 1; ?>
                <tbody>
                @foreach($dataLeader as $item)
                    <tr>
                        <th class="text-center">{{ $increment++ }}</th>
                        <th class="text-center">{{ $item['work_day'] ?? '' }}</th>
                        <th>{{ $item->user->name ?? '' }}</th>
                        <td>
                            {{$item->type_name}}
                        </td>
                        <td>{!! $item['note'] ?? '' !!}</td>
                        <td>{!! $item['reason_reject'] ?? '' !!}</td>
                        <td class="text-center td-approve">
                            @can('manager')
                                @if($item['work_times_explanation_status'] == array_search('Chưa duyệt', OT_STATUS))
                                    <form action="{{ $item['type'] == array_search('Overtime',WORK_TIME_TYPE) ? route('approvedOT') : route('approved') }}"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="id"
                                               value="{{ $item['id'] ? $item['id'] : '' }}">
                                        <input type="hidden" name="user_id"
                                               value="{{ $item['user_id'] ? $item['user_id'] : '' }}">
                                        <input type="hidden" name="reason"
                                               value="{{ $item['note'] ? $item['note'] : '' }}">
                                        <input type="hidden" name="work_day"
                                               value="{{ $item['work_day'] ? $item['work_day'] : '' }}">
                                        <input type="hidden" name="type"
                                               value="{{ $item['type'] ? $item['type'] : '' }}">
                                        <button class="btn-approve float-left"><i class="fas fa-check-circle"></i>
                                        </button>
                                    </form>
                                    <button class="btn-reject float-right"
                                            data-id="{{ $item['id'] ? $item['id'] : '' }}"><i class="fas fa-times"></i>
                                    </button>
                                @elseif($item['work_times_explanation_status'] == array_search('Đã duyệt', OT_STATUS))
                                    <i class="fas fa-grin-stars fa-2x text-success"
                                       title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                @elseif($item['work_times_explanation_status'] == array_search('Từ chối', OT_STATUS))
                                    <i class="fas fa-meh-blank fa-2x text-danger"
                                       title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$dataLeader->render('end_user.paginate') }}
            <br><br><br>
        @endif
    @endcan

    {{--@can('team-leader')--}}
        {{--@if($dataLeader->isNotEmpty())--}}
            {{--<h1>Danh sách xin phép</h1>--}}
            {{--<table id="contactTbl" class="table table-striped table-bordered">--}}
                {{--<colgroup>--}}
                    {{--<col style="">--}}
                    {{--<col style="">--}}
                    {{--<col style="">--}}
                    {{--<col style="">--}}
                {{--</colgroup>--}}
                {{--<thead class="grey lighten-2">--}}
                {{--<tr>--}}
                    {{--<th class="text-center">#</th>--}}
                    {{--<th class="text-center">Ngày</th>--}}
                    {{--<th>Tên nhân viên</th>--}}
                    {{--<th>Hình thức</th>--}}
                    {{--<th>Nội dung</th>--}}
                    {{--<th>Nội dung từ chối</th>--}}
                    {{--<th class="text-center" style="width: 10%;">Trạng Thái</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<?php $increment = 1; ?>--}}
                {{--<tbody>--}}
                {{--@foreach($dataLeader as $item)--}}
                    {{--<tr>--}}
                        {{--<th class="text-center" style="padding: 15px;">{{ $increment++ }}</th>--}}
                        {{--<th class="text-center">{{ $item['work_day'] ?? '' }}</th>--}}
                        {{--<th>{{ $item->user->name ?? '' }}</th>--}}
                        {{--<td>--}}
                            {{--{{$item->type_name}}--}}
                        {{--</td>--}}
                        {{--<td>{!! $item['note'] ?? '' !!}</td>--}}
                        {{--<td>{!! $item['reason_reject'] ?? '' !!}</td>--}}
                        {{--<td class="text-center td-approve">--}}
                            {{--@can('manager')--}}
                                {{--@if($item['work_times_explanation_status'] == array_search('Chưa duyệt', OT_STATUS))--}}
                                    {{--<form action="{{ $item['type'] == array_search('Overtime',WORK_TIME_TYPE) ? route('approvedOT') : route('approved') }}"--}}
                                          {{--method="post">--}}
                                        {{--@csrf--}}
                                        {{--<input type="hidden" name="id"--}}
                                               {{--value="{{ $item['id'] ? $item['id'] : '' }}">--}}
                                        {{--<input type="hidden" name="user_id"--}}
                                               {{--value="{{ $item['user_id'] ? $item['user_id'] : '' }}">--}}
                                        {{--<input type="hidden" name="reason"--}}
                                               {{--value="{{ $item['note'] ? $item['note'] : '' }}">--}}
                                        {{--<input type="hidden" name="work_day"--}}
                                               {{--value="{{ $item['work_day'] ? $item['work_day'] : '' }}">--}}
                                        {{--<input type="hidden" name="type"--}}
                                               {{--value="{{ $item['type'] ? $item['type'] : '' }}">--}}
                                        {{--<button class="btn-approve float-left"><i class="fas fa-check-circle"></i>--}}
                                        {{--</button>--}}
                                    {{--</form>--}}
                                    {{--<button class="btn-reject float-right"--}}
                                            {{--data-id="{{ $item['id'] ? $item['id'] : '' }}"><i class="fas fa-times"></i>--}}
                                    {{--</button>--}}
                                {{--@elseif($item['work_times_explanation_status'] == array_search('Đã duyệt', OT_STATUS))--}}
                                    {{--<i class="fas fa-grin-stars fa-2x text-success"--}}
                                       {{--title="{{ $item->workTimeApprover->name ?? '' }}"></i>--}}
                                {{--@elseif($item['work_times_explanation_status'] == array_search('Từ chối', OT_STATUS))--}}
                                    {{--<i class="fas fa-frown fa-2x text-danger"--}}
                                       {{--title="{{ $item->workTimeApprover->name ?? '' }}"></i>--}}
                                {{--@endif--}}
                            {{--@endcan--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
            {{--{{$dataLeader->render('end_user.paginate') }}--}}
            {{--<br><br><br>--}}
        {{--@endif--}}
    {{--@endcan--}}


    {{--{{ $datas->render('end_user.paginate') }}--}}
    <div class="modal fade reject" id="modal-reject" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class='mg-center mb-2 modal-title w-100 font-weight-bold pt-2 mg-left-10'>Lý do</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('img/font/gio_lam_viec_popup.png') }}" alt="" width="355px" height="260px">
                </div>
                <br>
                <form action="{{ route('reject') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <textarea class="form-control permission-reason" name="reason_reject" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade myModal" id="modal-form" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('img/font/gio_lam_viec_popup.png') }}" alt="" width="355px" height="260px">
                </div>
                <br>
                <form action="{{ route('ask_permission.create') }}" method="get">
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="offset-1 select-day">
                        <div class="row col-12 option-permission"></div>
                        <input name='permission_late' type='hidden'>
                        <input name='permission_type' type='hidden' value="1">
                        <label class=" text-w-400" for="inputCity">Chọn ngày *</label>
                        <input style="width: 43%;" type="text"
                               class="form-control select-item {{ $errors->has('work_day') ? ' has-error' : '' }}"
                               id="work-day-late" autocomplete="off" name="work_day" value="{{  old('work_day') }}"
                               readonly="readonly">
                    </div>
                    <br>
                    <textarea class="form-control permission-reason-late" name="note" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send btn-permission-late">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-early" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
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
                <form action="{{ route('ask_permission.create') }}" method="get">
                    {{--@csrf--}}
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="offset-1 select-day">
                        <div class="row col-12 option-permission"></div>
                        <input name='permission_early' type='hidden'>
                        <input name='permission_type' type='hidden' value="2">
                        <label class=" text-w-400" for="inputCity">Chọn ngày *</label>
                        <input style="width: 43%;" type="text"
                               class="form-control select-item {{ $errors->has('work_day') ? ' has-error' : '' }}"
                               id="work-day-early" autocomplete="off" name="work_day" value="{{  old('work_day') }}"
                               readonly="readonly">
                    </div>
                    <br>
                    <textarea class="form-control permission-reason-early" name="note" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send btn-permission-early">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade myModal" id="modal-form-ot" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
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
                <form action="{{ route('ask_permission.create') }}" method="get">
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="row col-md-12">
                        <div class="col-2"></div>
                        <div class="col-md-4 text-center">
                            <input style="position: relative;opacity: 1;pointer-events: inherit" class="other-ot"
                                   type="radio" name="ot_type" id="project-ot" checked value="1">
                            <label for="project-ot">OT dự án</label>
                        </div>
                        <div class="col-md-4 text-center">
                            <input style="position: relative;opacity: 1;pointer-events: inherit" class="other-ot"
                                   type="radio" name="ot_type" id="other-ot" value="2">
                            <label for="other-ot">Lý do cá nhân</label>
                        </div>
                    </div>
                    <div class="select-day">
                        <div class="container-fluid">
                            <div class="row append-textarea">
                                <div class="col-2"></div>
                                <div class="col-4">
                                    <label for="inputCity">Chọn ngày *</label>
                                </div>
                                <div class="col-4">
                                    <input type="hidden" name="permission_ot">
                                    <input type="hidden" value="4" name="permission_type">
                                    <input type="text"
                                           class="form-control select-item {{ $errors->has('work_day') ? ' has-error' : '' }}"
                                           id="work_day_ot" autocomplete="off" name="work_day"
                                           value="{{ old('work_day', date('Y-m-d')) }}"
                                           readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <textarea class="form-control permission-reason-ot" name="note" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send btn-permission-ot">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('extend-css')
        <link href="{{ cdn_asset('/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ cdn_asset('/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    @endpush
    <script src="{{ cdn_asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ cdn_asset('/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            var date = new Date(),
                currentDate = date.getDate() + 1,
                currentMonth = date.getMonth() + 1,
                currentYear = date.getFullYear(),
                currenFullTime = currentYear + '-' + currentMonth + '-' + currentDate;
            $('#work-day-late,#work-day-early,#work_day_ot').datepicker({format: 'yyyy-mm-dd'});
            $('.approve-btn-late').on('click', function () {
                $(".permission-reason").empty();
                $('#modal-form').modal('show');
                $(".permission-reason-late").append("<input name='type' type='text' value='1'>");
                $(".modal-header").html("<h4 class='mg-center mb-2 modal-title w-100 font-weight-bold pt-2 header-permission-late'>Xin đi muộn</h4>");
                // $('#work_day').datepicker("setDate", currenFullTime);
                $('#work-day-late').datepicker("setDate", date);
            });

            $('.approve-btn-early').on('click', function () {
                $('#modal-early').modal('show');
                $(".permission-reason-late").empty();
                $(".permission-reason").empty();
                $(".permission-reason").append("<input name='type' type='text' value='2'>");
                $(".modal-header").html("<h4 class='mg-center mb-2 modal-title w-100 font-weight-bold pt-2 header-permission-early'>Xin về sớm</h4>");
                $('#work-day-early').datepicker("setDate", date);
            });
            $('.approve-btn-ot').on('click', function () {
                $('#modal-form-ot').modal('show');
                $(".permission-reason").append("<input name='type' type='text' value='4'>");
                $(".modal-header").html("<h4 class='mg-center mb-2 modal-title w-100 font-weight-bold pt-2 header-permission-ot'>Xin OT</h4>");
                $('#work_day_ot').datepicker("setDate", (date));
            });
            $('.btn-reject').on('click', function () {
                $('#modal-reject').modal('show');
                let explanation = $(this).data("id");
                $(".permission-reason").append("<input name='work_time_explanation_id' type='hidden' value='" + explanation + "'>");
            });

            $('#work-day-late').on('change', function () {
                var data = $(this).val(),
                    type = 1,
                    workDayLate = $(this);
                $.ajax({
                    url: '{{ route('ask_permission.ot') }}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'data': data,
                        'type': type,
                    },
                    success: function (respond) {
                        if (respond === 0) {
                            var status = 0;
                        } else {
                            var status = respond.status;
                        }
                        workDayLate.append("<input name='permission_status' type='hidden' value='" + status + "'>");
                        var note = respond.note ? respond.note : '',
                            otType = respond.ot_type;
                        $('.permission-reason-late').text(note);
                        if (otType) {
                            if (otType === 1) {
                                $('#project-ot').prop('checked', true);
                                $('#other-ot').prop('checked', false);
                            } else if (otType === 2) {
                                $('#other-ot').prop('checked', true);
                                $('#project-ot').prop('checked', false);
                            }
                        }

                        if (respond.status === 1) {
                            $('.header-permission-late').text('Đơn đã được duyệt');
                            $('.permission-reason-late,.btn-permission-late').prop('disabled', true);
                        } else {
                            $('.header-permission-late').text('Xin đi muộn');
                            $('.permission-reason-late,.btn-permission-late').prop('disabled', false);
                        }
                    }
                });
            });

            $('#work-day-early').on('change', function () {
                var data = $(this).val(),
                    type = 2,
                    workDayLate = $(this);
                $.ajax({
                    url: '{{ route('ask_permission.ot') }}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'data': data,
                        'type': type,
                    },
                    success: function (respond) {
                        workDayLate.append("<input name='permission_status' type='hidden' value='" + respond.status + "'>");
                        var note = respond.note ? respond.note : '',
                            otType = respond.ot_type;
                        $('.permission-reason-early').text(note);
                        if (otType) {
                            if (otType === 1) {
                                $('#project-ot').prop('checked', true)
                                $('#other-ot').prop('checked', false)
                            } else if (otType === 2) {
                                $('#other-ot').prop('checked', true)
                                $('#project-ot').prop('checked', false)
                            }
                        }

                        if (respond.status === 1) {
                            $('.header-permission-early').text('Đơn đã được duyệt');
                            $('.permission-reason-early,.btn-permission-early').prop('disabled', true);
                        } else {
                            $('.header-permission-early').text('Xin về sớm');
                            $('.permission-reason-early,.btn-permission-early').prop('disabled', false);
                        }
                    }
                });
            });

            $('#work_day_ot').on('change', function () {
                let data = $(this).val(),
                    type = 4,
                    workDayOT = $(this);

                $.ajax({
                    url: '{{ route('ask_permission.ot') }}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'data': data,
                        'type': type,
                    },
                    success: function (respond) {
                        workDayOT.append("<input name='permission_status' type='hidden' value='" + respond.status + "'>");
                        var note = respond.note ? respond.note : '',
                            otType = respond.ot_type;
                        $('.permission-reason-ot').text(note);
                        if (otType) {
                            if (otType === 1) {
                                $('#project-ot').prop('checked', true)
                                $('#other-ot').prop('checked', false)
                            } else if (otType === 2) {
                                $('#other-ot').prop('checked', true)
                                $('#project-ot').prop('checked', false)
                            }
                        }

                        if (respond.status === 1) {
                            $('.header-permission-ot').text('Đơn đã được duyệt');
                            $('.permission-reason-ot,.btn-permission-ot').prop('disabled', true);
                        } else {
                            $('.header-permission-ot').text('Xin OT');
                            $('.permission-reason-ot,.btn-permission-ot').prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>
@endsection


