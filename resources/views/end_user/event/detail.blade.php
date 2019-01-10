@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('event_detail', $event) !!}
@endsection
@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron p-0">

        <!-- Card image -->
        <div class="view overlay rounded-top text-center pt-4">
            <img src="{{$event->image_url}}" class="img-fluid m-auto mt-3" alt="Sample image">
            <a href="#">
                <div class="mask rgba-white-slight"></div>
            </a>
        </div>

        <!-- Card content -->
        <div class="card-body mb-3">

            <!-- Title -->
            <h3 class="card-title h3 my-4 text-center"><strong>{{$event->name}}</strong></h3>
            <h5 class="card-title h6 my-4 text-center"><b>{!! $event->introduction!!}</b></h5>
            <!-- Text -->
            <p class="card-text py-2">{!! $event->content !!}</p>
            <!-- Button -->
            <hr />
            <div class="text-center">
                <p>
                    <b>{{$event->place}}</b>, {{ $event->event_date }}
                </p>
            </div>
        </div>

    </div>

@endsection