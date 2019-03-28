@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('work_time') !!}
@endsection
@section('content')
    <div class="select-month">
        <select class="w-22 mr-1 browser-default custom-select" name="month"
                onchange="document.location.href='/thoi-gian-lam-viec?month='+this.value">
            <option value="">Chọn tháng</option>
            @for($i=1; $i<=12; $i++)
                <option value="{{$i}}" @if($i==$m) selected @endif>Tháng {{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="list-work-time">
        <div class="row statistic">
            <form method="get">
                <input hidden name="month">
                <input hidden name="type" value="di_muon">
                <button type="button" class="btn btn-danger" onclick="exec_submit(0)">Số buổi đi
                    muộn: {{$late}}</button>
            </form>
            <form method="get">
                <input hidden name="month">
                <input hidden name="type" value="ve_som">
                <button type="button" class="btn btn-primary" onclick="exec_submit(1)">Số buổi về
                    sớm: {{$early}}</button>
            </form>
            <form method="get">
                <input hidden name="month">
                <input hidden name="type" value="ot">
                <button type="button" class="btn btn-success" onclick="exec_submit(2)">Số buổi OT: {{$ot}}</button>
            </form>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Ngày làm việc
                </th>
                <th>
                    Giờ đến công ty
                </th>
                <th>
                    Giờ rời công ty
                </th>
                <th>
                    Note
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($list_work_times as $work_time)
                <tr>
                    <td>
                        {{$work_time['work_day']}}
                    </td>
                    <td>
                        {{$work_time['start_at']}}
                    </td>
                    <td>
                        {{$work_time['end_at']}}
                    </td>
                    <td>
                        {{$work_time['note']}}
                    </td>
                    <th>
                        <a class="feedback" data-toggle="modal" data-target="#feedback" data-id="{{$work_time['id']}}">Kêu
                            oan</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ĐƠN KÊU OAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea cols="55" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary complain">Đâm đơn</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Bỏ qua</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var id = 0;

        function exec_submit(i) {
            var f = document.forms[i];
            if (getParam('month') == null) {
                console.log('ok');
                var d = new Date();
                var m = d.getMonth();
                f.month.value = m + 1;
            } else {
                f.month.value = getParam('month');
            }
            f.action = "/thoi-gian-lam-viec";
            f.submit();
        }

        function getParam(param) {
            var results = new RegExp('[\?&]' + param + '=([^&#]*)').exec(window.location.href);
            if (results == null) {
                return null;
            }
            return decodeURI(results[1]) || 0;
        }

        $('.feedback').click(function () {
            id = $(this).attr('data-id')
        });

        $('.complain').click(function () {
            var message = $('.modal-body textarea').val();
            console.log(id);
            $('#feedback').modal('hide');
        });
    </script>

@endsection