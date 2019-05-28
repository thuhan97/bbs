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
    <div class="row">
        <div class="col-12 col-xxl-11">
            <form class="mb-0 mb-lg-4">
                <div class="md-form active-cyan-2 mb-3">
                    @include('layouts.partials.frontend.search-input', ['search' => $search, 'text' => __l('Search')])
                    <input type="hidden" name="page_size" value="{{$perPage}}">
                </div>
            </form>
            @if($projects->isNotEmpty())
                <p>{{__l('total_record', ['number' => $projects->total()])}}</p>
                <table id="contactTbl" class="table table-striped">
                    <colgroup>
                        <col class="d-none d-sm-table-cell" style="width: 50px">
                        <col style="">
                        <col class="d-none d-sm-table-cell" style="">
                        <col class="d-none d-sm-table-cell" style="width: 180px">
                        <col class="d-none d-sm-table-cell" style="width: 10%">
                        <col style="width: 180px">
                        <col class="d-none d-sm-table-cell" style="width: 10%">
                        <col class="d-none d-sm-table-cell" style="width: 60px">
                    </colgroup>
                    <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">#</th>
                        <th>Tên</th>
                        <th class="d-none d-sm-table-cell">Khách hàng</th>
                        <th>Leader</th>
                        <th class="d-none d-sm-table-cell text-center">Bắt đầu</th>
                        <th class="d-none d-sm-table-cell text-center">Kết thúc</th>
                        <th class="d-none d-sm-table-cell">Trạng thái</th>
                        <th class="d-none d-sm-table-cell"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($projects as $id => $row)
                        <tr>
                            <th class="d-none d-sm-table-cell">{{ $id + 1 }}</th>
                            <td onclick="location.href='{{route('project_detail', ['id' => $row->id])}}'">{{$row->name}}</td>
                            <td class="d-none d-sm-table-cell">{{$row->customer}}</td>
                            <td>{{$row->leader->name ?? 'Đang cập nhật'}}</td>
                            <td class="text-center d-none d-sm-table-cell">
                                {{$row->start_date}}
                            </td>
                            <td class="text-center d-none d-sm-table-cell">
                                {{$row->end_date}}
                            </td>
                            <td class="d-none d-sm-table-cell">{{STATUS_PROJECT[$row->status]}}</td>
                            <td class="text-center d-none d-sm-table-cell">
                                <a href="{{route('project_detail', ['id' => $row->id])}}"
                                   class="btn btn-primary">Xem
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
        </div>
    </div>
@endsection
