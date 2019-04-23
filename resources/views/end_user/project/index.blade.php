@extends('layouts.end_user')
@section('page-title', __l('Project'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('project') !!}
@endsection
@section('content')
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
                <th>Loại dự án</th>
                <th>Leader dự án</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
            </tr>
            </thead>
            <tbody>

            @foreach($projects as $row)
                <tr>
                    <th>{{$row->id}}</th>
                    <td>{{$row->name}}</td>

                    <td>{{$row->customer}}</td>
                    <td>{{PROJECT_TYPE[$row->project_type]}}</td>
                    <td>{{$row->leader->name}}</td>
                    <td class="text-center">
                        {{$row->start_date}}
                    </td>
                    <td class="text-center">
                        {{$row->end_date}}
                    </td>
                    <td>{{STATUS_PROJECT[$row->status]}}</td>
                    <td><a href="{{route('project_detail', ['id' => $row->id])}}"
                           class="btn btn-primary">{{__l('view_detail')}}</a></td>
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
    <script>
        // $( "#search" ).keyup(function() {
        //   alert( "Handler for .keyup() called." );
        // });
    </script>

@endsection