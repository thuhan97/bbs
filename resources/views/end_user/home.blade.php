@extends('layouts.end_user')
@section('page-title', __l('Home'))

@section('content')
    <div id="home">
        <section class="">
            <div class="container-fluid">
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6">
                            <div class="post-item grey lighten-4">
                                <div class="row mb-3">
                                    <div class="col-sm-5 text-center">
                                        <img class=""
                                             src="{{$post->image_url}}"
                                             alt="{{$post->name}}" width="100%">

                                    </div>
                                    <div class="col-sm-7" style="padding-left: 0">
                                        <div class="media-body p-1"
                                             onclick="localtion.href='{{route('post_detail', ['id' => $post->id])}}'">
                                            <h4 class="mt-0 mb-1 font-weight-bold elipsis-line line-2 fix-2">{{$post->name}}</h4>
                                            <p class="elipsis-line line-3 fix-3 m-0">{{str_limit(strip_tags(nl2br($post->introduction) ), 150) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!--Grid row-->
                <div class="row my-4 ">
                    <!--Grid column-->
                    <div class="col-xl-8 mb-4">
                        <!--/.Featured Image-->
                        <!--Card-->
                        @if($event)
                            <h4 class="text-d-bold">
                                Sự kiện sắp diễn ra - {{ $event->name }}
                            </h4>
                            <div class="mb-3">
                                Thời gian: {{$event->event_date}}@if($event->place) - địa điểm: {{$event->place}}
                                , @endif
                            </div>
                            <div class="mb-3 text-center">
                                <img src="{{$event->image_url}}" class="img-fluid m-auto my-5" alt="{{ $event->name }}">
                            </div>
                            <strong class="mt-3">{!! nl2br($event->introduction)  !!}</strong>

                            <hr>

                            {!! $event->content !!}

                            <br/>
                            <br/>
                            <a class="btn btn-primary waves-effect waves-light" style="margin-left: 0px"
                               href="{{route('event')}}" role="button"> Xem tất cả sự kiện</a>

                    @endif

                    <!--Card-->
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-xl-4 mb-4">
                        <ul class="list-group">
                            <li class="list-group-item active text-center">
                                <strong class="text-uppercase">Dự án mới</strong>
                            </li>
                            @foreach($projects as $project)
                                <li class="list-group-item grey lighten-4">
                                    <strong><a class="text-black"
                                               href="{{route('project_detail', ['id' => $project->id])}}">{{$project->name}}</a></strong>
                                    <p>
                                        Kỹ thuật sử dụng: {{$project->technical}}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                        <br/>
                        <div class="card mb-4 wow fadeIn">
                            <!-- Card -->
                            <div class="card">

                                <div class="view overlay">
                                    <img class="card-img-top"
                                         src="http://jvb-corp.com/img/homepage/u_home_bg.jpg"
                                         alt="Đề xuất, góp ý">
                                    <a href="#!">
                                        <div class="mask rgba-white-slight"></div>
                                    </a>
                                </div>

                                <!-- Card content -->
                                <div class="card-body">

                                    <!-- Title -->
                                    <h4 class="card-title text-uppercase">Góp ý công ty</h4>

                                    <!-- Card -->
                                    <form action="{{ route('add_suggestions') }}" method="post">
                                        @csrf
                                        <div class="text-center">
                                            <textarea name="suggestions" rows="5" style="width: 100%"
                                                      placeholder="Rất mong nhận được ý kiến đóng góp hoặc đề xuất của bạn đến công ty!"
                                                      required></textarea>
                                        </div>
                                        <div class="pt-3 pb-4 d-flex border-top-0 rounded mb-0">
                                            <button type="submit" class="btn btn-primary">Gửi ngay
                                            </button>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                <!--Grid row-->
            </div>

        </section>
    </div>
@endsection
