<?php
$postCount = \App\Models\Post::count();
$projectCount = \App\Models\Project::count();
$userCount = \App\Models\User::count();
$regulationCount = \App\Models\Regulation::count();
$teams = \App\Models\Team::select('id', 'name', 'color')->withCount('members')->get();
?>

@extends('layouts.admin.master')
@section('page-title', 'Admin page')
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin::admins') !!}
@endsection
@section('content')
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{number_collapse($userCount)}}</h3>

                    <p>Nhân viên</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="/admin/users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{number_collapse($postCount)}}</h3>

                    <p>Thông báo</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bell"></i>
                </div>
                <a href="/admin/topics" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ number_collapse($projectCount) }}</h3>

                    <p>Dự án</p>
                </div>
                <div class="icon">
                    <i class="fa fa-anchor"></i>
                </div>
                <a href="/admin/questions" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{number_collapse($regulationCount)}}</h3>

                    <p>Nội quy/quy định</p>
                </div>
                <div class="icon">
                    <i class="fa fa-quote-right"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-md-4">
            <!-- USERS LIST -->
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Nhân viên thử việc</h3>

                    <div class="box-tools pull-right">
                        <span class="label label-danger">{{$probationStaffs->count()}} nhân viên</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    @if($probationStaffs->isNotEmpty())
                        <ul class="users-list clearfix">
                            @foreach($probationStaffs as $probationStaff)
                                <li>
                                    <img src="{{$probationStaff->avatar}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'"
                                         alt="{{$probationStaff->name}}">
                                    <a class="users-list-name" href="#">{{$probationStaff->name}}</a>
                                    <span class="users-list-date">{{$probationStaff->probation_at}}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <h4 class="col-md-12">Không có nhân viên thử việc</h4>
                @endif
                <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="/admin/users" class="uppercase">Xem tất cả nhân viên</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Teams</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChart" height="155" width="205"
                                        style="width: 205px; height: 155px;"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                @foreach($teams as $team)
                                    <li>
                                        <i class="fa fa-circle-o" style="color: {{$team->color}}"></i> {{$team->name}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach(CONTRACT_TYPES_NAME as $type => $typeName)
                            <li>
                                <a href="#">{{$typeName}}
                                    <span class="pull-right"> {{\App\Models\User::where('contract_type', $type)->count()}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.footer -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sự kiện</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach($events as $event)
                            <li class="item">
                                <div class="product-img">
                                    <img src="{{lfm_thumbnail($event->image_url)}}"
                                         alt="{{$event->name}}">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)"
                                       class="product-title">{{$event->name}}
                                        <span class="label label-warning pull-right">{{$event->event_date}}</span></a>
                                    <span class="product-description">
                          {{$event->introduction}}
                        </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="{{route('admin::events.index')}}" class="uppercase">Xem tất cả sự kiện</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        window.PieData = [
                @foreach($teams as $team)
            {
                value: '{{$team->members_count}}',
                color: '{{$team->color}}',
                highlight: '{{$team->color}}',
                label: '{{$team->name}}'
            },
            @endforeach
        ];

    </script>
    <script src="{{cdn_asset('/js/libs/chart.js')}}"></script>
    <script src="{{cdn_asset('/js/admin/dashboard.js')}}"></script>
@endpush
