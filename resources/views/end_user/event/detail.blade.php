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
                @if($event->event_end_date < date('Y-m-d H:i:s'))
                    <h4 class="card-title h3 my-4 text-center text-danger"><strong>Đã kết thúc</strong>
                    </h4>
                @endif

            </h3>
            <h5 class="card-title h6 my-4 text-center"><b>{!! nl2br($event->introduction) !!}</b></h5>
            <!-- Text -->
            <p class="card-text py-2">{!! $event->content !!}</p>
            <!-- Button -->
            <div class="text-center">
                <p>
                    <b>{{$event->place}}</b>, {{ $event->event_date }}
                </p>
            </div>
            <hr/>

            @if($event->deadline_at > date('Y-m-d H:i:s'))
                <form class="border border-light p-5" method="POST" action="{{ route('join_event') }}">
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
            @else
                <h3 class="card-title h3 my-4 text-center text-danger"><strong>Đã hết thời hạn gửi phản hồi</strong>
                </h3>
            @endif
            @if (count($listUserJoinEvent) > 0)
                <h5 id="registerList" class="card-title h6 my-4"><b>Danh sách nhân viên đã đăng ký:</b></h5>
                <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Tên nhân viên
                        </th>
                        <th class="th-sm">Mã nhân viên
                        </th>
                        <th class="th-sm">Trạng thái
                        </th>
                        <th class="th-sm">Ý kiến cá nhân
                        </th>
                        <th class="th-sm">Ngày đăng kí
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($listUserJoinEvent as $listUserJoinEventValue)
                        <tr>
                            <td>{{ $listUserJoinEventValue->name }}</td>
                            <td>{{ $listUserJoinEventValue->staff_code }}</td>
                            <td>{{ $listUserJoinEventValue->status == 1 ? STATUS_JOIN_EVENT[1] : STATUS_JOIN_EVENT[0] }}</td>
                            <td>{{ $listUserJoinEventValue->content}}</td>
                            <td>{{ $listUserJoinEventValue->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
    @push('extend-js')
        <script>
            $(document).ready(function () {
                $('#dtBasicExample').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </script>
    @endpush
@endsection

