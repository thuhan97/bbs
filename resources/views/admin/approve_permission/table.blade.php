@extends('layouts.admin.master')
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
                    @endif
                </form>

            </div>
            <!-- END Search -->
        </div>

        <div class="text-right">
            <button class="btn btn-primary btn-export-over-time" id="exportExcel">Xuất file excel</button>
        </div>
        <div class="table-responsive list-records table-over-time">
            <table class="table table-hover table-bordered">
                <thead>
                <th style="padding: 15px">Mã nhân viên</th>
                <th style="padding: 15px">Tên nhân viên</th>
                <th style="padding: 15px">Ngày</th>
                <th style="padding: 15px">Hình thức</th>
                <th style="padding: 15px">Giải trình</th>
                <th style="padding: 15px">Nội dung phản hồi</th>
                <th style="padding: 15px">Người duyệt</th>
                <th style="padding: 15px;">Trạng thái phê duyệt</th>
                </thead>
                <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($records as $record)
                    <tr>
                        <td class="table-text text-center" style="padding: 15px">
                            {{ $record->creator->staff_code ?? '' }}
                        </td>
                        <td class="table-text" style="padding: 15px">{{ $record->creator->name ?? '' }}</td>
                        <td class="table-text" style="padding: 15px">{{ $record->work_day }}</td>
                        <td class="table-text" style="padding: 15px">
                            @if($record->type == array_search('Đi muộn',WORK_TIME_TYPE))
                                Đi muộn
                            @elseif($record->type == array_search('Về sớm',WORK_TIME_TYPE))
                                Về sớm
                            @endif
                        </td>
                        <td class="table-text" style="padding: 15px">{!! $record->note !!} </td>
                        <td class="table-text" style="padding: 15px">{!! $record->reason_reject !!} </td>
                        <td class="table-text" style="padding: 15px"> {{ $record->approver->name ?? '' }}</td>
                        <td class="table-text text-center" style="padding: 15px">
                            @if($record['status'] == array_search('Đã duyệt',OT_STATUS))
                                <span class="label label-info">Đã duyệt</span>
                            @elseif($record['status'] == array_search('Chưa duyệt',OT_STATUS))
                                <span class="label label-warning">Chưa duyệt</span>
                            @elseif($record['status'] == array_search('Từ chối',OT_STATUS))
                                <span class="label label-danger">Từ chối</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
    @include('admin._resources._list-footer-extras', ['sortByParams' => []])
@endsection

@push('footer-scripts')
    <script>

    </script>
@endpush
