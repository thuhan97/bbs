@extends('layouts.end_user')
@section('page-title', $event->name)

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
            <h3 class="card-title h3 my-4 text-center"><strong>{{$event->name}}</strong>
                @if($event->event_end_date < date('Y-m-d'))
                    <h4 class="card-title h3 my-4 text-center text-danger"><strong>Đã kết thúc</strong>
                    </h4>
                @endif

            </h3>
            <h5 class="card-title h6 my-4 text-center"><b>{!! nl2br($event->introduction) !!}</b></h5>
            <!-- Text -->
            <p class="card-text py-2">{!! $event->content !!}</p>
            <!-- Button -->
        </div>
    </div>
    @if($event->deadline_at > date('Y-m-d H:i:s'))
        <form class="border border-light p-2 p-sm-5" method="POST" action="{{ route('join_event') }}">
            <h4 class="h4 text-center">Đăng ký </h4>
            <h5 class=" text-center mb-4 text-warning">(còn {{show_timeout_event($event->deadline_at)}})</h5>
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
                    <label class="form-check-label" for="materialGroupExample2">Không tham gia</label>
                </div>
            </div>
            <br>
            <label for="exampleFormControlTextarea3">Ý kiến cá nhân:</label>
            <textarea class="form-control" id="exampleFormControlTextarea3" rows="7"
                      name="content"></textarea>
            <button class="btn btn-info btn-block my-4" type="submit">Gửi phản hồi</button>
        </form>
    @else
        <h3 class="card-title h3 my-4 text-center text-danger"><strong>Đã hết thời hạn đăng ký
                - {{$event->deadline_at}}</strong>
        </h3>
    @endif
    @if ($listUserJoinEvent->count() > 0)
        <h5 id="registerList" class="card-title h6 my-4"><b>Đã
                có {{$listUserJoinEvent->where('status', EVENT_JOIN_STATUS)->count()}}/{{$listUserJoinEvent->count()}}
                nhân viên tham gia sự kiện:</b></h5>
        <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="d-none d-sm-table-cell" style="width: 250px">Ngày đăng kí
                </th>
                <th class="th-sm" style="width: 250px">Tên nhân viên
                </th>
                <th class="th-sm" style="width: 150px">Trạng thái
                </th>
                <th class="d-none d-sm-table-cell">Ý kiến cá nhân
                </th>

            </tr>
            </thead>
            <tbody>
            @foreach ($listUserJoinEvent as $listUserJoinEventValue)
                <tr>
                    <td class="d-none d-sm-table-cell">{{ $listUserJoinEventValue->created_at }}</td>
                    <td>{{ $listUserJoinEventValue->name }}</td>
                    <td>{{ $listUserJoinEventValue->status == 1 ? STATUS_JOIN_EVENT[1] : STATUS_JOIN_EVENT[0] }}</td>
                    <td class="d-none d-sm-table-cell">{{ $listUserJoinEventValue->content}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
    @endif

@endsection
@push('extend-js')
    <script>
        $(document).ready(function () {
        });
    </script>
@endpush

