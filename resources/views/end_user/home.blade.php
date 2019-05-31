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
                                <div class="col-sm-5 text-center view overlay d-flex align-items-center">
                                    <a href="{{route('post_detail', ['id' => $post->id])}}" class="w-100">
                                        <img class=""
                                             src="{{$post->image_url}}"
                                             alt="{{$post->name}}" width="100%">
                                        <div class="mask rgba-white-slight"></div>

                                    </a>
                                </div>
                                <div class="col-sm-7">
                                    <div class="media-body p-1"
                                         onclick="location.href='{{route('post_detail', ['id' => $post->id])}}'">
                                        <h4 class="mt-3 mb-1 font-weight-bold elipsis-line line-2 fix-2 f-22">{{$post->name}}</h4>
                                        <p class="elipsis-line line-3 fix-3 m-0">{{str_limit(strip_tags(nl2br($post->introduction) ), 60) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-right"><a href="{{route('post')}}">Xem thêm thông báo >></a></div>
            <!-- Grid row -->
            <div class="row my-3">
                <!--Grid column-->
                <div class="col-xl-8 mb-4">
                    @if($events)
                        @foreach($events as $event)
                            <div class="row mb-4">
                                <div class="col-lg-5">
                                    <div class="view overlay rounded mb-lg-0 mb-4">
                                        <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/img%20(27).jpg" alt="Sample image">
                                        <a href="{{route('event_detail', ['id' => $event->id])}}">
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-7 home-event-content-right">
                                    <h3 class="font-weight-bold mb-1 home-title-event mb-1-18inch"><strong>[ Sắp diễn ra ] - {{ $event->name }}</strong></h3>
                                    <p class="mb-0">Thời gian tổ chức: <span class="text-danger">{{ $event->event_date }}</span></p>
                                    <p class="mb-0">Địa điểm tổ chức: <span class="text-danger">{{ $event->place }}</span></p>
                                    <hr class="my-1 my-3-18inch">
                                    <p class="d-none-15inch">{{str_limit(strip_tags(nl2br($event->introduction) ), 220) }}</p>
                                    <p class="d-none-18inch mb-15ich-0">{{str_limit(strip_tags(nl2br($event->introduction) ), 90) }}</p>
                                    <a class="btn btn-warning btn-md btn-detail-laptop mt-lt-13" href="{{route('event_detail', ['id' => $event->id])}}">Xem chi tiết</a>
                                </div>
                            </div>
                        @endforeach
                        <a class="btn btn-primary waves-effect waves-light mb-4" style="margin-right: 0px" href="{{route('event')}}" role="button"> Xem tất cả
                            sự kiện</a>
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
