{{-- Extends Layout --}}
@extends('layouts.admin.master')

<?php

$_pageTitle = (isset($addVarsForView['_pageTitle']) && !empty($addVarsForView['_pageTitle']) ? $addVarsForView['_pageTitle'] : ($resourceTitle));
$_pageSubtitle = (isset($addVarsForView['_pageSubtitle']) && !empty($addVarsForView['_pageSubtitle']) ? $addVarsForView['_pageSubtitle'] : 'Danh sách');
$_listLink = route($resourceRoutesAlias . '.index');
$_createLink = route($resourceRoutesAlias . '.create');
$_mutipleDeleteLink = route($resourceRoutesAlias . '.deletes');

$tableCounter = 0;
$total = 0;
if (count($records) > 0) {
    if ($records[0]->total) {
        foreach ($records as $record) {
            $total += $record->total;
        }
    } else {
        $total = $records->total();
        $tableCounter = ($records->currentPage() - 1) * $records->perPage();
        $tableCounter = $tableCounter > 0 ? $tableCounter : 0;
    }
}
?>
{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Page Subtitle --}}
@section('page-subtitle', $_pageSubtitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
    @parent
@endsection

@section('content')

    <!-- Default box -->
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $_pageSubtitle }}</h3>
            <!-- Search -->
            <div class="box-tools pull-right">
                <form id="searchForm" class="form" role="form" method="GET" action="{{ $_listLink }}">
                    @if( isset($resourceSearchExtend))
                        @include($resourceSearchExtend, ['search' => $search, '$createLink' => $_createLink])
                    @else
                        <div class="input-group input-group-sm margin-r-5 pull-left" style="width: 200px;">
                            <input type="text" name="search" class="form-control" value="{{ $search }}"
                                   placeholder="Search...">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right toggle-create">
                            <i class="fa fa-plus"></i> <span>Thêm mới</span>
                        </a>
                    @endif
                </form>

            </div>
            <!-- END Search -->

        </div>

        <div class="box-body no-padding">
            @if (count($records) > 0)
                <div class="padding-5">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="#" class="btn btn-sm btn-danger" id="btnDeleteMutiple">

                                <i class="fa fa-close"></i> <span>Xóa bản ghi được chọn</span>

                            </a>
                            <form style="display: none" method="post" action="{{$_mutipleDeleteLink}}"
                                  id="formDeleteMutiple">
                                @csrf
                                <div id="id-list">

                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6 text-right">

                            <span class="text-green padding-l-5">Tất cả: {{ $total }} bản ghi.</span>&nbsp;

                        </div>
                    </div>
                </div>
                @include($resourceAlias.'.table')
            @else

                <p class="margin-l-5 lead text-green">Không có dữ liệu.</p>

            @endif
        </div>
        <!-- /.box-body -->
        @if (count($records) > 0)
            @include('common.paginate', ['records' => $records])
        @endif

    </div>
    <!-- /.box -->

@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
    @include('admin._resources._list-footer-extras', ['sortByParams' => []])
@endsection

@push('footer-scripts')
    <script>

    </script>
@endpush