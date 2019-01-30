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
                    <h1 class="white-text font-weight-light">{{DAY_OFF_TOTAL*2 - $availableDayLeft[1] - $availableDayLeft[0]}}</h1>
                    <p class="card-subtitle text-white-50">ngày khả dụng</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Tính từ năm trước</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-success">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">{{DAY_OFF_TOTAL - $availableDayLeft[0]}}</h1>
                    <p class="card-subtitle text-white-50">nghỉ luôn đi</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Cuối năm
                        reset</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-warning">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">{{$availableDayLeft[0]}}</h1>
                    <p class="card-subtitle text-white-50">ngày đã nghỉ</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Trong
                        năm {{date('Y')}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-danger">
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
        <button class="btn btn-primary dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            Hiển thị
        </button>

        <div class="dropdown-menu">
            <a class="dropdown-item {{$defaultApprove !== 1 && $defaultApprove !== 0 ? 'active' : ''}}"
               href="{{url()->current().'?page=1&per_page='.$defaultPerPage}}">
                <span class="d-flex">
                    <span class="green-red-circle mr-2"></span>
                    <span class="content">Tất cả</span>
                </span>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item {{$defaultApprove === 0 ? 'active' : ''}}"
               href="{{url()->current().'?page=1&per_page='.$defaultPerPage.'&approve=0'}}">
                <span class="d-flex">
                    <span class="red-circle mr-2"></span>
                    <span class="content">Chưa duyệt</span>
                </span>
            </a>
            <a class="dropdown-item {{$defaultApprove === 1 ? 'active' : ''}}"
               href="{{url()->current().'?page=1&per_page='.$defaultPerPage.'&approve=1'}}">
                <span class="d-flex">
                    <span class="green-circle mr-2"></span>
                    <span class="content">Đã duyệt</span>
                </span>
            </a>
        </div>
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
                        <td>{{$absence->number_off}} ngày</td>
                        <td>
                            @if ($absence->status == 1)
                                <div class="green-circle"></div>
                            @else
                                <div class="red-circle"></div>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-indigo btn-sm m-0" data-toggle="modal"
                                    onclick="dayoffDetail({{$absence}})"
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

    <!-- Modal: modalPoll -->
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
    <!-- Modal: modalPoll -->
@endsection

@push('eu-dayoff')
    <script>
        let header = document.getElementById('dayoff_heading');
        let title = document.getElementById('dayoff_title');
        let duration = document.getElementById('dayoff_duration');
        let totalOff = document.getElementById('dayoff_total');
        let reason = document.getElementById('dayoff_reason');
        let approveDate = document.getElementById('dayoff_approveDate');
        let approval = document.getElementById('dayoff_approval');
        let comment = document.getElementById('dayoff_comment');

        function clearData() {
            header.innerText = '';
            title.innerText = '';
            duration.innerText = '';
            totalOff.innerText = '';
            approveDate.innerText = '';
            reason.innerText = '';
            approval.innerText = '';
            comment.innerText = '';
        }

        function isLoading() {
            let modal = document.getElementById('detailAbsence');

            let innerSpinner = document.createElement('span');
            innerSpinner.innerText = 'loading...';
            innerSpinner.className = 'sr-only';
            let containerSpinner = document.createElement('div');
            containerSpinner.className = 'spinner-border text-primary';
            containerSpinner.id = 'dayoffModel_loading';
            containerSpinner.setAttribute('role', 'status');
            containerSpinner.appendChild(innerSpinner);

            modal.appendChild(containerSpinner);
        }

        function doneLoading() {
            let loadingIndicate = $('#dayoffModel_loading');
            loadingIndicate.fadeOut('fast', removeLoading)
        }

        function removeLoading() {
            $('#dayoffModel_loading').remove();
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

        function dateFormat(startAt, endAt) {
            return startAt + '<br> <small>tới</small> <br>' + endAt;
        }

        function approvedChecker(isApproved = false, approveMessage = 'Đã phê duyệt', notApproveMessage = 'Chưa phê duyệt') {
            if (isApproved) {
                return approveMessage;
            }
            return notApproveMessage;
        }

        function dayoffDetail(detailInfo) {
            clearData();
            header.innerHTML = detailInfo.start_at;
            header.appendChild(circleIndicate(detailInfo.status === 1));
            title.innerText = detailInfo.title;
            duration.innerHTML = dateFormat(detailInfo.start_at, detailInfo.end_at);
            totalOff.innerText = detailInfo.number_off + ' ngày';
            reason.innerText = detailInfo.reason;
            approveDate.innerText = approvedChecker(!!detailInfo.approver_at, detailInfo.approver_at);
            approval.innerText = approvedChecker(detailInfo.status === 1, detailInfo.approval.name);
            comment.innerText = approvedChecker(!!detailInfo.approve_comment, detailInfo.approve_comment, 'không có');
        }
    </script>
@endpush