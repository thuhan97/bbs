@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off_approval') !!}
@endsection
@section('content')
    @if(!$isApproval)
        <h2>Bạn không có quyền truy cập chức năng này</h2>
    @else

        @php

            $atPageString = "?page=";
            $perPageString = "&per_page=";
            $approvalString = "&approve=";
            $defaultURL = route("day_off_approval");

            if ($approval_view == null){
                $approvalString = '';
            }else{
                $approvalString .= $approval_view;
            }

            if ($atPage_view == null){
                $atPageString .= '1';
            }else{
                $atPageString .= $atPage_view;
            }

            if ($perPage_view == null){
                $perPageString .= 10;
            }else{
                $perPageString .= $perPage_view;
            }

        @endphp

        <div class="container-fluid col-12 row"  style="position: relative;">
            <div class="col-sm-3 col-xs-6 position-relative">
                <a href="{{$defaultURL . $atPageString . $perPageString}}" class="card bg-warning">
                    <div class="card-body">
                        <h1 class="white-text font-weight-light">{{$totalRequest['total']}}</h1>
                        <p class="card-subtitle text-white-50">Đơn xin nghỉ</p>
                        <p class="card-title text-uppercase font-weight-bold card-text white-text">Trong
                            năm {{date('Y')}}</p>
                    </div>
                </a>
            </div>
            <div class="col-sm-3 col-xs-6  position-relative">
                <a href="{{$defaultURL . $atPageString . $perPageString .'&approve=0'}}" class="card bg-primary">
                    <div class="card-body">
                        <h1 class="white-text font-weight-light">{{$totalRequest['total'] - $approvedRequest['total']}}</h1>
                        <p class="card-subtitle text-white-50">Đơn xin nghỉ</p>
                        <p class="card-title text-uppercase font-weight-bold card-text white-text">Chờ duyệt</p>
                    </div>
                </a>
            </div>
            <div class="col-sm-3 col-xs-6 position-relative">
                <a href="{{$defaultURL . $atPageString . $perPageString .'&approve=1'}}" class="card bg-success">
                    <div class="card-body">
                        <h1 class="white-text font-weight-light">{{$approvedRequest['total']}}</h1>
                        <p class="card-subtitle text-white-50">Đơn xin nghỉ</p>
                        <p class="card-title text-uppercase font-weight-bold card-text white-text">
                            Đã giải quyết
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <hr>
        <br>
        <div class="container-fluid row">
            <div class="col-sm-6 col-xs-12 row">
                <h3 class="align-self-center mb-0">
                    @if($approval_view != 1 && $approval_view != 0)
                        Tất cả các đơn
                    @elseif($approval_view == 1)
                        Các đơn đã giải quyết
                    @elseif($approval_view == 0)
                        Các đơn chờ giải quyết
                    @endif
                </h3>
                <small class="ml-4 align-self-center text-muted">Nhấn ô bên trên để lọc</small>
            </div>
            <form class="col-sm-6 col-xs-6" method="get"
                  action="{{$defaultURL . $atPageString . $perPageString . $approvalString}}">
                <div class="input-group col-12">
                    <input type="text" class="form-control" placeholder="Tìm tên nhân viên"
                           value="{{!!$searchView ? $searchView : ''}}"
                           name="search"
                           aria-label="Tìm kiếm nhân viên"
                           aria-describedby="btnSearch">
                    <div class="input-group-append">
                        <button class="btn btn-md btn-default m-0 py-2 z-depth-0 waves-effect" type="submit"
                                id="btnSearch">
                            Tìm
                        </button>
                    </div>
                </div>
                <input type="hidden" name="per_page" value="{{$perPage_view}}">
                <input type="hidden" name="page" value="{{$atPage_view}}">
                @if($approvalString !== '')
                    <input type="hidden" name="approve" value="{{$approval_view}}">
                @endif
                @csrf
            </form>
        </div>
        <br>
        <div class="container-fluid d-flex flex-column">
            <!--Table-->
            <table id="tablePreview" class="table table-striped table-hover">
                <!--Table head-->
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Nhân viên</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Từ ngày</th>
                    <th class="text-center">Tới ngày</th>
                    <th class="text-center">Tính nghỉ</th>
                    <th class="text-center">Tiêu đề</th>
                    <th style="width: 250px" class="text-center">Chi tiết</th>
                </tr>
                </thead>
                <!--Table head-->
                <!--Table body-->
                <tbody>
                @foreach($request_view as $record)
                    <tr id="rowApprove{{$loop->index+1}}">
                        <th scope="row" class="text-center">
                            {{$loop->index + 1}}
                        </th>
                        <td class="text-center"
                            style="width: 210px; white-space: nowrap; overflow: hidden;-ms-text-overflow: ellipsis;text-overflow: ellipsis;">
                            {{$record->user->name}}
                        </td>
                        <td class="text-center">
                            @if ($record->status == 1)
                                <div class="green-circle m-auto"></div>
                            @else
                                <div class="red-circle m-auto"></div>
                            @endif
                        </td>
                        <td class="text-center">
                            {{$record->start_at}}
                        </td>
                        <td class="text-center">
                            {{$record->end_at}}
                        </td>
                        <td class="text-center">
                            {{$record->number_off == null ? 'Chưa rõ' : $record->number_off}} ngày
                        </td>
                        <td class="text-center"
                            style="width: 200px; white-space: nowrap; overflow: hidden;-ms-text-overflow: ellipsis;text-overflow: ellipsis;">
                            {{$record->title}}
                        </td>
                        <td class="text-center p-0">
                            @if($record->status !== 1)
                                <button class="btn btn-primary btn-sm"
                                        onclick="clickApprove({{$record}}, 'rowApprove'+{{$loop->index+1}} , 'spinner-section-'+{{$loop->index+1}}, {{$approval_view}})"><i
                                            class="fas fa-check"></i></button>
                            @endif
                            <button class="btn btn-blue-grey btn-sm">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div id="spinner-section-{{$loop->index+1}}"
                                 style="position: absolute;top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;
                                 display: none; justify-content: center; align-items: center; background: rgba(0,0,0,0.08);">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <!--Table body-->
            </table>
            <!--Table-->
            @if($request_view_array['last_page'] > 1)
                {{--Pagination--}}
                <div class="container-fluid d-flex flex-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pg-blue">
                            <li class="page-item {{$request_view_array['current_page'] === 1 ? 'disabled': ''}}">
                                <a href="{{$request_view_array['first_page_url'].$perPageString. $approvalString}}"
                                   class="page-link">Trang đầu</a>
                            </li>
                            <li class="page-item {{$request_view_array['current_page'] === 1 ? 'disabled': ''}}">
                                <a href="{{$request_view_array['prev_page_url'].$perPageString. $approvalString}}"
                                   class="page-link" tabindex="-1">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>

                            @if ($request_view_array['current_page'] - 4 > 0)
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] - 4) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        ...
                                    </a>
                                </li>
                            @endif

                            @if ($request_view_array['current_page'] - 3 > 0)
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] - 3) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        {{$request_view_array['current_page'] - 3}}
                                    </a>
                                </li>
                            @endif

                            @if ($request_view_array['current_page'] - 2 > 0)
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] - 2) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        {{$request_view_array['current_page'] - 2}}
                                    </a>
                                </li>
                            @endif

                            @if($request_view_array['current_page'] - 1 > 0)
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] - 1) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        {{$request_view_array['current_page'] - 1}}
                                    </a>
                                </li>
                            @endif

                            <li class="page-item active">
                                <a class="page-link">
                                    {{$request_view_array['current_page']}}
                                    <span class="sr-only">
                                (current)
                            </span>
                                </a>
                            </li>

                            @if($request_view_array['current_page'] + 1 <= $request_view_array['last_page'])
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] + 1) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        {{$request_view_array['current_page'] + 1}}
                                    </a>
                                </li>
                            @endif

                            @if($request_view_array['current_page'] + 2 <= $request_view_array['last_page'])
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] + 2) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        {{$request_view_array['current_page'] + 2}}
                                    </a>
                                </li>
                            @endif

                            @if($request_view_array['current_page'] + 3 <= $request_view_array['last_page'])
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] + 3) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        {{$request_view_array['current_page'] + 3}}
                                    </a>
                                </li>
                            @endif

                            @if($request_view_array['current_page'] + 4 <= $request_view_array['last_page'])
                                <li class="page-item">
                                    <a href="{{$defaultURL. '?page='.($request_view_array['current_page'] + 4) . $perPageString . $approvalString}}"
                                       class="page-link">
                                        ...
                                    </a>
                                </li>
                            @endif


                            <li class="page-item {{$request_view_array['current_page'] === $request_view_array['last_page'] ? 'disabled': ''}}">
                                <a href="{{$request_view_array['next_page_url'].$perPageString. $approvalString}}"
                                   class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                            <li class="page-item {{$request_view_array['current_page'] === $request_view_array['last_page'] ? 'disabled': ''}}">
                                <a href="{{$request_view_array['last_page_url'].$perPageString. $approvalString}} "
                                   class="page-link">Trang cuối</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
            <script>
                function clickApprove(dataApprove = null, rowID, idSpinner, approvalStatus) {
                    if (!!!dataApprove || approvalStatus === 1 || (approvalStatus !== null && approvalStatus !== 2)) {
                        return;
                    }

                    startSpinner(idSpinner);

                    let sendingData = JSON.stringify(dataApprove);
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            resolveResponse(this.response, rowID, idSpinner, approvalStatus);
                        }
                    };
                    xhttp.open("POST", "{{route('day_off_approval_approveAPI')}}", true);

                    xhttp.setRequestHeader("Content-type", "application/json");
                    xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                    xhttp.send(sendingData);
                }

                function resolveResponse(res, rowID, spinnerID, approvalStatus) {
                    let convertStatus = false;
                    let obj = null;
                    try {
                        obj = JSON.parse(res);
                        if (obj.hasOwnProperty('success') && obj.hasOwnProperty('message')) {
                            convertStatus = true;
                        }
                    } catch (e) {
                        convertStatus = false;
                    }
                    if (convertStatus) {
                        // received correct form data.
                        console.log(obj);
                        let rmRow = document.getElementById(rowID);
                        if (approvalStatus === 2){
                            location.reload(true);
                        }else if (approvalStatus === null) {

                        }
                        if (!!rmRow) {
                            rmRow.parentElement.removeChild(rmRow);
                        }
                    }
                    finishSpinner(spinnerID);
                }

                function startSpinner(spinnerID) {
                    let sectionAdding = document.getElementById(spinnerID);
                    if (!!!sectionAdding) {
                        return;
                    }
                    // let containerSpinner = document.createElement('div');
                    // containerSpinner.id = 'loading-' + spinnerID;
                    // containerSpinner.className = 'spinner-border text-primary';
                    // containerSpinner.setAttribute('role', 'status');
                    // let spinnerInner = document.createElement('span');
                    // spinnerInner.className = 'sr-only';
                    // spinnerInner.innerText = 'Loading...';
                    // containerSpinner.appendChild(spinnerInner);
                    // sectionAdding.appendChild(containerSpinner);
                    sectionAdding.style.display = 'flex';
                }

                function finishSpinner(spinnerID) {
                    let sectionAdding = document.getElementById(spinnerID);
                    if (!!!sectionAdding) {
                        return;
                    }
                    sectionAdding.style.display = 'none';
                }
            </script>
        </div>
    @endif
@endsection