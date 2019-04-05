{{-- Extends Layout --}}
@extends('layouts.admin.master')

<?php

?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin::configs') !!}
@endsection

{{-- Page Title --}}
@section('page-title', 'Sự kiện')

{{-- Page Subtitle --}}
@section('page-subtitle', 'Chi tiết sự kiện')

{{-- Header Extras to be Included --}}
@section('head-extras')

@endsection

@section('content')

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Tên sự kiện: {{ $record->name }}
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-xs-6">
                <p class="lead">Chi tiết sự kiện: </p>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:50%">Ngày gửi thông báo :</th>
                            <td>{{  date("d/m/Y", strtotime($record->event_date)) }}</td>
                        </tr>
                        <tr>
                            <th style="width:50%">Ngày hết hạn đăng kí :</th>
                            <td>{{  date("d/m/Y", strtotime($record->event_end_date)) }}</td>
                        </tr>
                        <tr>
                            <th style="width:50%">Ngày gửi thông báo :</th>
                            <td>{{  date("d/m/Y", strtotime($record->event_end_date)) }}</td>
                        </tr>
                        <tr>
                            <th style="width:50%">Ngày hết hạn đăng kí :</th>
                            <td>{{  date("d/m/Y", strtotime($record->deadline_at)) }}</td>
                        </tr>
                        <tr>
                            <th style="width:50%">Địa điểm :</th>
                            <td>{{$record->place}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-6">
                <img id="thumbnail" style="margin-top:15px" src="{{$record->image_url}}">
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <p class="lead">Tóm tắt: </p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    {{ $record->introduction }}
                </p>

                <p class="lead">Nội dung chi tiết: </p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    {{ $record->content }}
                </p>
            </div>

        </div>


        <!-- /.row -->


        <!-- Table row -->
        <div class="row">
            <p class="lead">Danh sách thành viên tham dự: </p>
            <div class="col-xs-12 table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <th>Tên thành viên</th>
                    <th>Mã thành viên</th>
                    <th>Trạng thái</th>
                    <th>Ý kiến cá nhân</th>
                    <th>Ngày đăng kí</th>
                    </thead>
                    <tbody>
                    @if (count($listUserJoinEvent) > 0)
                        @foreach ($listUserJoinEvent as $listUserJoinEventValue)
                            <tr>
                                <td>{{ $listUserJoinEventValue->name }}</td>
                                <td>{{ $listUserJoinEventValue->staff_code }}</td>
                                <td>{{ $listUserJoinEventValue->status == 1 ? STATUS_JOIN_EVENT[1] : STATUS_JOIN_EVENT[0] }}</td>
                                <td>{{ $listUserJoinEventValue->content}}</td>
                                <td>{{ $listUserJoinEventValue->created_at }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="{{ route("admin::events.dowloadExcelListUserJoin",['id'=>$record->id]) }}"
                   class="btn btn-success pull-right"><i
                            class="fa fa-download"></i> Export excel</a>
            </div>
        </div>
    </section>
    @push('footer-scripts')
        <script>

            $(function () {
                myFilemanager($('#lfm'), 'image');
                myEditor($("#content"));
                myDatePicker($("#event_date, #event_end_date, #notify_date, #deadline_at"));
            })
        </script>
    @endpush

@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection
