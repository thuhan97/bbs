{{-- Extends Layout --}}
@extends('layouts.admin.master')

<?php
$_pageTitle = (isset($addVarsForView['_pageTitle']) && !empty($addVarsForView['_pageTitle']) ? $addVarsForView['_pageTitle'] : ucwords($resourceTitle));
$_pageSubtitle = (isset($addVarsForView['_pageSubtitle']) && !empty($addVarsForView['_pageSubtitle']) ? $addVarsForView['_pageSubtitle'] : "Quản lý thành viên  " . str_singular($_pageTitle));
$_formFiles = isset($addVarsForView['formFiles']) ? $addVarsForView['formFiles'] : false;
$_listLink = route($resourceRoutesAlias . '.index');
$_createLink = route($resourceRoutesAlias . '.create');
$_updateLink = route($resourceRoutesAlias . '.edit', $record->id);
$_printLink = false;
$_printLink = false;
?>

@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias.'.show', $record->id) !!}
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
                      action="{{ URL::asset('/admin/teams/save-member') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$record->id}}">
                    <div class="box-header with-border">
                        <h3 class="box-title">Quản lý thành viên</h3>

                        <div class="box-tools">
                            <a href="{{ $_listLink }}" class="btn btn-sm btn-primary margin-r-5 margin-l-5">
                                <i class="fa fa-search"></i> <span>Danh sách</span>
                            </a>
                            <a href="{{ $_createLink }}" class="btn btn-sm btn-success margin-r-5 margin-l-5">
                                <i class="fa fa-plus"></i> <span>Thêm mới</span>
                            </a>
                            <button class="btn btn-sm btn-info margin-r-5 margin-l-5">
                                <i class="fa fa-save"></i> <span>Lưu</span>
                            </button>
                            @yield('more-buttons')
                        </div>
                    </div>

                    <div id="wrap" class="container">
                        <div class="row">
                            <div class="col-xs-5">
                                <select name="from[]" id="undo_redo" class="form-control" size="13" multiple="multiple">
                                @foreach($member_not_in_team as $member)
                                <option value="{{$member->id}}">{{$member->name}}</option>
                                @endforeach
                                </select>

                            </div>

                            <div class="col-xs-2">
                                <button type="button" id="undo_redo_undo" class="btn btn-primary btn-block">undo</button>
                                <button type="button" id="undo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                <button type="button" id="undo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                <button type="button" id="undo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                <button type="button" id="undo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                <button type="button" id="undo_redo_redo" class="btn btn-warning btn-block">redo</button>
                            </div>

                            @php
                                $members = $record->userteam;
                            @endphp
                            <div class="col-xs-5">
                                <option value="{{$record->user->id}}" disabled>{{$record->user->name}} (Trưởng nhóm)</option>
                                <select name="to[]" id="undo_redo_to" class="form-control" size="13" multiple="multiple">
                                @foreach($members as $member)
                                        @if($member->user->id !== $record->user->id)
                                            <option value="{{$member->user->id}}">{{$member->user->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-center margin-bottom margin-t-5">
                            <a href="#" class="btn btn-sm btn-default margin-r-5 margin-l-5" onclick="history.go(-1)">
                            <i class="fa fa-caret-left"></i> <span>Quay lại</span>
                            </a>
                            <button type="submit" class="btn btn-sm btn-info margin-r-5 margin-l-5">
                                <i class="fa fa-save"></i> <span>Lưu</span>
                            </button>

                            <a href="{{ $_listLink }}" class="btn btn-sm btn-default margin-r-5 margin-l-5">
                                <i class="fa fa-ban"></i> <span>Hủy</span>
                            </a>
                        </div>
                        {{--</div>--}}

                    </div>

                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>

    <!-- /.row -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection
