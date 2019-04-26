@extends('layouts.end_user')
@section('page-title', __l('Home'))

@section('content')
    <section class="mt-4">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-xl-7 mb-4">
                <!--/.Featured Image-->
                <!--Card-->
                @if($event)
                    <div class="card mb-4 wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <!--Card content-->
                        <div class="card-body text-center">
                            <p class="h5 mb-4 text-gray">Sự kiện sắp diễn ra</p>
                            <h5 class="my-4">
                                <strong class="text-success">
                                    {{ $event->name }}
                                </strong>
                            </h5>

                            <img src="{{$event->image_url}}" class="img-fluid m-auto my-5" alt="Sample image">

                            <div class="text-primary">
                                @if($event->place) <b>{{$event->place}}</b>, @endif
                                {{ $event->event_date }}
                                @if($event->event_end_date) đến {{$event->event_end_date}} @endif
                            </div>

                            <p class="mt-3">{!! nl2br($event->introduction)  !!}</p>

                            <hr>

                            <a class="btn btn-outline-primary waves-effect waves-light"
                               href="{{route('event')}}" role="button"> Xem tất cả sự kiện</a>

                        </div>

                    </div>
            @endif

            <!--Card-->
                <div class="card mb-4 wow fadeIn">
                    <div class="card-header">Thông báo mới</div>
                    <!--Card content-->
                    <div class="card-body" id="post-content">
                        @foreach($posts as $post)
                            <div class="post-item">
                                <div class="row mt-4 mb-3 ">
                                    <div class="col-sm-2 text-center">
                                        <img class="mb-2"
                                             src="{{lfm_thumbnail($post->image_url)}}"
                                             alt="{{$post->name}}" width="100%">

                                    </div>
                                    <div class="col-sm-10">
                                        <div class="media-body">
                                            <a href="{{route('post_detail', ['id' => $post->id])}}">
                                                <h5 class="mt-0 mb-3 font-weight-bold">{{$post->name}}</h5>
                                            </a>
                                            {{str_limit(strip_tags(nl2br($post->introduction) )) }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <!--/.Card-->
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="d-none d-xl-block col-md-5 mb-4">

                <!--Card: Jumbotron-->
                <div class="card blue-gradient mb-4 wow fadeIn">
                    <!-- Content -->
                    <div class="card-body text-white text-center">

                        <h4 class="mb-4">
                            <strong>{{$config->name}}</strong>
                        </h4>
                        <p>
                            <i>Beta version</i>
                        </p>
                        <p class="mb-4">
                            {!! $config->description !!}
                        </p>
                    </div>
                    <!-- Content -->
                </div>
                <!--Card: Jumbotron-->


                <!--/.Card-->
                <!--Featured Image-->
                <div class="card mb-4 wow fadeIn">
                    <script type='text/javascript'
                            src='https://darksky.net/widget/default/21.0294,105.8544/ca12/en.js?width=100%&height=350&title=JVB Viet Nam&textColor=333333&bgColor=transparent&transparency=true&skyColor=undefined&fontFamily=Times New Roman&customFont=&units=ca&htColor=333333&ltColor=cccccc&displaySum=yes&displayHeader=yes'></script>
                </div>
            </div>
            <!--Grid column-->

        </div>
        <!--Grid row-->

    </section>
@endsection