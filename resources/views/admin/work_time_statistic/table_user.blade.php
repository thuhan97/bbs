@section('_pageSubtitle')
    DS
@endsection
<div class="table-responsive list-records">
    @include($resourceAlias.'.export')
    <table class="table table-hover table-bordered dataTable work_time">
        <thead>
        <th class="stt">Thời gian thống kê</th>
        <th class="no-wap on_time">Đi làm đúng giờ</th>
        <th class="early">Đi làm muộn/sớm</th>
        <th class="ot"> OT</th>
        <th class="late">Đi làm muộn + OT</th>
        <th class="leave">Xin nghỉ</th>
        </thead>
        <tbody>
        @foreach($work_types as $key => $val)
            <tr>
                <td class="text-center"><span class="text-bold">{{$val['work_date']}}</span>  <br> ({{$val['start']. ' - ' . $val['end']}}) </td>
                {{--normal--}}
                <td class="text-center l-h-45">
                    @if ($val['type'] == app\Models\Statistics::TYPES['normal'])
                        x
                    @endif
                </td>
                {{--lately + early--}}
                <td class="text-center l-h-45">
                    @if ($val['type'] == app\Models\Statistics::TYPES['latey_early'])
                        x
                    @endif
                </td>
                {{--lately + early--}}
                <td class="text-center l-h-45">
                    @if ($val['type'] == app\Models\Statistics::TYPES['ot'])
                        x
                    @endif
                </td>
                {{--lately + early--}}
                <td class="text-center l-h-45">
                    @if ($val['type'] == app\Models\Statistics::TYPES['lately_ot'])
                        x
                    @endif
                </td>
                {{--leave--}}
                <td class="text-center l-h-45">
                    @if ($val['type'] == app\Models\Statistics::TYPES['leave'])
                        x
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="navbar navbar-inverse navbar-static-top h-100">
    <div class="container">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><span class="on_time_total">Số buổi đi làm đúng giờ:
                        @if (isset($counts[app\Models\Statistics::TYPES['normal']][app\Models\Statistics::TYPES['normal']]))
                            {{$counts[app\Models\Statistics::TYPES['normal']][app\Models\Statistics::TYPES['normal']]}}
                            @else
                            0
                        @endif
                         buổi
                    </span>
                </li>
                <li><span class="early_total">Số buổi đi muộn/sớm:
                        @if (isset($counts[app\Models\Statistics::TYPES['latey_early']][app\Models\Statistics::TYPES['latey_early']]))
                            {{$counts[app\Models\Statistics::TYPES['latey_early']][app\Models\Statistics::TYPES['latey_early']]}}
                        @else
                            0
                        @endif
                        buổi</span>
                </li>
                <li><span class="ot_total">Số buổi OT:
                        @if (isset($counts[app\Models\Statistics::TYPES['ot']][app\Models\Statistics::TYPES['ot']]))
                            {{$counts[app\Models\Statistics::TYPES['ot']][app\Models\Statistics::TYPES['ot']]}}
                        @else
                            0
                        @endif
                        buổi</span></li>
                <li><span class="late_total">Đi làm muộn + OT :
                        @if (isset($counts[app\Models\Statistics::TYPES['lately_ot']][app\Models\Statistics::TYPES['lately_ot']]))
                            {{$counts[app\Models\Statistics::TYPES['lately_ot']][app\Models\Statistics::TYPES['lately_ot']]}}
                        @else
                            0
                        @endif
                        buổi</span></li>
                <li><span class="leave_total">Số buổi xin nghỉ:
                        @if (isset($counts[app\Models\Statistics::TYPES['leave']][app\Models\Statistics::TYPES['leave']]))
                            {{$counts[app\Models\Statistics::TYPES['leave']][app\Models\Statistics::TYPES['leave']]}}
                        @else
                            0
                        @endif
                        buổi</span></li>
            </ul>
        </div>
    </div>
</div>
@push('footer-scripts')
    <script>
        $(function () {
        })
    </script>
@endpush
<style>

</style>