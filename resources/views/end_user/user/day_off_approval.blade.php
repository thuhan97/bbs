@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off_approval') !!}
@endsection
@section('content')
    @if(!$isApproval)
        <h2>Bạn không có quyền truy cập chức năng này</h2>
    @else
        <div class="container-fluid col-12 row">
            <div class="col-sm-3 col-xs-6">
                <div class="card bg-warning">
                    <div class="card-body">
                        <h1 class="white-text font-weight-light">{{$totalRequest['total']}}</h1>
                        <p class="card-subtitle text-white-50">Đơn xin nghỉ</p>
                        <p class="card-title text-uppercase font-weight-bold card-text white-text">Trong
                            năm {{date('Y')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="card bg-primary">
                    <div class="card-body">
                        <h1 class="white-text font-weight-light">{{$totalRequest['total'] - $approvedRequest['total']}}</h1>
                        <p class="card-subtitle text-white-50">Đơn xin nghỉ</p>
                        <p class="card-title text-uppercase font-weight-bold card-text white-text">Chờ duyệt</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="card bg-success">
                    <div class="card-body">
                        <h1 class="white-text font-weight-light">{{$approvedRequest['total']}}</h1>
                        <p class="card-subtitle text-white-50">Đơn xin nghỉ</p>
                        <p class="card-title text-uppercase font-weight-bold card-text white-text">
                            Đã giải quyết
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    @endif
@endsection