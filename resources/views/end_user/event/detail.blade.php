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
            <div class="text-center">
                <p>
                    <b>{{$event->place}}</b>, {{ $event->event_date }}
                </p>
            </div>
            <hr/>

            <div class="card-body mb-3">
                <div class="card-body mb-3">
                    <form class="border border-light p-5" method="POST" action="{{ route('Join_event') }}">
                        <p class="h4 mb-4 text-center">Phản hồi</p>
                        <div class="d-flex justify-content-between joinEvent">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="deadline_at" value="{{ $event->deadline_at }}">
                            <!-- Group of material radios - option 1 -->
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="materialGroupExample1"
                                       name="status" value="1" checked>
                                <label class="form-check-label" for="materialGroupExample1">Tham gia</label>
                            </div>

                            <!-- Group of material radios - option 2 -->
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="materialGroupExample2"
                                       name="status" value="0">
                                <label class="form-check-label" for="materialGroupExample2">Không tham </label>
                            </div>
                        </div>
                        <br>
                        <label for="exampleFormControlTextarea3">Ý kiến cá nhân:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea3" rows="7"
                                  name="content"></textarea>
                        <button class="btn btn-info btn-block my-4" type="submit">Gửi phản hồi</button>
                    </form>
                </div>
            </div>
        </div>
@endsection