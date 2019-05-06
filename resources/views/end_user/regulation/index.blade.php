@extends('layouts.end_user')
@section('page-title', __l('regulation'))

@section('breadcrumbs')
    @if(empty($search))
        {!! Breadcrumbs::render('regulation') !!}
    @else
        {!! Breadcrumbs::render('regulation_search', $search) !!}
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- Search form -->
            <form class="mb-4">
                <div class="md-form active-cyan-2 mb-3">
                    <input name="search" value="{{old('search', $search)}}" class="form-control" type="text"
                           placeholder="{{__l('Search')}}" aria-label="Search">
                    <input type="hidden" name="page_size" value="{{$perPage}}">
                </div>
            </form>
            @if($regulations->isNotEmpty())

                <table class="table table-bordered table-hover">
                    <thead class="stylish-color white-text">
                    <tr>
                        <th style="width: 50px">STT</th>
                        <th>Nội quy/quy định</th>
                        <th style="width: 200px">Ngày bắt đầu hiệu lực</th>
                        <th style="width: 100px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($regulations as $idx => $regulation)
                        <tr class="list-reulation">
                            <td class="text-right">
                                {{$idx + 1}}.
                            </td>
                            <td>{{$regulation->name}}</td>
                            <td>{{$regulation->approve_date}}</td>
                            <td>
                                <a class="text-dark"
                                   href="{{route('regulation_detail', ['id' => $regulation->id])}}">chi tiết >></a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                <h2>{{__l('list_empty', ['name'=>'thông báo'])}}</h2>
            @endif
        </div>
    </div>
@endsection