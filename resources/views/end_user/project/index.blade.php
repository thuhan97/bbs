@extends('layouts.end_user')
@section('page-title', __l('Project'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('project') !!}
@endsection
@section('content')
    @can('team-leader')
        <div class=" fixed-action-btn">
            <a href="#" onclick="location.href='{{route('create_project')}}'"
               class="btn-floating btn-lg red waves-effect waves-light text-white"
               title="Tạo dự án">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    @endcan
    <!-- Search form -->
    <form class="mb-4">
        <div class="md-form active-cyan-2 mb-3">
            <input name="search" value="{{old('search', $search)}}" class="form-control" type="text"
                   placeholder="{{__l('Search')}}" aria-label="Search">
            <input type="hidden" name="page_size" value="{{$perPage}}">
        </div>
    </form>
    @if($projects->isNotEmpty())
        <p>{{__l('total_record', ['number' => $projects->total()])}}</p>
        <table id="contactTbl" class="table table-striped">
            <colgroup>
                <col style=>
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>

                <th>Khách hàng</th>
                <th>Leader</th>
                <th class="text-center">Bắt đầu</th>
                <th class="text-center">Kết thúc</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($projects as $id => $row)
                <tr>
                    <th>{{ $id + 1 }}</th>
                    <td>{{$row->name}}</td>
                    <td>{{$row->customer}}</td>
                    <td>{{$row->leader->name ?? 'Đang cập nhật'}}</td>
                    <td class="text-center">
                        {{$row->start_date}}
                    </td>
                    <td class="text-center">
                        {{$row->end_date}}
                    </td>
                    <td>{{STATUS_PROJECT[$row->status]}}</td>
                    <td class="text-center">
                        <a href="{{route('project_detail', ['id' => $row->id])}}"
                           class="btn btn-info">Xem
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if ($projects->lastPage() > 1)
            @include('common.paginate_eu', ['records' => $projects])
        @endif
    @else
        <h2>{{__l('list_empty', ['name'=>'dự án'])}}</h2>
    @endif
@endsection