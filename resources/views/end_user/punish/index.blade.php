@extends('layouts.end_user')
@section('page-title', __l('Punish'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('punish') !!}
@endsection
@php
    $totalMoney = $punishes->sum('total_money');
    $totalLateMoney = $punishes->where('rule_id', 0)->sum('total_money');
    $unSubmitMoney = $punishes->where('is_submit', PUNISH_SUBMIT['new'])->sum('total_money');
    $submitedMoney = $totalMoney - $unSubmitMoney;
    $otherMoney = $totalMoney - $totalLateMoney;
    $groupPunishes = $punishes->groupBy('rule_id');
@endphp
@section('content')
    <div class="row mt-4">
        <div class="col-xl-10">
            <form class="mb-4 mb-3" id="formReport">
                <div class="active-cyan-2 mb-0">
                    <div class="row">
                        <div class="col-6 col-sm-2 ">
                            {{ Form::select('year', get_years(2), request('year', date('Y')), ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2">
                            {{ Form::select('month', get_months('Tháng '), request('month', date('n')), ['class'=>' mt-md-0 w-30 browser-default custom-select']) }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($punishes->isNotEmpty())
        <div class="row">
            <div class="col-xl-1"></div>
            <div class="col-xl-10">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="pieChartTotal"></canvas>
                        <br/>
                        <div class="row d-none d-sm-flex">
                            <div class="col-6 text-right">
                                <h4>Chưa nộp: <b
                                            class="text-danger d-xl-inline d-block">{{number_format($unSubmitMoney)}}</b>
                                    <span class="d-none d-xl-inline"> VNĐ</span></h4>
                            </div>
                            <div class="col-6">
                                <h4>Đã nộp: <b
                                            class="text-success d-xl-inline d-block">{{number_format($submitedMoney)}}</b>
                                    <span class="d-none d-xl-inline"> VNĐ</span></h4>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <canvas id="pieChartLate"></canvas>
                        <br/>
                        <div class="row d-none d-sm-flex">
                            <div class="col-6 text-right">
                                <h4>Đi muộn: <b
                                            class="text-danger d-xl-inline d-block">{{number_format($totalLateMoney)}}</b>
                                    <span class="d-none d-xl-inline"> VNĐ</span></h4>
                            </div>
                            <div class="col-6">
                                <h4>Vi phạm khác: <b
                                            class="text-primary d-xl-inline d-block">{{number_format($otherMoney)}}</b>
                                    <span class="d-none d-xl-inline"> VNĐ</span></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion md-accordion mt-2 mt-xl-4" id="punish" role="tablist">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="d-none d-md-table-cell" style="width: 50px">#</th>
                            <th style="width: 120px">Ngày vi phạm</th>
                            <th>Xử phạt</th>
                            <th class="d-none d-md-table-cell">Ghi chú</th>
                            <th style="width: 120px">Số tiền</th>
                            <th class="d-none d-md-table-cell" style="width: 150px">Đã nộp tiền</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($punishes as $idx => $punish)
                            <tr>
                                <th scope="row" class="d-none d-md-table-cell">{{$idx + 1}}</th>
                                <td class="text-center">{{$punish->infringe_date}}</td>
                                <td>{{ $punish->rule->name ?? 'Đi muộn'}}</td>
                                <td class="d-none d-md-table-cell">{{ $punish->detail }}</td>
                                <td class="text-center">{{ number_format($punish->total_money) }}</td>
                                <td class="text-center d-none d-md-table-cell">
                                    @if($punish->is_submit != PUNISH_SUBMIT['new'])
                                        <span class="text-success">
                                            <i class="fa fa-check"></i>
                                            Yes
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            <i class="fa fa-times"></i>
                                            No</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @else
        <h2>{{__l('list_empty', ['name'=>'vi phạm'])}}</h2>
    @endif

@endsection
@push('extend-js')
    <script>
        $(function () {
            $('.custom-select').change(function () {
                $('form').submit();
            });
        });

        function formatTootip(tooltipItem, data) {
            var label = (data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '') + '';
            return data.labels[tooltipItem.index] + ' ' + label.toGeneralConcurency() + ' VNĐ';
        }

        //pie
        var ctxP = document.getElementById("pieChartTotal").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Chưa nộp phạt", "Đã nộp phạt"],
                datasets: [{
                    data: ['{{$unSubmitMoney}}', {{$submitedMoney}}],
                    backgroundColor: ["#F7464A", "#2fbf5a"],
                    hoverBackgroundColor: ["#FF5A5E", "#6ed38f"]
                }]
            },
            options: {
                // responsive: true,
                tooltips: {
                    callbacks: {
                        label: formatTootip
                    }
                }
            }
        });
        //pie
        var ctxPL = document.getElementById("pieChartLate").getContext('2d');
        var myPieChartL = new Chart(ctxPL, {
            type: 'pie',
            data: {
                labels: ["Phạt đi muộn", "Vi phạm khác"],
                datasets: [{
                    data: [ {{$totalLateMoney}}, {{$otherMoney}}],
                    backgroundColor: ["#F7464A", "#507fbf"],
                    hoverBackgroundColor: ["#FF5A5E", "#7ba3d3"]
                }]
            },
            options: {
                // responsive: true,
                tooltips: {
                    callbacks: {
                        label: formatTootip
                    }
                }

            }
        });
    </script>
@endpush
