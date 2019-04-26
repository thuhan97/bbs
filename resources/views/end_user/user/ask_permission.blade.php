@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('ask_permission') !!}
@endsection
@section('content')
    @if(session()->has('create_permission_success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã gửi đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @elseif(session()->has('approver_success'))
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
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    ?>
    @can('team-leader')
        @if($dataLeader->isNotEmpty())
            <h1>Danh sách xin phép</h1>
            <table id="contactTbl" class="table table-striped">
                <colgroup>
                    <col style="">
                    <col style="">
                    <col style="">
                    <col style="">
                </colgroup>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ngày</th>
                    <th>Tên nhân viên</th>
                    <th>Hình thức</th>
                    <th>Nội dung</th>
                    <th class="text-center">Trạng Thái</th>
                </tr>
                </thead>
                <?php $increment = 1; ?>
                <tbody>
                @foreach($dataLeader as $item)
                    <tr>
                        <th>{{ $increment++ }}</th>
                        <th>{{ $item['work_day'] ?? '' }}</th>
                        <th>{{ $item->user->name ?? '' }}</th>
                        <td>
                            {{$item->type_name}}
                        </td>
                        <td>{{ $item['note'] ?? '' }}</td>
                        <td class="text-center">
                            @if(!$item['id_ot_time'])
                                @can('manager')
                                    <form action="{{ route('approved') }}">
                                        <input type="hidden" name="user_id"
                                               value="{{ $item['user_id'] ? $item['user_id'] : '' }}">
                                        <input type="hidden" name="reason"
                                               value="{{ $item['note'] ? $item['note'] : '' }}">
                                        <input type="hidden" name="work_day"
                                               value="{{ $item['work_day'] ? $item['work_day'] : '' }}">
                                        <button class="btn btn-primary waves-effect waves-light">Phê duyệt</button>
                                    </form>
                                @else
                                    <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                                @endcan

                            @else
                                <i class="fas fa-grin-stars fa-2x text-success" title="Đã duyệt"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$dataLeader->render('end_user.paginate') }}
            <br><br><br>
        @endif
    @endcan
    <div class="row">
        <div class="col-md-7">
            <h2>Xin phép cá nhân</h2>
        </div>

        <div class="col-md-5 text-right">
            <button type="button"
                    class="d-none d-xl-block btn btn-primary btn-ot waves-effect waves-light float-right"
                    id="btn-late-ot">
                Xin OT
            </button>
            <button type="button"
                    class="d-none d-xl-block btn btn-warning btn-early waves-effect waves-light float-right"
                    id="btn-early-late">Xin về sớm
            </button>
            <button type="button" class="btn btn-success btn-late waves-effect waves-light float-right" id="btn-ot">
                Xin đi muôn
            </button>
            <button onclick="location.href='{{route("day_off")}}?t=1'"
                    class="btn btn-danger waves-effect waves-light float-right" id="btn-off">
                Xin nghỉ
            </button>
        </div>
    </div>
    <table id="contactTbl" class="table table-striped">
        <colgroup>
            <col style="">
            <col style="">
            <col style="">
            <col style="">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>Ngày</th>
            <th>Hình thức</th>
            <th>Nội dung</th>
            <th class="text-center">Trạng Thái</th>
        </tr>
        </thead>
        <tbody>

        @foreach($datas as $increment => $item)
            <tr>
                <th>{{ $increment+1 }}</th>
                <th>{{ $item['work_day'] ?? '' }}</th>
                <td>
                    {{$item->type_name}}
                </td>
                <td>{{ $item['note'] ?? '' }}</td>
                <td class="text-center">
                    @if(is_null($item['id_ot_time']))
                        <i class="fas fa-meh-blank fa-2x text-warning" title="Chưa duyệt"></i>
                    @else
                        <i class="fas fa-grin-stars fa-2x text-success" title="Đã duyệt"></i>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$datas->render('end_user.paginate') }}
    <div class="modal fade myModal" id="modal-form" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center" role="document">
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
                <form action="{{ route('ask_permission.create') }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-center text-area-reason" id="div-reason"></div>
                    <div class="offset-1 select-day">
                        <label class=" text-w-400" for="inputCity">Chọn ngày *</label>
                        <input style="width: 43%;" type="text"
                               class="form-control select-item {{ $errors->has('work_day') ? ' has-error' : '' }}"
                               id="work_day" autocomplete="off" name="work_day" value="{{  old('work_day') }}"
                               readonly="readonly">
                    </div>
                    <br>
                    <textarea class="form-control permission-reason" name="note" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
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
                <form action="{{ route('ask_permission.create') }}" method="post">
                    @csrf
                    <div class="row col-md-12">
                        <div class="col-2"></div>
                        <div class="col-md-4 text-center">
                            <input style="position: relative;opacity: 1;pointer-events: inherit" class="other-ot"
                                   type="radio" name="ot_type" id="project-ot" value="1">
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
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-4">
                                    <label for="inputCity">Chọn ngày *</label>
                                </div>
                                <div class="col-4">
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
                    <textarea class="form-control permission-reason" name="note" cols="48" rows="6"
                              placeholder="Nhập lý do ..."></textarea>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
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
                currentMonth = date.getMonth(),
                currentYear = date.getFullYear(),
                currenFullTime = currentYear + '-' + currentMonth + '-' + currentDate;
            $('#work_day').datepicker({format: 'yyyy-mm-dd'});
            $('#work_day_ot').datepicker({format: 'yyyy-mm-dd'});
            $('.btn-early').on('click', function () {
                $('#modal-form').modal('show');
                $(".permission-reason").append("<input name='type' type='text' value='2'>");
                $('#work_day').datepicker("setDate", date);

            });
            $('.btn-late').on('click', function () {
                $('#modal-form').modal('show');
                $(".permission-reason").append("<input name='type' type='text' value='1'>");
                $('#work_day').datepicker("setDate", currenFullTime);

            });
            $('.btn-ot').on('click', function () {
                $('#modal-form-ot').modal('show');
                $(".permission-reason").append("<input name='type' type='text' value='4'>");
                $('#modal-form-ot').datepicker("setDate", (date));
            });
        });
    </script>
@endsection

                        