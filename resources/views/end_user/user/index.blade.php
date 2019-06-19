@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('link') !!}
@endsection
@section('content')
    <div class="row mt-3">
        <div class="col-xl-2 col-md-3 col-6 fix-with-detail ">
            <a class="text-body" href="{{ route('work_time') }}">
                <div class="m-auto fixed-with-size"
                     style="background-image: url({{ URL::asset("img/icon/time.png") }}); ">
                </div>
                <p class="text-center mt-2">Giờ làm việc</p>
            </a>
        </div>
        <div class="col-xl-2 col-md-3 col-6 fix-with-detail">
            <a class="text-body" href="{{ route('day_off') }}">

                <div class="m-auto fixed-with-size"
                     style="background-image: url({{ URL::asset("img/icon/day_offs.png") }});">
                </div>
                <p class="text-center mt-2">Xin nghỉ</p>
            </a>

        </div>
        <div class="col-xl-2 col-md-3 col-6 fix-with-detail">
            <a class="text-body" href="{{ route('ask_permission') }}">

                <div class="m-auto fixed-with-size"
                     style="background-image: url({{ URL::asset("img/icon/ask-permission.png") }});">
                </div>
                <p class="text-center mt-2">Xin phép</p>
            </a>

        </div>

        <div class="col-xl-2 col-md-3 col-6  fix-with-detail">
            <a class="text-body" href="{{ route('punish') }}">
                <div class="m-auto fixed-with-size"
                     style="background-image: url({{ URL::asset("img/icon/punish.png") }});">
                </div>
                <p class="text-center mt-2">Tiền phạt</p>
            </a>

        </div>
        <div class="col-xl-2 col-md-3 col-6 fix-with-detail">
            <a class="text-body" href="{{ route('report') }}">
                <div class="m-auto fixed-with-size"
                     style="background-image: url({{ URL::asset("img/icon/report.png") }}); ">

                </div>
                <p class="text-center mt-2">Báo cáo công việc</p>
            </a>
        </div>
    </div>

@endsection
