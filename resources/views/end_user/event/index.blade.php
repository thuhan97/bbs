@extends('layouts.end_user')
@section('page-title', __l('Event'))

@section('breadcrumbs')
    @if(empty($search))
        {!! Breadcrumbs::render('event') !!}
    @else
        {!! Breadcrumbs::render('event_search', $search) !!}
    @endif
@endsection
@section('content')
    <form class="mb-4">
        <div class="md-form active-cyan-2 mb-3">
            <input name="search" value="{{old('search', $search)}}" class="form-control" type="text"
                   placeholder="{{__l('Search')}}" aria-label="Search">
            <input type="hidden" name="page_size" value="{{$perPage}}">
        </div>
    </form>
    @if($events->isNotEmpty())
        <div class="row mb-3">
            <div class="col-sm-6"></div>
            <div class="col-sm-6 text-right">
                <a href="{{route('event_calendar')}}" class="btn btn-primary waves-effect">
                    <i class="fas fa-calendar"></i> Xem lịch
                </a>
            </div>
        </div>
        @foreach($events as $event)
            <div class="jumbotron mb-3 {{$event->event_status_class}}">
                <h2 class="h1-responsive"><strong> {{$event->event_status_name .$event->name}}</strong></h2>
                <p class="lead">{{__l('event_time')}}: <strong
                            class="text-danger text-uppercase"><i>{{ $event->event_date}}</i></strong></p>
                <p class="lead">{{__l('event_place')}}: <strong
                            class="text-danger text-uppercase"><i>{{ $event->place}}</i></strong></p>
                <hr class="my-2">
                <p>
                    {{$event->introduction}}
                </p>
                <div class="">
                    <a href="{{route('event_detail', ['id' => $event->id])}}" class="btn btn-warning btn-lg"
                       role="button">{{__l('view_detail')}}</a>
                </div>
            </div>
        @endforeach

        @if ($events->lastPage() > 1)
            @include('common.paginate_eu', ['records' => $events])
        @endif
    @else
        <h2>{{__l('list_empty', ['name'=>'sự kiện'])}}</h2>
    @endif

@endsection