@extends('layouts.end_user')
@section('breadcrumbs')
    @if(empty($search))
        {!! Breadcrumbs::render('regulation') !!}
    @else
        {!! Breadcrumbs::render('regulation_search', $search) !!}
    @endif
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
    @if($regulations->isNotEmpty())
        <p>{{__l('total_record', ['number' => $regulations->count()])}}</p>
        @foreach($regulations as $regulation)
            <div class="card mb-3">
                <h5 class="card-header h5">{{$regulation->name}}</h5>
                <div class="card-body">

                    <p class="card-text">{{$regulation->introduction}}</p>
                    <a href="{{route('regulation_detail', ['id' => $regulation->id])}}"
                       class="btn btn-primary">{{__l('view_detail')}}</a>
                </div>
            </div>
        @endforeach
    @else
        <h2>{{__l('list_empty', ['name'=>'thông báo'])}}</h2>
    @endif
@endsection