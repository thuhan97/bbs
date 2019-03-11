{{-- Extends Layout --}}
@extends('layouts.admin.master')

<?php
        // check record exist
//if (!$record) {
//    $record = collect($record);
//    $record->id = request()->route(request()->route()->parameterNames[0]);
//    $record->isNull = true;
//}
$_pageTitle = (isset($addVarsForView['_pageTitle']) && !empty($addVarsForView['_pageTitle']) ? $addVarsForView['_pageTitle'] : ucwords($resourceTitle));
$_pageSubtitle = (isset($addVarsForView['_pageSubtitle']) && !empty($addVarsForView['_pageSubtitle']) ? $addVarsForView['_pageSubtitle'] : "Sửa thông tin " . str_singular($_pageTitle));
$_formFiles = isset($addVarsForView['formFiles']) ? $addVarsForView['formFiles'] : false;
$_listLink = route($resourceRoutesAlias . '.index');
$_createLink = route($resourceRoutesAlias . '.create');

$_updateLink = route($resourceRoutesAlias . '.update', $record->id);
$_printLink = false;
?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias.'.edit', $record->id) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Page Subtitle --}}
@section('page-subtitle', $_pageSubtitle)

{{-- Header Extras to be Included --}}
@section('head-extras')

@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <!-- Edit Form -->
            <div class="box box-info" id="wrap-edit-box">

                <form class="form" role="form" method="POST"
                      action="{{ $_updateLink }}"
                      enctype="multipart/form-data"{{ $_formFiles === true ? 'enctype="multipart/form-data"' : ''}}>
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="box-header with-border">
                        {{--@if(!$record->isNull)--}}
                            <h3 class="box-title">Sửa thông tin: {{ $record->getRecordTitle() }}</h3>
                        {{--@else--}}
                            {{--<h3 class="box-title">{{ $addVarsForView['edit_title'] }}: {{ $addVarsForView['edit_target'] }}</h3>--}}
                        {{--@endif--}}

                        <div class="box-tools">
                            {{--<a href="#" class="btn btn-sm btn-default margin-r-5 margin-l-5" onclick="history.go(-1)">--}}
                            {{--<i class="fa fa-caret-left"></i> <span>Back</span>--}}
                            {{--</a>--}}
                            <a href="{{ $_listLink }}" class="btn btn-sm btn-primary margin-r-5 margin-l-5">
                                <i class="fa fa-search"></i> <span>Danh sách</span>
                            </a>
                            <a href="{{ $_createLink }}" class="btn btn-sm btn-success margin-r-5 margin-l-5">
                                <i class="fa fa-plus"></i> <span>Thêm mới</span>
                            </a>
                            @if ($_printLink)
                                <a href="{{ $_printLink }}" target="_blank"
                                   class="btn btn-sm btn-default margin-r-5 margin-l-5">
                                    <i class="fa fa-print"></i> <span>Print</span>
                                </a>
                            @endif
                            <button class="btn btn-sm btn-info margin-r-5 margin-l-5">
                                <i class="fa fa-save"></i> <span>Lưu</span>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        @include($resourceAlias.'.form')
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <!-- Edit Button -->
                        <div class="col-xs-6">
                            <div class="text-center margin-b-5 margin-t-5">
                                <button class="btn btn-info">
                                    <i class="fa fa-save"></i> <span>Lưu</span>
                                </button>
                            </div>
                        </div>
                        <!-- /.col-xs-6 -->
                        <div class="col-xs-6">
                            <div class="text-center margin-b-5 margin-t-5">
                                <a href="{{ $_listLink }}" class="btn btn-default">
                                    <i class="fa fa-ban"></i> <span>Hủy</span>
                                </a>
                            </div>
                        </div>
                        <!-- /.col-xs-6 -->
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
            <!-- /End Edit Form -->
        </div>
    </div>
    <!-- /.row -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection
