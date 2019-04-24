@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('ask_permission') !!}
@endsection
@section('content')
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    ?>
    @if($user->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE)
        <h1>Danh sách xin phép</h1>
        <table id="contactTbl" class="table table-striped">
            <colgroup>
                <col style="">
                <col style="">
                <col style="">
                <col style="">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Ngày</th>
                <th>Người làm đơn</th>
                <th>Loại</th>
                <th>Nội dung</th>
                <th>Trạng Thái</th>
            </tr>
            </thead>
            <?php $increment = 1; ?>

            @foreach($dataLeader as $item)
                <tbody>
                <tr>
                    <th>{{ $increment++ }}</th>
                    <th>{{ $item['work_day'] ?? '' }}</th>
                    <th>{{ $item->user->name ?? '' }}</th>
                    <td>
                        @if($item['type'] === 0)
                            Bình thường
                        @elseif($item['type'] === 1)
                            Đi muộn
                        @elseif($item['type'] === 2)
                            Về sớm
                        @elseif($item['type'] === 4)
                            @if($item['ot_type'] === 1)
                                OT Dự án
                            @else
                                Lý do cá nhân
                            @endif
                        @endif
                    </td>
                    <td>{{ $item['note'] ?? '' }}</td>
                    <td>
                        @if(is_null($item['id_ot_time']))
                            <form action="{{ route('approved') }}">
                                <input type="hidden" name="user_id"
                                       value="{{ $item['user_id'] ? $item['user_id'] : '' }}">
                                <input type="hidden" name="reason" value="{{ $item['note'] ? $item['note'] : '' }}">
                                <input type="hidden" name="approver_id"
                                       value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                                <input type="hidden" name="work_day"
                                       value="{{ $item['work_day'] ? $item['work_day'] : '' }}">
                                <button class="btn btn-primary waves-effect waves-light">Phê duyệt</button>
                            </form>
                        @else
                            Đã Duyệt
                        @endif
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
        {{$dataLeader->render('end_user.paginate') }}
        <br><br><br>
    @endif
    <h2>Xin phép cá nhân</h2>
    <table id="contactTbl" class="table table-striped">
        <colgroup>
            <col style="">
            <col style="">
            <col style="">
            <col style="">
        </colgroup>
        <thead>
        <tr>
            <th>#</th>
            <th>Ngày</th>
            <th>Loại</th>
            <th>Nội dung</th>
            <th>Trạng Thái</th>
        </tr>
        </thead>
        <?php $increment = 1; ?>
        @foreach($datas as $item)

            <tbody>
            <tr>
                <th>{{ $increment++ }}</th>
                <th>{{ $item['work_day'] ?? '' }}</th>
                <td>
                    @if($item['type'] === 0)
                        Bình thường
                    @elseif($item['type'] === 1)
                        Đi muộn
                    @elseif($item['type'] === 2)
                        Về sớm
                    @elseif($item['type'] === 4)
                        @if($item['ot_type'] === 1)
                            OT Dự án
                        @else
                            Lý do cá nhân
                        @endif
                    @endif
                </td>
                <td>{{ $item['note'] ?? '' }}</td>
                <td>
                    Phê duyệt
                    {{--<a href="{{ route('approved') }}" class="btn btn-primary waves-effect waves-light">Phê duyệt</a>--}}
                </td>
            </tr>
            </tbody>
        @endforeach
    </table>
    {{$datas->render('end_user.paginate') }}

    <script type="text/javascript"></script>
@endsection

                        