@extends('layouts.end_user')
@section('page-title', __l('Home'))

@section('content')
    <div id="home">
        <section class="">
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-6">
                        <div class="post-item grey lighten-4">
                            <div class="row mb-3">
                                <div class="col-sm-5 text-center view overlay">
                                    <a href="{{route('post_detail', ['id' => $post->id])}}">
                                        <img class=""
                                             src="{{$post->image_url}}"
                                             alt="{{$post->name}}" width="100%">
                                        <div class="mask rgba-white-slight"></div>

                                    </a>
                                </div>
                                <div class="col-sm-7" style="padding-left: 0">
                                    <div class="media-body p-1"
                                         onclick="location.href='{{route('post_detail', ['id' => $post->id])}}'">
                                        <h4 class="mt-3 mb-1 font-weight-bold elipsis-line line-2 fix-2 f-22">{{$post->name}}</h4>
                                        <p class="elipsis-line line-3 fix-3 m-0">{{str_limit(strip_tags(nl2br($post->introduction) ), 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-right"><a href="{{route('post')}}">Xem thêm thông báo >></a></div>
            <!--Grid row-->
            <div class="row my-4 ">
                <!--Grid column-->
                <div class="col-xl-8 mb-4">
                    <!--/.Featured Image-->
                    <!--Card-->
                    @if($event)
                        <h3 class="text-d-bold">
                            <a href="{{route('event_detail', ['id' => $event->id])}}">
                                Sự kiện sắp diễn ra - {{ $event->name }}
                            </a>
                        </h3>
                        <div class="mb-3">
                            Thời gian: {{$event->event_date}}@if($event->place) - địa điểm: {{$event->place}}
                            , @endif
                        </div>
                        <div class="mb-3 text-center">
                            <a href="{{route('event_detail', ['id' => $event->id])}}">
                                <img src="{{$event->image_url}}" class="img-fluid m-auto my-5"
                                     alt="{{ $event->name }}">
                            </a>
                        </div>
                        <strong class="mt-4">{!! nl2br($event->introduction)  !!}</strong>

                        <hr>

                        {!! $event->content !!}

                        <br/>
                        <br/>
                        <a class="btn btn-primary waves-effect waves-light" style="margin-left: 0px"
                           href="{{route('event')}}" role="button"> Xem tất cả sự kiện</a>

                        <hr/>
                @endif
                @include('elements.feedback')
                <!--Card-->
                    <!--/.Card-->
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-xl-4 mb-4">
                    @include('elements.punish')

                    <ul class="list-group">
                        <li class="list-group-item active text-center">
                            <strong class="text-uppercase">Dự án mới</strong>
                        </li>
                        @foreach($projects as $project)
                            <li class="list-group-item grey lighten-4">
                                <strong><a class="text-black"
                                           href="{{route('project_detail', ['id' => $project->id])}}">{{$project->name}}</a></strong>
                                <div>
                                    {!! nl2br($project->technical) !!}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>
            <!--Grid row-->
        </section>
    </div>

@endsection
