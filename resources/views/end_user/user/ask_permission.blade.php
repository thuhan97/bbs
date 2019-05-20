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
    @if ($errors->has('project_id'))
        <span class="help-block mb-5 color-red">
            <strong>{{ $errors->first('project_id') }}</strong>
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
            @can('team-leader')
                <h2 class="mt-3 mobile-font-17">Danh sách xin phép</h2>
            @endcan
        </div>
        <div class="col-md-8 text-right mobile-mg-right-5">
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



    @can('team-leader')
        @if($managerApproveOther || $managerApproveOT)
            <!-- Nav tabs -->
            <ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#panelApprove" role="tab">Xin đi
                        muộn/sớm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-nav-link-ot" data-toggle="tab" href="#panelOT" role="tab">Xin OT</a>
                </li>
            </ul>
            <!-- Nav tabs -->

            <!-- Tab panels -->
            <div class="tab-content">
                <!-- Panel 1 -->
                <div class="tab-pane fade in show active" id="panelApprove" role="tabpanel">
                    <table id="contactTbl" class="table table-striped table-bordered">
                        <colgroup>
                            <col style="width: 50px">
                            <col style="width: 100px">
                            <col style="width: 180px">
                            <col style="width: 100px">
                            <col style="">
                            <col style="">
                            <col style="width: 100px">
                        </colgroup>
                        <thead class="grey lighten-2">
                        <tr>
                            <th class="text-center d-none d-md-table-cell">#</th>
                            <th class="text-center mb-with-32">Ngày</th>
                            <th class="table-with-42">Tên nhân viên</th>
                            <th>Hình thức</th>
                            <th class="d-none d-md-table-cell">Nội dung</th>
                            <th class="d-none d-md-table-cell">Nội dung phản hồi</th>
                            <th class="text-center" style="width: 10%;">Trạng Thái</th>
                        </tr>
                        </thead>
                        <?php $increment = 1; ?>
                        <tbody>
                        @foreach($managerApproveOther as $item)
                            {{--@dd($item)--}}
                            <tr>
                                <th class="text-center d-none d-md-table-cell"
                                    style="padding: 15px">{{ $increment++ }}</th>
                                <th class="text-center" style="padding: 15px">{{ $item['work_day'] ?? '' }}</th>
                                <th class="table-with-42">{{ $item->creator->name ?? '' }}</th>
                                <td>
                                    @if($item->type == 1)
                                        Đi muộn
                                    @elseif($item->type == 2)
                                        Về sớm
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell">{!! $item['note'] !!}</td>
                                <td class="d-none d-md-table-cell">{!! $item['reason_reject'] !!}</td>
                                <td class="text-center td-approve">
                                    @can('manager')
                                        @if($item['status'] == array_search('Chưa duyệt', OT_STATUS))
                                            <button class="btn btn-info text-uppercase text-center approve"
                                                    data-permission="other"
                                                    data-id="{{ $item['id'] ? $item['id'] : '' }}"
                                                    data-itemType="@if($item->type == 1) Xin đi muộn @elseif($item->type == 2) Xin về sớm @endif">
                                                Duyệt
                                            </button>
                                        @elseif($item['status'] == array_search('Đã duyệt', OT_STATUS))
                                            <i class="fas fa-grin-stars fa-2x text-success"
                                               title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                        @elseif($item['status'] == array_search('Từ chối', OT_STATUS))
                                            <i class="fas fa-frown fa-2x text-danger"
                                               title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                        @endif
                                    @elsecan('team-leader')
                                        @if($item['status'] == array_search('Đã duyệt', OT_STATUS))
                                            <i class="fas fa-grin-stars fa-2x text-success"
                                               title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                        @elseif($item['status'] == array_search('Chưa duyệt', OT_STATUS))
                                            <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                                        @elseif($item['status'] == array_search('Từ chối', OT_STATUS))
                                            <i class="fas fa-frown fa-2x text-danger"
                                               title="{{ $item->workTimeApprover->name ?? ''  }}"></i>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$dataLeader->render('end_user.paginate') }}
                    <br>
                </div>
                <!-- Panel 1 -->

                <!-- Panel 2 -->
                <div class="tab-pane fade" id="panelOT" role="tabpanel">

                    <table id="contactTbl" class="table table-striped table-bordered">
                        <colgroup>
                            <col style="width: 50px">
                            <col style="width: 100px">
                            <col style="width: 180px">
                            <col style="width: 100px">
                            <col style="width: 180px">
                            <col style="">
                            <col style="">
                            <col style="width: 100px">
                        </colgroup>
                        <thead class="grey lighten-2">
                        <tr>
                            <th class="text-center d-none d-md-table-cell">#</th>
                            <th class="text-center mb-with-32" style="padding: 15px">Ngày</th>
                            <th class="table-with-42">Tên nhân viên</th>
                            <th>Hình thức</th>
                            <th class="d-none d-md-table-cell">Thời gian</th>
                            <th class="d-none d-md-table-cell">Nội dung</th>
                            <th class="d-none d-md-table-cell">Nội dung phản hồi</th>
                            <th class="text-center" style="width: 10%;">Trạng Thái</th>
                        </tr>
                        </thead>
                        <?php $increment = 1; ?>
                        <tbody>
                        @foreach($managerApproveOT as $item)
                            {{--@dd($item)--}}
                            <tr>
                                <th class="text-center d-none d-md-table-cell"
                                    style="padding: 15px">{{ $increment++ }}</th>
                                <th class="text-center">{{ $item['work_day'] ?? '' }}</th>
                                <th class="table-with-42">{{ $item->creator->name ?? '' }}</th>
                                <td>
                                    {{$item->ot_type ? $item->ot_type == array_search('Dự án', OT_TYPE) ? 'OT Dự án' : 'OT cá nhân' : '' }}
                                </td>
                                <td class="d-none d-md-table-cell">{{$item->description_time}}
                                </td>
                                <td class="d-none d-md-table-cell">{!! $item['reason'] !!}</td>
                                <td class="d-none d-md-table-cell">{!! $item['note_respond'] !!}</td>
                                <td class="text-center td-approve">
                                    @can('manager')
                                        @if($item['status'] == array_search('Chưa duyệt', OT_STATUS))

                                            <button class="btn btn-info text-uppercase text-center approve"
                                                    data-permission="ot"
                                                    data-id="{{ $item['id'] ? $item['id'] : '' }}"
                                                    data-itemtype="{{$item->ot_type ? $item->ot_type == array_search('Dự án', OT_TYPE) ? 'OT Dự án' : 'OT cá nhân' : '' }}">
                                                Duyệt
                                            </button>
                                        @elseif($item['status'] == array_search('Đã duyệt', OT_STATUS))
                                            <i class="fas fa-grin-stars fa-2x text-success"
                                               title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                        @elseif($item['status'] == array_search('Từ chối', OT_STATUS))
                                            <i class="fas fa-frown fa-2x text-danger"
                                               title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                        @endif
                                    @elsecan('team-leader')
                                        @if($item['status'] == array_search('Đã duyệt', OT_STATUS))
                                            <i class="fas fa-grin-stars fa-2x text-success"
                                               title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                                        @elseif($item['status'] == array_search('Chưa duyệt', OT_STATUS))
                                            <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                                        @elseif($item['status'] == array_search('Từ chối', OT_STATUS))
                                            <i class="fas fa-frown fa-2x text-danger"
                                               title="{{ $item->workTimeApprover->name ?? ''  }}"></i>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$dataLeader->render('end_user.paginate') }}
                    <br>

                </div>
                <!-- Panel 2 -->

            </div>
            <!-- Tab panels -->
        @endif
    @endcan



    <h2>Xin phép cá nhân</h2>
    <br>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs md-tabs nav-justified primary-color" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel555" role="tab">Xin đi muộn/sớm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link tab-nav-link-ot" data-toggle="tab" href="#panel666" role="tab">Xin OT</a>
        </li>
    </ul>
    <!-- Nav tabs -->

    <!-- Tab panels -->
    <div class="tab-content">
        <!-- Panel 1 -->
        <div class="tab-pane fade in show active" id="panel555" role="tabpanel">
            <table id="contactTbl" class="table table-striped table-bordered">
                <colgroup>
                    <col style="width: 50px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="">
                    <col style="">
                    <col style="width: 100px">
                </colgroup>
                <thead class="grey lighten-2">
                <tr>
                    <th class="text-center d-none d-md-table-cell">#</th>
                    <th class="text-center table-with-42">Ngày</th>
                    <th>Hình thức</th>
                    <th class="d-none d-md-table-cell">Nội dung</th>
                    <th class="d-none d-md-table-cell">Nội dung từ chối</th>
                    <th class="text-center">Trạng Thái</th>
                </tr>
                </thead>
                <tbody>

                @foreach($askPermission as $increment => $item)
                    <tr>
                        <th class="text-center d-none d-md-table-cell">{{ $increment+1 }}</th>
                        <th class="text-center" style="padding: 15px;width: 10%;">{{ $item['work_day'] ?? '' }}</th>
                        <td>
                            {{--{{$item->type_name}}aaa--}}
                            @if($item['type'] == array_search('Bình thường', WORK_TIME_TYPE))
                                Bình thường
                            @elseif($item['type'] == array_search('Đi muộn', WORK_TIME_TYPE))
                                Đi muộn
                            @elseif($item['type'] == array_search('Về Sớm', WORK_TIME_TYPE))
                                Về sớm
                            @elseif($item['type'] == array_search('Overtime', WORK_TIME_TYPE))
                                @if($item['ot_type'] == array_search('Dự án', OT_TYPE))
                                    OT dự án
                                @elseif($item['ot_type'] == array_search('OT lý do cá nhân', OT_TYPE))
                                    OT cá nhân
                                @endif
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">{!! $item['note'] ?? '' !!}</td>
                        <td class="d-none d-md-table-cell">{!! $item['reason_reject'] ?? '' !!}</td>
                        <td class="text-center td-approve">
                            @if($item['status'] == array_search('Đã duyệt', OT_STATUS))
                                <i class="fas fa-grin-stars fa-2x text-success"
                                   title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                            @elseif($item['status'] == array_search('Chưa duyệt', OT_STATUS))
                                <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                            @elseif($item['status'] == array_search('Từ chối', OT_STATUS))
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
                    <col style="width: 50px">
                    <col style="width: 100px">
                    <col style="width: 100px">
                    <col style="width: 180px">
                    <col style="">
                    <col style="">
                    <col style="width: 100px">
                </colgroup>
                <thead class="grey lighten-2">
                <tr>
                    <th class="text-center d-none d-md-table-cell">#</th>
                    <th class="text-center">Ngày</th>
                    <th>Hình thức</th>
                    <th>Thời gian</th>
                    <th class="d-none d-md-table-cell">Nội dung</th>
                    <th class="d-none d-md-table-cell">Nội dung từ chối</th>
                    <th class="text-center">Trạng Thái</th>
                </tr>
                </thead>
                <tbody>

                @foreach($otTimes as $increment => $item)
                    <tr>
                        <th class="text-center d-none d-md-table-cell">{{ $increment+1 }}</th>
                        <th class="text-center mb-with-32" style="padding: 15px">{{ $item['work_day'] ?? '' }}</th>
                        <td>
                            {{$item->ot_type ? $item->ot_type == 1 ? 'OT Dự án' : 'OT cá nhân' : '' }}
                        </td>
                        <td class="mb-with-32">{{$item->description_time}}</td>
                        <td class="d-none d-md-table-cell">{!! $item['reason'] !!}</td>
                        <td class=" d-none d-md-table-cell">{!! $item['note_respond'] !!}</td>
                        <td class="text-center td-approve">
                            @if($item['status'] == array_search('Đã duyệt', OT_STATUS))
                                <i class="fas fa-grin-stars fa-2x text-success"
                                   title="{{ $item->workTimeApprover->name ?? '' }}"></i>
                            @elseif($item['status'] == array_search('Chưa duyệt', OT_STATUS))
                                <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                            @elseif($item['status'] == array_search('Từ chối', OT_STATUS))
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

    {{--{{ $datas->render('end_user.paginate') }}--}}
    <div class="modal fade reject" id="modal-reject" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center permission-modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class='mg-center mb-2 modal-title w-100 font-weight-bold pt-2 mg-left-10 title-permission'>Nội
                        dung đơn</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="permission-detail">
                    <div class="container-fluid">

                        <h5 class="bold">Người xin phép:</h5>
                        <p class="creator_id"></p>
                        <div class="content-hidden">
                            <h5 class="bold">Tên dự án:</h5>
                            <p class="project_id"></p>
                        </div>
                        <div class="row content-hidden">
                            <div class="col-4">
                                <h5 class="bold">Giờ bắt đầu:</h5>
                                <p class="start_at"></p>
                            </div>
                            <div class="col-4">
                                <h5 class="bold">Giờ kết thúc:</h5>
                                <p class="end_at"></p>
                            </div>
                            <div class="col-4">
                                <h5 class="bold">Số phút OT</h5>
                                <p class="minute"></p>
                            </div>
                            <br>
                        </div>
                        <h5 class="bold">Nội dung:</h5>
                        <p class="reason"></p>
                    </div>

                </div>
                <form action="{{ route('ask_permission.approvePermission') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <input type="hidden" class="id" name="id">
                    <input type="hidden" class="approve-type" name="approve_type">
                    <input type="hidden" class="permission-type" name="permission_type">
                    <textarea class="form-control permission-reason" name="reason_approve" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn-send btn-approve mr-2" id="btn-approve">DUYỆT ĐƠN</button>
                        <button class="btn-send btn-reject ml-2" id="btn-reject">KHÔNG DUYỆT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade myModal" id="modal-form" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center permission-modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">×</span>
                    </button>
                </div>
                @include('elements.ask_permission_image')
                <form action="{{ route('ask_permission.create') }}" method="get">
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="select-day">
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
        <div class="modal-dialog modal-center permission-modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                @include('elements.ask_permission_image')
                <form action="{{ route('ask_permission.create') }}" method="get">
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="select-day">
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
        <div class="modal-dialog modal-center permission-modal-set-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                @include('elements.ask_permission_image')
                <form action="{{ route('ask_permission.create') }}" method="get">
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="container-fluid my-2">
                        <div class="row">
                            <input type="hidden" name="ot_id" class="ot_id">
                            <input type="hidden" name="permission_status" class="permission_status">
                            <div class="col-md-6 text-center mt-3">
                                <input style="position: relative;opacity: 1;pointer-events: inherit"
                                       class="other-ot ml-5"
                                       type="radio" name="ot_type" id="project-ot" checked value="1">
                                <label for="project-ot">OT dự án</label>
                            </div>
                            <div class="col-md-6 text-center mt-3">
                                <input style="position: relative;opacity: 1;pointer-events: inherit" class="other-ot"
                                       type="radio" name="ot_type" id="other-ot" value="2">
                                <label for="other-ot" class="mr-5">Lý do cá nhân</label>
                            </div>
                        </div>
                    </div>
                    <select class="browser-default form-control project_id my-2 permission_project_id" name="project_id"
                            style="width: 83%;margin: 0 auto;" id="project_id">
                        <option value="0">Chọn dự án</option>
                    </select>
                    <div class="select-day">
                        <div class="container-fluid">
                            <div class="row append-textarea">
                                <div class="col-5 my-2 ml-3">
                                    <label for="inputCity" class="my-2">Chọn ngày *</label>
                                </div>
                                <div class="col-5 my-2 offset-1 pl-0 pr-0">
                                    <input type="hidden" name="permission_ot">
                                    <input type="hidden" value="4" name="permission_type">
                                    <input type="text"
                                           class="form-control select-item {{ $errors->has('work_day') ? ' has-error' : '' }}"
                                           id="work_day_ot" autocomplete="off" name="work_day"
                                           value="{{ old('work_day', date('Y-m-d')) }}"
                                           readonly="readonly" style="width: 96.5%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 offset-1 my-2">
                            <div class="form-group ">
                                <label for="start_at">Thời gian bắt đầu *</label>
                                <div class="input-group date">
                                    <input type="time" class="form-control pull-right" autocomplete="off"
                                           name="start_at"
                                           value=""
                                           id="start_at">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 my-2">
                            <div class="form-group">
                                <label for="end_at">Thời gian kết thúc *</label>
                                <div class="input-group date">
                                    <input type="time" class="form-control pull-right"
                                           name="end_at" autocomplete="off"
                                           value=""
                                           id="end_at">
                                </div>
                            </div>
                        </div>
                    </div>
                    <textarea class="mt-2 form-control permission-reason-ot" name="note" cols="48" rows="6"
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
            $('.approve').on('click', function () {
                var otThis = $(this);
                if (otThis.attr('id') === 'btn-reject') {
                    $('.approve-type').attr('value', 2)
                } else if (otThis.attr('id') === 'btn-approve') {
                    $('.approve-type').attr('value', 1)
                }
                $('#modal-reject').modal('show');
                var id = $(this).data("id"),
                    permissionType = $(this).data("permission"),
                    itemtype = $(this).data("itemtype");
                console.log(itemtype)
                $('.modal-title').text(itemtype)
                // debugger
                $('.id').attr('value', id);
                $.ajax({
                    url: '{{ route('ask_permission.approveDetail') }}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'id': id,
                        'permission-type': permissionType,
                    },
                    success: function (respond) {
                        // $('.id').attr('value', respond.id);
                        if (permissionType === 'ot') {
                            $('.creator_id').text(respond.creator_id);
                            $('.project_id').text(respond.project_id);
                            $('.start_at').text(respond.start_at);
                            $('.end_at').text(respond.end_at);
                            $('.minute').text(respond.minute);
                            $('.reason').text(respond.reason);
                        } else if (permissionType === 'other') {
                            $('.creator_id').text(respond.user_id);
                            $('.reason').text(respond.note);
                        }
                    }
                });
                if (permissionType === 'ot') {
                    $('.content-hidden').prop('hidden', false)
                    $('.permission-type').attr('value', 'ot')
                } else {
                    $('.content-hidden').prop('hidden', true)
                    $('.permission-type').attr('value', 'other')
                    // $('.permission-detail').hide()
                    $('.creator_id,.project_id,.start_at,.end_at,.minute,.reason').empty()
                }
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
                        if (respond[0]) {
                            $('.permission_status').attr('value', respond[0].status);
                            $('#start_at').attr('value', respond[0].start_at);
                            $('#end_at').attr('value', respond[0].end_at);
                            $('.ot_id').attr('value', respond[0].id);

                            workDayOT.append("<input name='' type='hidden' value='" + respond[0].status + "'>");
                            var note = respond[0].reason ? respond[0].reason : '',
                                otType = respond[0].ot_type;
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
                            // if (respond[0].ot_type == 2) {
                            //     $('.project_id ').prop('disabled', true);
                            // } else {
                            //     $('.project_id ').prop('disabled', false);
                            // }

                        }
                        if (respond[1]) {
                            respond[1].forEach(function (element) {
                                $('.project_id').append('<option value="' + element.id + '">' + element.name + '</option>');
                            });
                        } else {
                            $('.permission-reason-ot').empty();
                        }

                        $('.project_id').val(respond[0].project_id);
                        if (respond[0].status === 1) {
                            $('.header-permission-ot').text('Đơn đã được duyệt');
                            $('.permission-reason-ot,.btn-permission-ot,#start_at,#end_at,#project_id').prop('disabled', true);
                        } else {
                            $('.header-permission-ot').text('Xin OT');
                            $('.permission-reason-ot,.btn-permission-ot,#start_at,#end_at,#project_id').prop('disabled', false);
                        }
                    }
                });
                $('.project_id option[value!="0"]').remove();
            });
            $('.approve-type').attr('value', '');

            $('#btn-approve, #btn-reject').on('click', function () {
                var selectorID = $(this).attr('id');
                if (selectorID === 'btn-approve') {
                    $('.approve-type').attr('value', 1)
                } else if (selectorID === 'btn-reject') {
                    $('.approve-type').attr('value', 2)
                }
            });
        });
    </script>
@endsection


