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
        <ul class="list-group list-group-flush">
            @foreach($regulations as $regulation)
                <li class="list-group-item">
                    <a href="{{route('regulation_detail', ['id' => $regulation->id])}}">{{$regulation->name}}</a>
                </li>
            @endforeach
        </ul>
    @else
        <h2>{{__l('list_empty', ['name'=>'thông báo'])}}</h2>
    @endif
@endsection