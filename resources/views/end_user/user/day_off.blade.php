@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off') !!}
@endsection
@section('content')
    {{--<i class="fas fa-camera-retro"></i> fa-camera-retro--}}

    <div class="container-fluid col-12 row">
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">999</h1>
                    <p class="card-subtitle text-white-50">ngày</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Số ngày nghỉ</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-success">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">999</h1>
                    <p class="card-subtitle text-white-50">ngày</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Có phép</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-warning">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">999</h1>
                    <p class="card-subtitle text-white-50">ngày</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Khả dụng</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid col-12 flex-row-reverse d-flex">
        <button class="btn btn-primary dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">Hiển thị
        </button>

        <div class="dropdown-menu">
            <a class="dropdown-item">
                <span class="d-flex">
                    <span class="green-red-circle mr-2"></span>
                    <span class="content">Tất cả</span>
                </span>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
                <span class="d-flex">
                    <span class="red-circle mr-2"></span>
                    <span class="content">Chưa duyệt</span>
                </span>
            </a>
            <a class="dropdown-item" href="#">
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
            @foreach ($listDate as $absence)
                <tr>
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
                                data-target="{{'#detailAbsence'.($loop->index+1)}}">Chi tiết
                        </button>
                        <!-- Modal: modalPoll -->
                        <div class="modal fade right" id="{{'detailAbsence'.($loop->index+1)}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true" data-backdrop="false">
                            <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
                                <div class="modal-content">
                                    <!--Header-->
                                    <div class="modal-header">
                                        <p class="heading lead d-flex flex-row">
                                            {{$absence->start_at}}
                                            @if ($absence->status == 1)
                                                <span class="green-circle ml-2"></span>
                                            @else
                                                <span class="red-circle ml-2"></span>
                                            @endif
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
                                                <strong>{{$absence->title}}</strong>
                                            </p>
                                            <br>
                                            <h4 class="text-bold">Ngày nghỉ:</h4>
                                            <p>
                                                <strong>{{$absence->start_at}} - {{$absence->end_at}}</strong>
                                            </p>
                                            <br>
                                            <h4 class="text-bold">Thời gian được tính:</h4>
                                            <p>
                                                <strong>{{$absence->number_off}} ngày</strong>
                                            </p>
                                        </div>
                                        <hr>
                                        <div class="text-left">
                                            <h4 class="text-bold">Chi tiết lý do:</h4>
                                            <p>
                                                {{$absence->reason}}
                                            </p>
                                            <br>
                                            <h4 class="text-bold">Ngày duyệt:</h4>
                                            <p>{{$absence->approver_at == null ? 'Chưa phê duyệt' : $absence->approver_at}}</p>
                                            <br>
                                            <h4 class="text-bold">Người duyệt:</h4>
                                            <p>Admin</p>
                                            <br>
                                            <h4 class="text-bold important">Ý kiến</h4>
                                            <p>
                                                {{$absence->approve_comment == null ? 'Không có' : $absence->approve_comment}}
                                            </p>
                                        </div>
                                    </div>

                                    <!--Footer-->
                                    <div class="modal-footer justify-content-center">
                                        <a type="button" class="btn btn-primary waves-effect waves-light">Báo cáo
                                            <i class="fa fa-paper-plane ml-1"></i>
                                        </a>
                                        <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal: modalPoll -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection