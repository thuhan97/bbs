<?php
$postCount = \App\Models\Post::count();
$projectCount = \App\Models\Project::count();
$userCount = \App\Models\User::count();
$regulationCount = \App\Models\Regulation::count();

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
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Monthly Recap Report</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center">
                                <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                            </p>

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" style="height: 180px; width: 703px;" width="703"
                                        height="180"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong>Goal Completion</strong>
                            </p>

                            <div class="progress-group">
                                <span class="progress-text">Add Products to Cart</span>
                                <span class="progress-number"><b>160</b>/200</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Complete Purchase</span>
                                <span class="progress-number"><b>310</b>/400</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Visit Premium Page</span>
                                <span class="progress-number"><b>480</b>/800</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Send Inquiries</span>
                                <span class="progress-number"><b>250</b>/500</span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-green"><i
                                            class="fa fa-caret-up"></i> 17%</span>
                                <h5 class="description-header">$35,210.43</h5>
                                <span class="description-text">TOTAL REVENUE</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-yellow"><i
                                            class="fa fa-caret-left"></i> 0%</span>
                                <h5 class="description-header">$10,390.90</h5>
                                <span class="description-text">TOTAL COST</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-green"><i
                                            class="fa fa-caret-up"></i> 20%</span>
                                <h5 class="description-header">$24,813.53</h5>
                                <span class="description-text">TOTAL PROFIT</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block">
                                <span class="description-percentage text-red"><i
                                            class="fa fa-caret-down"></i> 18%</span>
                                <h5 class="description-header">1200</h5>
                                <span class="description-text">GOAL COMPLETIONS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
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
                                <li><i class="fa fa-circle-o text-red"></i> Biệt đội bình tĩnh</li>
                                <li><i class="fa fa-circle-o text-green"></i> Apple</li>
                                <li><i class="fa fa-circle-o text-yellow"></i> Banana</li>
                                <li><i class="fa fa-circle-o text-aqua"></i> Warrior</li>
                                <li><i class="fa fa-circle-o text-light-blue"></i> Badboy</li>
                                <li><i class="fa fa-circle-o text-gray"></i> HCNS</li>
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
    <script src="{{cdn_asset('/js/libs/chart.js')}}"></script>
    <script src="{{cdn_asset('/js/admin/dashboard.js')}}"></script>
@endpush
