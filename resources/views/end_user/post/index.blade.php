@extends('layouts.end_user')
@section('breadcrumbs')
    @if(empty($search))
        {!! Breadcrumbs::render('post') !!}
    @else
        {!! Breadcrumbs::render('post_search', $search) !!}

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
    @if($posts->isNotEmpty())
        <p>{{__l('total_record', ['number' => $posts->total()])}}</p>
        @foreach($posts as $post)
            <div class="card mb-3">
                <h5 class="card-header h5">{{$post->name}}</h5>
                <div class="card-body">
                    <h5 class="card-title">{{ implode(',', $post->tag_arrs)}}</h5>
                    <p class="card-text">{{$post->introduction}}</p>
                    <a href="{{route('post_detail', ['id' => $post->id])}}"
                       class="btn btn-primary">{{__l('view_detail')}}</a>
                </div>
            </div>
        @endforeach

        @if ($posts->count() > 1)
            @include('common.paginate_eu', ['records' => $posts])
        @endif
    @else
        <h2>{{__l('list_empty', ['name'=>'thông báo'])}}</h2>
    @endif
@endsection