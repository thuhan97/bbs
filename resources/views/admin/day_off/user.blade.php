@extends('layouts.admin.master')

<?php
$baseResourceRoutesAlias = 'admin::day_offs';
$resourceRoutesAlias = $baseResourceRoutesAlias . '.user';
$_pageTitle = 'Quản lý nghỉ phép';
$_pageSubtitle = 'Ngày nghỉ của ' . $user->name;
$_createLink = route($baseResourceRoutesAlias . '.create', ['user_id' => $user->id]);
?>
{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias, $user) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Page Subtitle --}}
@section('page-subtitle', $_pageSubtitle)

{{-- Header Extras to be Included --}}
@section('head-extras')

@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $_pageSubtitle }}</h3>
            <!-- Search -->
            <div class="box-tools pull-right">
                <form class="form" role="form" method="GET" action="{{ route($resourceRoutesAlias, $user->id) }}">
                    <div class="input-group input-group-sm margin-r-5 pull-left" style="width: 400px;">

                        {{ Form::select('year', get_years(), $year, ['class'=>'mr-2 w-45 form-control']) }}
                        {{ Form::select('month', get_months(), $month, ['class'=>'w-45 form-control']) }}

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right">
                        <i class="fa fa-plus"></i> <span>Thêm mới</span>
                    </a>
                </form>

            </div>
            <br/>
            <br/>
            <br/>
            <div class="col-md-3">
                <div class="box-header with-border">
                    <h2 class="box-title"><b>Thống kê nghỉ phép</b></h2>
                </div>
                <div class="box-body">
                   <b> Năm {{date('Y')}}:</b> Đã nghỉ {{$totalDayOfff['countDayOffCurrenYear']}} ngày.
                    <br>
                    <b>Năm {{(int)date('Y') - 1}}: </b> {{$totalDayOfff['countDayOffPreYear'] ? 'Đã nghỉ'.$totalDayOfff['countDayOffPreYear'].'/'.DAY_OFF_TOTAL : 0}}
                    <hr>
                    <b>Số ngày nghỉ phép còn lại : </b>
                     {{ $totalRemainDayOff }}
                </div>
                <!-- /.box-body -->
                <div class="box box-success z-depth-1">
                </div>
            </div>
            <!-- END Search -->

        </div>
        <br/>
        <br/>
        <br/>

        <div class="box-body no-padding">
            @if (count($numberThisYearAndLastYear['data']) > 0)
                <div class="table-responsive list-records">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <th class="text-center">Lý do xin nghỉ</th>
                        <th class="text-center">Nghỉ từ</th>
                        <th class="text-center">Đến ngày</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center">Ngày được tính</th>
                        <th class="text-center">Đã duyệt</th>
                        <th class="text-center">Chức năng</th>
                        </thead>
                        <tbody>
                        @foreach ($numberThisYearAndLastYear['data'] as $record)

                            <?php
                            $editLink = route($baseResourceRoutesAlias . '.edit', $record->id);
                            $userLink = route($baseResourceRoutesAlias . '.user', $record->user_id);



                            $deleteLink = route($baseResourceRoutesAlias . '.destroy', $record->id);
                            $formId = 'formDeleteModel_' . $record->id;
                            ?>
                            <tr>
                                <td class="text-center">{{ $record->reason }}</td>
                                <td class="text-center">{{ $record->start_at }}</td>
                                <td class="text-center">{{ $record->end_at }}</td>
                                <td class="text-center">{{ $record->created_at }}</td>
                                <td class="text-center">{{!!!$record->number_off ? 'Đang duyệt' : checkNumber($record->number_off).' ngày'}}</td>
                                <td class="text-center">
                                    @if($record->status == STATUS_DAY_OFF['abide'])
                                        <span class="label label-warning">No</span>
                                    @elseif($record->status == STATUS_DAY_OFF['active'])
                                        <span class="label label-info">Yes</span>
                                    @else
                                        <span class="label label-danger">close</span>
                                    @endif
                                </td>

                            <!-- we will also add show, edit, and delete buttons -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ $editLink }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="margin-l-5 lead text-green">Không có ngày nghỉ phép.</p>
            @endif
        <!-- /.box-body -->
                @if (count($numberThisYearAndLastYear['data']) > 0)
                @include('common.paginate', ['records' => $numberThisYearAndLastYear['data']])
                    @endif
        </div>
    </div>

    <!-- /.box -->


@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection