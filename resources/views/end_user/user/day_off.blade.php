@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off') !!}
@endsection
@section('content')
    @php
        $defaultPerPage = $recordPerPage !== null && $recordPerPage > 0 ? $recordPerPage : 10;
        $defaultApprove = $approve !== null && ($approve == '1' || $approve == '0') ? (int) $approve : null;
        $paginationApprove = $defaultApprove !== null ? '&approve='.$defaultApprove : '';
    @endphp

    <div class="container-fluid col-12 row">
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">
                        {{$availableDayLeft['remain_current'] + $availableDayLeft['remain_previous']}}
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
                        {{$availableDayLeft['remain_current']}}
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
                        {{$availableDayLeft['total_current'] - $availableDayLeft['remain_current']}}
                    </h1>
                    <p class="card-subtitle text-white-50">ngày đã nghỉ</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Trong
                        năm {{date('Y')}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6" data-toggle="modal" data-target="#modal-form">
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
            @if($defaultApprove !== 1 && $defaultApprove !== 0)
                Hiển thị: Tất cả
            @elseif($defaultApprove == 0)
                Hiển thị: Chưa duyệt
            @else
                Hiển thị: Đã duyệt
            @endif
        </button>

        <div class="dropdown-menu">
            @if(!($defaultApprove !== 1 && $defaultApprove !== 0))
                <a class="dropdown-item"
                   href="{{url()->current().'?page=1&per_page='.$defaultPerPage}}">
                <span class="d-flex">
                    <span class="green-red-circle mr-2"></span>
                    <span class="content">Tất cả</span>
                </span>
                </a>
            @endif

            @if($defaultApprove !== 0)
                <a class="dropdown-item"
                   href="{{url()->current().'?page=1&per_page='.$defaultPerPage.'&approve=0'}}">
                <span class="d-flex">
                    <span class="red-circle mr-2"></span>
                    <span class="content">Chưa duyệt</span>
                </span>
                </a>
            @endif

            @if($defaultApprove !== 1)
                <a class="dropdown-item"
                   href="{{url()->current().'?page=1&per_page='.$defaultPerPage.'&approve=1'}}">
                <span class="d-flex">
                    <span class="green-circle mr-2"></span>
                    <span class="content">Đã duyệt</span>
                </span>
                </a>
            @endif
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
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Từ ngày</th>
                <th scope="col">Tới ngày</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Ngày nghỉ</th>
                <th scope="col">Phê duyệt</th>
                <th scope="col">Xem thêm</th>
            </tr>
            </thead>
            <tbody>
            @if(sizeof($listDate) > 0)
                @foreach ($listDate as $absence)
                    <tr class="dayoffEU_record">
                        <th scope="row">{{$loop->index + 1}}</th>
                        <td>{{$absence->start_at}}</td>
                        <td>{{$absence->end_at}}</td>
                        <td>{{$absence->title}}</td>
                        <td>{{!!!$absence->number_off ? 'Chưa rõ' : $absence->number_off}} ngày</td>
                        <td>
                            @if ($absence->status == 1)
                                <div class="green-circle"></div>
                            @else
                                <div class="red-circle"></div>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-indigo btn-sm m-0" data-toggle="modal"
                                    onclick="openDetailDialog({{$absence}})"
                                    data-target="#detailAbsence">Chi tiết
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Không có kết quả</td>
                </tr>
            @endif
            </tbody>
        </table>
        @if($paginateData['last_page'] > 1)
            {{--Pagination--}}
            <div class="container-fluid d-flex flex-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination pg-blue">
                        <li class="page-item {{$paginateData['current_page'] === 1 ? 'disabled': ''}}">
                            <a href="{{$paginateData['first_page_url'].'&per_page='. $defaultPerPage. $paginationApprove}}"
                               class="page-link">Trang đầu</a>
                        </li>
                        <li class="page-item {{$paginateData['current_page'] === 1 ? 'disabled': ''}}">
                            <a href="{{$paginateData['prev_page_url'].'&per_page='. $defaultPerPage. $paginationApprove}}"
                               class="page-link" tabindex="-1">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>

                        @if ($paginateData['current_page'] - 4 > 0)
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] - 4).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    ...
                                </a>
                            </li>
                        @endif

                        @if ($paginateData['current_page'] - 3 > 0)
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] - 3).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    {{$paginateData['current_page'] - 3}}
                                </a>
                            </li>
                        @endif

                        @if ($paginateData['current_page'] - 2 > 0)
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] - 2).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    {{$paginateData['current_page'] - 2}}
                                </a>
                            </li>
                        @endif

                        @if($paginateData['current_page'] - 1 > 0)
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] - 1).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    {{$paginateData['current_page'] - 1}}
                                </a>
                            </li>
                        @endif

                        <li class="page-item active">
                            <a class="page-link">
                                {{$paginateData['current_page']}}
                                <span class="sr-only">
                                (current)
                            </span>
                            </a>
                        </li>

                        @if($paginateData['current_page'] + 1 <= $paginateData['last_page'])
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] + 1).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    {{$paginateData['current_page'] + 1}}
                                </a>
                            </li>
                        @endif

                        @if($paginateData['current_page'] + 2 <= $paginateData['last_page'])
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] + 2).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    {{$paginateData['current_page'] + 2}}
                                </a>
                            </li>
                        @endif

                        @if($paginateData['current_page'] + 3 <= $paginateData['last_page'])
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] + 3).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    {{$paginateData['current_page'] + 3}}
                                </a>
                            </li>
                        @endif

                        @if($paginateData['current_page'] + 4 <= $paginateData['last_page'])
                            <li class="page-item">
                                <a href="{{$paginateData['path'].'?page='.($paginateData['current_page'] + 4).'&per_page='. $defaultPerPage. $paginationApprove}}"
                                   class="page-link">
                                    ...
                                </a>
                            </li>
                        @endif
                        <li class="page-item {{$paginateData['current_page'] === $paginateData['last_page'] ? 'disabled': ''}}">
                            <a href="{{$paginateData['next_page_url'].'&per_page='. $defaultPerPage. $paginationApprove}}"
                               class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li class="page-item {{$paginateData['current_page'] === $paginateData['last_page'] ? 'disabled': ''}}">
                            <a href="{{$paginateData['last_page_url'].'&per_page='. $defaultPerPage. $paginationApprove}}"
                               class="page-link">Trang cuối</a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif
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
                <form action="{{ route('day_off_create') }}" method="post">
                    @csrf
                    <div class="modal-body mx-3 mt-0 pb-0">
                        <div class="mb-3">
                            <!-- Default input -->
                            <label class="ml-3 text-w-400" for="exampleForm2">Mục đích xin nghỉ*</label>
                            {{ Form::select('title', VACATION, null, ['class' => 'form-control my-1 mr-1 browser-default custom-select md-form select-item']) }}
                            @if ($errors->has('title'))
                                <div class="">
                                    <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="ml-3 text-w-400" for="exampleFormControlTextarea5">Nội dung</label>
                            <textarea
                                    class="form-control rounded-0 select-item {{ $errors->has('reason') ? ' has-error' : '' }}"
                                    id="exampleFormControlTextarea2" rows="3" placeholder="lý do xin nghỉ..."
                                    name="reason">{{ old('reason') }}</textarea>
                            @if ($errors->has('reason'))
                                <div class="mt-1">
                                    <span class="help-block text-danger">{{ $errors->first('reason') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="form-group col-6 m-0">
                                    <label class="ml-3 text-w-400" for="inputCity">Ngày bắt đầu nghỉ*</label>
                                    <input type="text"
                                           class="form-control select-item {{ $errors->has('start_at') ? ' has-error' : '' }}"
                                           id="start_date" autocomplete="off" name="start_at"
                                           value="{{ old('start_at') }}" readonly="readonly">
                                </div>
                                <!-- Default input -->
                                <div class="form-group col-6 m-0">
                                    <label class="ml-3 text-w-400" for="inputZip">Tới ngày*</label>
                                    <input type="text"
                                           class="form-control select-item {{ $errors->has('end_at') ? ' has-error' : '' }}"
                                           id="end_date" autocomplete="off" name="end_at" value="{{ old('end_at') }}"
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
                        <div>
                            <label class="ml-3 mt-1 text-w-400" for="exampleForm2">Người duyệt*</label>
                            {{ Form::select('approver_id', $userManager, null, ['class' => 'form-control my-1 mr-1 browser-default custom-select md-form select-item']) }}
                            @if ($errors->has('approver_id'))
                                <div class="mt-1 ml-3">
                                    <span class="help-block text-danger">{{ $errors->first('approver_id') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal: Create absence form--}}
    @if (count($errors) > 0)
        <script>
            $(function () {
                $('#modal-form').modal('show');
            });
        </script>
    @endif
    @if(session()->has('day_off_success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã gửi đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif
    <script type="text/javascript">

        $(document).ready(function () {
            $('#start_date').datetimepicker({
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],


        });
            $('#end_date').datetimepicker({
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
            });
            $('#end_date,#start_date').on('change',function () {
                var start=$('#start_date').val();
                var end=$('#end_date').val();
                if (start =="" || end==""){
                    $('#errors_date').text('vui lòng chọn ngày bắt đầu và ngày kết thúc');
                    return;
                }

                if (start > end){
                    $('.btn-send').attr('disabled','disabled');
                    $('#errors_date').text('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.');
                }else{
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