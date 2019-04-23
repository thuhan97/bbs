
@section('_pageSubtitle')
    DS
@endsection
<div class="table-responsive list-records">
    @include($resourceAlias.'.export')
    <table class="table table-hover table-bordered dataTable work_time">
        <thead>
        <th style="width: 10px;" class="stt">STT</th>
        <th class="no-wap on_time">Danh sách đi làm đúng giờ</th>
        <th class="early">Danh sách đi làm muộn/sớm</th>
        <th class="ot">Danh sách OT</th>
        <th class="late">Danh sách đi làm muộn + OT</th>
        <th class="leave">Xin nghỉ</th>
        </thead>
        <tbody>
        <?php $j = max(array_map("count", $work_types));?>
        @for($i = 0; $i < $j; $i ++)
            <?php $tableCounter++;?>
            <tr>
                <td class="text-center">{{$tableCounter}}</td>
                {{--normal--}}
                <td class="text-center">
                    @isset($work_types[app\Models\Statistics::TYPES['normal']][$i])
                        {{ $work_types[app\Models\Statistics::TYPES['normal']][$i] }}
                    @endisset
                </td>
                {{--lately + early--}}
                <td class="text-center">
                    @isset($work_types[app\Models\Statistics::TYPES['latey_early']][$i])
                        {{ $work_types[app\Models\Statistics::TYPES['latey_early']][$i] }}
                    @endisset
                </td>
                {{--ot--}}
                <td class="text-center">
                    @isset($work_types[app\Models\Statistics::TYPES['ot']][$i])
                        {{ $work_types[app\Models\Statistics::TYPES['ot']][$i] }}
                    @endisset
                </td>
                {{--lately_ot--}}
                <td class="text-center">
                    @isset($work_types[app\Models\Statistics::TYPES['lately_ot']][$i])
                        {{ $work_types[app\Models\Statistics::TYPES['lately_ot']][$i] }}
                    @endisset
                </td>
                {{--leave--}}
                <td class="text-center">
                    @isset($work_types[app\Models\Statistics::TYPES['leave']][$i])
                        {{ $work_types[app\Models\Statistics::TYPES['leave']][$i] }}
                    @endisset
                </td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>
@push('footer-scripts')
    <script>
        $(function () {
        })
    </script>
@endpush