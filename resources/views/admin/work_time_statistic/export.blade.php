<div class="col-md-10">
    @if($search_type == app\Services\StatisticService::TYPE_ONE)
        <h3 class="work_time pull-left">Thống kê thời gian theo ngày</h3>
        @else
        <h3 class="work_time pull-left">Thống kê thời gian theo tháng</h3>
    @endif
</div>
<div class="col-md-2">
{{--    <a class="pull-right export" href="{{ $_listLinkExport }}">--}}
    <a class="pull-right export" href="javascript:void (0)">
        <img src="{{URL::asset('img/statistics/export.png')}}" height="50px" >
    </a>
</div>