@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('post_detail', $post) !!}
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header h5">{{$post->name}}</h5>
        <div class="card-body">
            {{--<h5 class="card-title">{!! $post->introduction !!}</h5>--}}
            <p class="card-text">{!! $post->content !!}</p>

            <div class="text-right">
                <p>
                    <b>{{$post->author_name}}</b>, {{ $post->created_at->format(DATE_FORMAT) }}
                </p>
            </div>
        </div>
    </div>
@endsection