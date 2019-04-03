<?php use App\Http\Controllers\Admin\StatisticController; ?>
@section('_pageSubtitle')
    DS
@endsection
<div class="table-responsive list-records">
    @include($resourceAlias.'.export')
    <table class="table table-hover table-bordered dataTable work_time">
        <thead>
        <th class="stt">Tên thành viên</th>
        <th class="no-wap on_time">Danh sách đi làm đúng giờ</th>
        <th class="early">Danh sách đi làm muộn/sớm</th>
        <th class="ot">Danh sách OT</th>
        <th class="late">Danh sách đi làm muộn + OT</th>
        <th class="leave">Xin nghỉ</th>
        </thead>
        <tbody>
        @foreach($user_team as $key => $item)
            <tr>
                <td class="text-center">{{$item}}</td>
                {{--normal--}}
                <td class="text-center">
                    @if (isset($work_types[$key][app\Models\Statistics::TYPES['normal']]))
                        {{ $work_types[$key][app\Models\Statistics::TYPES['normal']] }}
                        @else
                        {{0}}
                    @endif
                    {{COUNT}}
                </td>
                {{--lately + early--}}
                <td class="text-center">
                    @if (isset($work_types[$key][app\Models\Statistics::TYPES['latey_early']]))
                        {{ $work_types[$key][app\Models\Statistics::TYPES['latey_early']] }}
                    @else
                        {{0}}
                    @endif
                    {{COUNT}}
                </td>
                {{--lately + early--}}
                <td class="text-center">
                    @if (isset($work_types[$key][app\Models\Statistics::TYPES['ot']]))
                        {{ $work_types[$key][app\Models\Statistics::TYPES['ot']] }}
                    @else
                        {{0}}
                    @endif
                    {{COUNT}}
                </td>
                {{--lately + early--}}
                <td class="text-center">
                    @if (isset($work_types[$key][app\Models\Statistics::TYPES['lately_ot']]))
                        {{ $work_types[$key][app\Models\Statistics::TYPES['lately_ot']] }}
                    @else
                        {{0}}
                    @endif
                    {{COUNT}}
                </td>
                {{--leave--}}
                <td class="text-center">
                    @if (isset($work_types[$key][app\Models\Statistics::TYPES['leave']]))
                        {{ $work_types[$key][app\Models\Statistics::TYPES['leave']] }}
                    @else
                        {{0}}
                    @endif
                    {{COUNT}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@push('footer-scripts')
    <script>
        $(function () {
        })
    </script>
@endpush
<style>
    .on_time, .early, .ot, .late, .leave {
        width: 250px !important;
    }
</style>