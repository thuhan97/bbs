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
            <!-- END Search -->

        </div>
        <br/>
        <br/>
        <br/>
        <div class="box-body no-padding">

            @if (count($records) > 0)
                <div class="table-responsive list-records">
                    <table class="table table-hover table-bordered">
                        <colgroup>
                            <col style="width: 30px">
                            <col style="">
                            <col style="width: 180px">
                            <col style="width: 180px">
                            <col style="width: 180px">
                            <col style="width: 100px">
                            <col style="width: 70px">
                        </colgroup>
                        <thead>
                        <th style="width: 10px;">
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i>
                            </button>
                        </th>
                        <th>Lý do xin nghỉ</th>
                        <th>Nghỉ từ</th>
                        <th>Đến ngày</th>
                        <th>Ngày tạo</th>
                        <th>Đã duyệt</th>
                        <th style="width: 100px;">Chức năng</th>
                        </thead>
                        <tbody>
                        @foreach ($records as $record)

                            <?php
                            $editLink = route($baseResourceRoutesAlias . '.edit', $record->id);
                            $userLink = route($baseResourceRoutesAlias . '.user', $record->user_id);



                            $deleteLink = route($baseResourceRoutesAlias . '.destroy', $record->id);
                            $formId = 'formDeleteModel_' . $record->id;
                            ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}"
                                           class="square-blue chkDelete">
                                </td>
                                <td>{{ $record->title }}</td>
                                <td class="text-right">{{ $record->start_at }}</td>
                                <td class="text-right">{{ $record->end_at }}</td>
                                <td class="text-right">{{ $record->created_at }}</td>
                                @if ($record->status == 1)
                                    <td class="text-center"><span class="label label-info">Yes</span></td>
                                @else
                                    <td class="text-center"><span class="label label-warning">No</span></td>
                            @endif

                            <!-- we will also add show, edit, and delete buttons -->
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ $editLink }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm btnOpenerModalConfirmModelDelete"
                                           data-form-id="{{ $formId }}"><i class="fa fa-trash-o"></i></a>
                                    </div>

                                    <!-- Delete Record Form -->
                                    <form id="{{ $formId }}" action="{{ $deleteLink }}" method="POST"
                                          style="display: none;" class="hidden form-inline">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
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
            @if (count($records) > 0)
                @include('common.paginate', ['records' => $records])
            @endif

            <div class="col-md-3">
                <div class="box box-success z-depth-1">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thống kê nghỉ phép</h3>
                    </div>
                    <div class="box-body">
                        Năm {{date('Y')}}: Đã nghỉ nghỉ {{$totalDayOfff['countDayOffCurrenYear']}} ngày.
                        <br>
                        Năm {{(int)date('Y') - 1}}:  {{$totalDayOfff['countDayOffPreYear'] ? 'Đã nghỉ'.$totalDayOfff['countDayOffPreYear'].'/'.DAY_OFF_TOTAL : ''}}
                        <hr>
                        Số ngày nghỉ phép còn
                        lại: {{ $remainDayOff ? $remainDayOff->remain : 0 }}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
    </div>

    <!-- /.box -->


@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection