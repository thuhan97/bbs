@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off') !!}
@endsection
@section('content')
    @php
        $defaultPerPage = $recordPerPage !== null && $recordPerPage > 0 ? $recordPerPage : 10;
        $defaultApprove = $approve !== null && ($approve == '1' || $approve == '0') ? (int) $approve : null;
        $paginationApprove = $defaultApprove !== null ? '&approve='.$defaultApprove : '';
     if (session()->has('data')) {
        $record = session()->get('data');
    }
    $dataDayOff= $dayOff ?? $availableDayLeft['data'];
    @endphp
    <div class="container-fluid col-12 row">
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">
                        {{ $countDayOff['previous_year'] + $countDayOff['current_year'] - $countDayOff['total'] < 0 ? 0 : $countDayOff['previous_year'] + $countDayOff['current_year'] - $countDayOff['total'] }}
                    </h1>
                    <p class="card-subtitle text-white-50">ngày khả dụng</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Tính từ năm trước</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-success">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">
                        {{ $countDayOff['previous_year'] - $countDayOff['total'] < 0 ? 0 : $countDayOff['previous_year'] - $countDayOff['total'] }}
                    </h1>
                    <p class="card-subtitle text-white-50">nghỉ luôn đi</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">
                        Cuối năm reset
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-warning">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">
                        {{ $countDayOff['total'] }}
                    </h1>
                    <p class="card-subtitle text-white-50">ngày đã nghỉ</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Trong
                        năm {{date('Y')}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6" id="show-modal">
            <div class="card bg-danger cursor-effect" onclick="openCreateAbsenceForm()">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">Thêm</h1>
                    <p class="card-subtitle text-white-50">&nbsp</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">
                        Xin nghỉ phép
                    </p>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <div class="container-fluid col-12 flex-row-reverse d-flex">
        <button class="btn btn-secondary dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            @if(isset($status) && $status == 3)
                Hiển thị: Tất cả
            @elseif(isset($status) && $status == 0)

                Hiển thị: Chưa duyệt
            @elseif(isset($status) && $status == 1)
                Hiển thị: Đã duyệt
            @else
                Hiển thị: Tất cả
            @endif
        </button>

        <div class="dropdown-menu">
            <a class="dropdown-item"
               href="{{ route('day_off',['status'=>ALL_DAY_OFF]) }}">
                <span class="d-flex">
                    <span class="green-red-circle mr-2"></span>
                    <span class="content">Tất cả</span>
                </span>
            </a>
            <a class="dropdown-item"
               href="{{ route('day_off',['status'=>STATUS_DAY_OFF['abide']]) }}">
                <span class="d-flex">
                    <span class="red-circle mr-2"></span>
                    <span class="content">Chưa duyệt</span>
                </span>
            </a>
            <a class="dropdown-item"
               href="{{ route('day_off',['status'=>STATUS_DAY_OFF['active']]) }}">
                <span class="d-flex">
                    <span class="green-circle mr-2"></span>
                    <span class="content">Đã duyệt</span>
                </span>
            </a>
        </div>

        <?php
        $user = \Illuminate\Support\Facades\Auth::user();
        ?>
        @if($user->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE)
            <div class="row d-flex flex-row pr-4 mr-4" style="border-right: 2px solid whitesmoke">
                <div class="d-flex flex-center pl-2 mr-2 ml-2">
                    Quản lý:
                </div>
                <a href="{{route('day_off_approval')}}" class="btn btn-primary" type="button">
                    {{__l('day_off_approval')}}
                </a>
            </div>
        @endif
    </div>

    <div class="container-fluid col-12">
        <table class="table ">
            <thead class="grey lighten-2">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Từ ngày</th>
                <th class="text-center">Tới ngày</th>
                <th class="text-center">Tiêu đề</th>
                <th class="text-center">Ngày nghỉ</th>
                <th class="text-center">Phê duyệt</th>
                <th class="text-center">Xem thêm</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($dataDayOff as $keys => $absence)
                <tr class="dayoffEU_record">
                    <th class="text-center" scope="row">
                        {!! ((($dataDayOff->currentPage()*PAGINATE_DAY_OFF)-PAGINATE_DAY_OFF)+1)+$keys !!}
                    </th>
                    <td class="text-center">{{$absence->start_date}}</td>
                    <td class="text-center">{{$absence->end_date}}</td>
                    <td class="text-center">{{ array_key_exists($absence->title,VACATION) ?  VACATION[$absence->title] : '' }}</td>
                    <td class="text-center">{{!!!$absence->number_off ? 'Chưa rõ' : $absence->number_off}} ngày</td>
                    <td class="text-center">
                        @if($absence->status == STATUS_DAY_OFF['abide'])
                            <i class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                        @elseif($absence->status == STATUS_DAY_OFF['active'])
                            <i class="fas fa-grin-stars fa-2x text-success"></i>
                        @else
                            <i class="fas fa-frown fa-2x text-danger"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <a class="btn btn-indigo btn-sm m-0" href="{{ route('day_off_detail',['id'=>$absence->id]) }}">Chi
                            tiết</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $dataDayOff->render('end_user.paginate') }}
    </div>

    <!-- Modal: View detail absence form -->
    <div class="modal fade right" id="detailAbsence" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-full-height modal-right modal-notify modal-info"
             role="document">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead d-flex flex-row" id="dayoff_heading">
                        Loading...
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">×</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-left">
                        <h4 class="text-bold">Lý do:</h4>
                        <p>
                            <strong id="dayoff_title"></strong>
                        </p>
                        <br>
                        <h4 class="text-bold">Ngày nghỉ:</h4>
                        <p>
                            <strong id="dayoff_duration"></strong>
                        </p>
                        <br>
                        <h4 class="text-bold">Thời gian được tính:</h4>
                        <p>
                            <strong id="dayoff_total"></strong>
                        </p>
                    </div>
                    <hr>
                    <div class="text-left">
                        <h4 class="text-bold">Chi tiết lý do:</h4>
                        <p id="dayoff_reason"></p>
                        <br>
                        <h4 class="text-bold">Ngày duyệt:</h4>
                        <p id="dayoff_approveDate"></p>
                        <br>
                        <h4 class="text-bold">Người duyệt:</h4>
                        <p id="dayoff_approval"></p>
                        <br>
                        <h4 class="text-bold important">Ý kiến</h4>
                        <p id="dayoff_comment"></p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-primary waves-effect waves-light">Báo cáo
                        <i class="fa fa-paper-plane ml-1"></i>
                    </a>
                    <a type="button" class="btn btn-outline-primary waves-effect"
                       data-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal: View detail absence form -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class="modal-title w-100 font-weight-bold pt-2">ĐƠN XIN NGHỈ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('day_off_create') }}" method="post" id="form_create_day_off">
                    @csrf
                    <div class="modal-body mx-3 mt-0 pb-0">
                        <div class="mb-3">

                            <!-- Default input -->
                            <label class="text-w-400" for="exampleForm2">Mục đích xin nghỉ*</label>
                            {{ Form::select('title', VACATION, $record->title ?? null,[ isset($record) ? 'disabled' : '' ,'class' => 'form-control my-1 mr-1  browser-default custom-select md-form select-item reason_id','placeholder'=>'Chọn lý do xin nghỉ']) }}
                            @if ($errors->has('title'))
                                <div class="">
                                    <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="day_off_id" value="{{ $record->id ?? '' }}">
                        <div class="mb-3">
                            <label class="text-w-400" for="exampleFormControlTextarea5">Nội dung</label>
                            <textarea
                                    class="form-control reason_id rounded-0 select-item {{ $errors->has('reason') ? ' has-error' : '' }}"
                                    id="exampleFormControlTextarea2" rows="3" placeholder="lý do xin nghỉ..."
                                    name="reason"
                                    @if(isset($record)) readonly @endif>{{ $record->reason ?? old('reason') }}</textarea>
                            @if ($errors->has('reason'))
                                <div class="mt-1">
                                    <span class="help-block text-danger">{{ $errors->first('reason') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="form-group col-6 m-0">
                                    <label class=" text-w-400" for="inputCity">Ngày bắt đầu nghỉ*</label>
                                    <input type="text"
                                           class="form-control select-item {{ $errors->has('start_at') ? ' has-error' : '' }}"
                                           id="start_date" autocomplete="off" name="start_at"
                                           value="{{ $record->start_at ?? old('start_at') }}" readonly="readonly">
                                </div>
                                <!-- Default input -->
                                <div class="form-group col-6 m-0">
                                    <label class="ml-3 text-w-400" for="inputZip">Tới ngày*</label>
                                    <input type="text"
                                           class="form-control select-item {{ $errors->has('end_at') ? ' has-error' : '' }}"
                                           id="end_date" autocomplete="off" name="end_at"
                                           value="{{ $record->end_at ?? old('end_at') }}"
                                           readonly="readonly">
                                </div>
                                <span id="errors_date" class="text-danger ml-3 "></span>
                            </div>
                            @if ($errors->has('start_at'))
                                <div>
                                    <span class="help-block text-danger">{{ $errors->first('start_at') }}</span>
                                </div>
                            @endif
                            @if ($errors->has('end_at'))
                                <div class="mt-1">
                                    <span class="help-block text-danger">{{ $errors->first('end_at') }}</span>
                                </div>
                            @endif
                        </div>
                        @if(isset($record) && $record->status==1)
                            <div class="mb-2" id="show-record">
                                <div class="row">
                                    <div class="form-group col-6 m-0">
                                        <label class=" text-w-400" for="inputCity">Thời gian được tính</label>
                                        <input class="form-control select-item " type="text"
                                               value="{{ $record->number_off }}" readonly="readonly">
                                    </div>
                                    <!-- Default input -->
                                    <div class="form-group col-6 m-0">
                                        <label class="ml-3 text-w-400" for="inputZip">Ngày phê duyệt</label>
                                        <input class="form-control select-item " type="text"
                                               value="{{ $record->approver_date }}" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        @endif
                                <div class="">
                                    <label class=" mt-1 text-w-400" for="exampleForm2">Người duyệt*</label>
                                    {{ Form::select('approver_id', $userManager, $record->approver_id ?? null, [isset($record) ? 'disabled' : '' ,'class' => 'form-control my-1 mr-1 browser-default custom-select md-form select-item mannager_id','placeholder'=>'Chọn người duyệt đơn' ]) }}
                                    @if ($errors->has('approver_id'))
                                        <div class="mt-1 ml-3">
                                            <span class="help-block text-danger">{{ $errors->first('approver_id') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0"
                                 id="create_day_off">
                                @if(isset($record) && $record->status ==0)
                                    <span class="btn btn-danger" data-toggle="modal" data-target="#basicExampleModal">HỦY ĐƠN</span>
                                @endif
                            </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <form action="{{ route('delete_day_off') }}" method="post">
        @csrf
        <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <input type="hidden" value="{{ $record->id ?? '' }}" name="day_off_id">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="ml-4 modal-title text-center" id="exampleModalLabel">Bạn có chắc chắn muốn xóa đơn
                            này không ? </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary w-25">ĐỒNG Ý</button>
                        <span class="btn btn-primary w-25" data-dismiss="modal">HỦY</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- Modal: Create absence form--}}
    @if (count($errors) > 0)
        <script>
            $(function () {
                $('#create_day_off').html('<button class="btn btn-primary btn-send">GỬI ĐƠN</button>');
                $('#modal-form').modal('show');
            });
        </script>
    @endif
    @if (isset($record))
        <script>
            $(function () {
                $('#modal-form').modal('show');
            });
        </script>
    @endif
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

    @if(session()->has('delete_day_off'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã xóa đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif

    <script type="text/javascript">

        $(document).ready(function () {
            $("#form_create_day_off").validate({
                rules: {
                    title: {
                        required: true,
                        range: [1, 3],
                        digits: true
                    },
                    start_at: {
                        required: true,
                        date: true
                    },
                    end_at: {
                        required: true,
                        date: true
                    },
                    approver_id: {
                        required: true,
                        digits: true
                    },
                    reason: {
                        required: true,
                        maxlength: 100
                    }
                },
                messages: {
                    title: {
                        required: "Vui lòng vui lòng chọn lý do xin nghỉ",
                        digits: "Vui lòng nhập đúng định dạng số",
                        range: "Vui lòng xem lại lý do xin nghỉ"
                    },
                    start_at: {
                        required: "Vui lòng vui lòng chọn lý do ngày nghỉ",
                        date: "Vui lòng nhập đúng địn dạng ngày tháng"
                    },
                    end_at: {
                        required: "Vui lòng vui lòng chọn lý do ngày nghỉ",
                        date: "Vui lòng nhập đúng địn dạng ngày tháng"
                    },
                    approver_id: {
                        required: "Vui lòng chọn ngày phê duyệt",
                        digits: "Vui lòng nhập đúng định dạng số"
                    },
                    reason: {
                        required: "Vui lòng nhập nội dung đơn",
                        maxlength: "Bạn đã nhập quá 100 kí tự"
                    },
                }
            });
            var today = new Date();
            var mon = today.getMonth() + 1;
            var date = today.getFullYear() + '-' + mon + '-' + today.getDate()
            $('#show-modal').on('click', function () {
                $('.mannager_id , .reason_id , #start_date , #end_date ').val('');
                $('.mannager_id,.reason_id').removeAttr('readonly');
                $('.mannager_id , .reason_id ').removeAttr('disabled');
                $('#show-record').hide();
                $('#exampleFormControlTextarea2').text('');
                $('#create_day_off').html('<button class="btn btn-primary btn-send">GỬI ĐƠN</button>');
                $('#modal-form').modal('show');
            });

            $('#start_date').datetimepicker({
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
                startDate: date,
            });
            $('#end_date').datetimepicker({
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
            });
            $('#end_date,#start_date').on('change', function () {
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                if (start == "" || end == "") {
                    $('#errors_date').text('vui lòng chọn ngày bắt đầu và ngày kết thúc');
                    return;
                }
                if (start > end) {
                    $('.btn-send').attr('disabled', 'disabled');
                    $('#errors_date').text('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.');
                } else {
                    $('.btn-send').removeAttr('disabled');
                    $('#errors_date').text('');
                }
            })

        });
    </script>
@endsection

@push('extend-css')
    <link href="{{ cdn_asset('/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ cdn_asset('/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <style>
        #textareaForm {
            height: 150px;
        }

        label {
            user-select: none;
        }
    </style>
@endpush

@push('extend-js')
    <script src="{{ cdn_asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ cdn_asset('/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ cdn_asset('js/jquery.validate.min.js') }}"></script>
    <script>
        function errorOff() {
            let errorBox = document.getElementById('ErrorMessaging');
            if (!!!errorBox) return;

            errorBox.innerHTML = "";
        }

        function errorAlert() {
            let errorBox = document.getElementById('ErrorMessaging');
            if (!!!errorBox) return;

            errorBox.innerHTML = "<div class='card-body'>Thông tin nhập không hợp lệ!</div>";
        }

        // Detail dialog
        let header = document.getElementById('dayoff_heading');
        let title = document.getElementById('dayoff_title');
        let duration = document.getElementById('dayoff_duration');
        let totalOff = document.getElementById('dayoff_total');
        let reason = document.getElementById('dayoff_reason');
        let approveDate = document.getElementById('dayoff_approveDate');
        let approval = document.getElementById('dayoff_approval');
        let comment = document.getElementById('dayoff_comment');

        function clearDetailDialogs() {
            header.innerText = '';
            title.innerText = '';
            duration.innerText = '';
            totalOff.innerText = '';
            approveDate.innerText = '';
            reason.innerText = '';
            approval.innerText = '';
            comment.innerText = '';

            errorOff();
        }

        function openDetailDialog(detailInfo) {
            clearDetailDialogs();
            header.innerHTML = detailInfo.start_at;
            header.appendChild(circleIndicate(detailInfo.status === 1));
            title.innerText = detailInfo.title;
            duration.innerHTML = dateFormat(detailInfo.start_at, detailInfo.end_at);
            totalOff.innerText = !!detailInfo.number_off ? detailInfo.number_off + ' ngày' : "Chưa phê duyệt";
            reason.innerText = detailInfo.reason;
            approveDate.innerText = approvedChecker(!!detailInfo.approver_at, detailInfo.approver_at);
            approval.innerText = detailInfo.approval.name;
            comment.innerText = approvedChecker(!!detailInfo.approve_comment, detailInfo.approve_comment, 'không có');
        }

        function approvedChecker(isApproved = false, approveMessage = 'Đã phê duyệt', notApproveMessage = 'Chưa phê duyệt') {
            if (isApproved) {
                return approveMessage;
            }
            return notApproveMessage;
        }

        function dateFormat(startAt, endAt) {
            return startAt + '<br> <small>tới</small> <br>' + endAt;
        }

        function circleIndicate(isResolved = false) {
            let circle = document.createElement('span');
            if (isResolved) {
                circle.className = 'green-circle ml-2';
            } else {
                circle.className = 'red-circle ml-2';
            }
            return circle;
        }

        // Create dialog
        let titleForm = $('#titleForm');
        let textareaForm = $('#textareaForm');
        let start_atForm = $('#start_atForm');
        let end_atForm = $('#end_atForm');
        let absenceForm = $('#createAbsenceForm');

        function openCreateAbsenceForm() {
            let modalCreate = $('#createAbsenceForm');
            $("#createAbsenceIndicator").hide();
            $("#contentCreateForm").show();
            $("#createAbsenceBtn").show();
            $("#statusCreateForm").html('');
            if (!!!modalCreate) return;
            modalCreate.modal('show');
            $('#start_atForm').datetimepicker();
            $('#end_atForm').datetimepicker();
            loadApprovals();
        }

        /*  function sendAbsenceForm() {
              let approvalID = getApprovalSelected();
              if (titleForm.val().length < 3 || textareaForm.val().length < 3
                  || start_atForm.val().length < 1 || end_atForm.val().length < 1) {
                  errorAlert();
                  return;
              }

              indicatorCreateForm($("#contentCreateForm"), $("#createAbsenceIndicator"));
              $("#createAbsenceBtn").hide();
              let sendingData = {
                  title: !!titleForm ? titleForm.val() : null,
                  reason: !!textareaForm ? textareaForm.val() : null,
                  start_at: !!start_atForm ? start_atForm.val() : null,
                  end_at: !!end_atForm ? end_atForm.val() : null,
                  approver_id: approvalID
              };

              let xhttp = new XMLHttpRequest();
              xhttp.onreadystatechange = function () {
                  console.log(this.status);
                  if (this.readyState === 4 && this.status === 200) {
                      let obj = null;
                      try {
                          obj = JSON.parse(this.response);
                      } catch (e) {
                          obj = null;
                      }
                      if (!!!obj || (obj.hasOwnProperty('success') && !obj.success)) {
                          $("#createAbsenceIndicator").hide();
                          $("#statusCreateForm").html(
                              "<h3 class='text-danger mb-1'>" + obj.message + "</h3></br><button type='button' onclick='closeAbsenceForm()' class='btn btn-secondary'>Đóng</button>"
                          )
                      }
                      if (obj.success) {
                          $("#createAbsenceIndicator").hide();
                          $("#statusCreateForm").html(
                              "<h3 class='text-success mb-1'>Thành công</h3></br><button type='button' onclick='closeAbsenceForm(true)' class='btn btn-success'>Đóng</button>"
                          )

                      }
                      console.log(obj);
                  }

                  if (this.readyState == 4 && this.status == 422) {
                      $("#createAbsenceIndicator").hide();
                      $("#statusCreateForm").html(
                          "<h3 class='text-warning mb-1'>Thông tin không hợp lệ!<br>Vui lòng thử lại!</h3></br><button type='button' onclick='closeAbsenceForm()' class='btn btn-warning'>Đóng</button>"
                      )
                  }
              };
              requestPerform(xhttp, "post", '', JSON.stringify(sendingData));
          }*/

        function clearAbsenceForm() {
            if (!!titleForm) {
                titleForm.val('')
            }
            if (!!textareaForm) {
                textareaForm.val('')
            }
            if (!!start_atForm) {
                start_atForm.val('')
            }
            if (!!end_atForm) {
                end_atForm.val('')
            }

            errorOff();
        }

        function closeAbsenceForm(reload = false) {
            clearAbsenceForm();
            if (!!absenceForm) absenceForm.modal('hide');
            if (reload) {
                location.reload(true);
            }
        }

        function indicatorCreateForm(hideElement, showElement) {
            if (!!hideElement) {
                hideElement.hide('fast', function () {
                    if (!!showElement)
                        showElement.show('fast')
                });
            } else {
                if (!!showElement)
                    showElement.show('fast')
            }
        }

        function buildApprovalsSelector(responseObject) {
            let arrApprovals = null;
            try {
                arrApprovals = JSON.parse(responseObject);
            } catch (e) {
                arrApprovals = null;
            }

            if (!!!arrApprovals) {
                return;
            }

            function blockOption(user) {
                if (!user.hasOwnProperty('id') || !user.hasOwnProperty('name')) {
                    return null;
                }

                let optionBlock = document.createElement('option');
                optionBlock.setAttribute('value', user.id);
                optionBlock.innerText = user.name;
                return optionBlock;
            }

            if (arrApprovals.hasOwnProperty('data') && Array.isArray(arrApprovals.data)) {
                let selector = document.getElementById('approvals_selector');
                if (!!selector) {
                    selector.innerHTML = '';
                    arrApprovals.data.forEach(user => {
                        let node = blockOption(user);
                        if (!!node) {
                            selector.appendChild(node);
                        }
                    });
                }
            }
        }

        function getApprovalSelected() {
            let selector = document.getElementById('approvals_selector');
            return selector.options[selector.selectedIndex].value;
        }

        function loadApprovals() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    buildApprovalsSelector(this.response);
                }
            };
            requestPerform(xhttp, 'get', '{{route('day_off_listApprovalAPI')}}', null)
        }

        // GLOBAL
        function requestPerform(xhttp, type, url, sendingData) {
            xhttp.open(type, url, true);
            xhttp.setRequestHeader("Content-type", "application/json");
            xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            xhttp.send(sendingData);
        }
    </script>
@endpush