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
    <form>
        <div class="md-form active-cyan-2 mb-2">
            @include('layouts.partials.frontend.search-input', ['class' => 'tien','search' => $search, 'text' => __l('Search')])
            <input type="hidden" name="page_size" value="{{$perPage}}">
        </div>
    </form>
    @if($events->isNotEmpty())
        <div class="row mb-3">
            <div class="col-sm-6"></div>
            <div class="col-sm-6 text-right">
                <a href="{{route('event_calendar')}}" class="btn btn-primary waves-effect" id="inputGroup-sizing-default">
                    <i class="fas fa-calendar icon-calendar-event"></i> Xem lịch
                </a>
            </div>
        </div>
        @foreach($events as $event)
            <div class="jumbotron mb-3 z-depth-0 border {{$event->event_status_class}}">
                <h2 class="h1-responsive"><strong> {{$event->event_status_name .$event->name}}</strong></h2>
                <p class="lead">{{__l('event_time')}}: <strong
                            class="text-danger text-uppercase">{{ $event->event_date}}</strong></p>
                <p class="lead">{{__l('event_place')}}: <strong
                            class="text-danger text-uppercase">{{ $event->place}}</strong></p>
                <hr class="my-2">
                <p style="font-size: 120%">
                    {!! nl2br($event->introduction) !!}
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
