@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('report_create') !!}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">[Tuần {{$report->week_num . '/' . $report->year}}] {{$report->user->name}}</div>
        <div class="card-body">
            <h5 class="card-title mb-5">{{$report->title}}</h5>
            <div class="card-text mb-3">
                <p>To: <span class="txtTo">{{$report->to_ids}}</span></p>
                <p class="content">
                    {!! $report->content !!}
                </p>
            </div>

        </div>

        <div class="card-footer">
            Ngày tạo: <i> {{$report->created_at}}</i><br/>
            Ngày cập nhật cuối: <i>{{$report->updated_at}} </i><br/>
        </div>
    </div>
@endsection
