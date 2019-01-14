@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('regulation_detail', $regulation) !!}
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header h5">{{$regulation->name}}</h5>
        <div class="card-body">
            {{--<h5 class="card-title">{!! $regulation->introduction !!}</h5>--}}
            <p class="card-text">{!! $regulation->content !!}</p>

            <div class="text-right">
                <p>
                    <b>{{ $regulation->created_at->format(DATE_FORMAT) }}</b>
                </p>
            </div>
        </div>
    </div>
@endsection