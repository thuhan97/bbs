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
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <form class="mb-4 mb-3" id="formReport">
                <div class="md-form active-cyan-2 mb-0">
                    <div class="row">
                        <div class="col-sm-2">
                            {{ Form::select('year', get_years(2), request('year', date('Y')), ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                        </div>
                        <div class="col-sm-3 col-md-2">
                            {{ Form::select('month', get_months('Tháng '), request('month', date('n')), ['class'=>'mr-1 mt-1 mt-md-0 w-30 browser-default custom-select']) }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($punishes->isNotEmpty())
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="pieChartTotal"></canvas>
                        <br/>
                        <div class="row">
                            <div class="col-6 text-right">
                                <h4>Chưa nộp phạt: <b class="text-danger">{{number_format($unSubmitMoney)}}</b> VNĐ</h4>
                            </div>
                            <div class="col-6">
                                <h4>Đã nộp phạt: <b class="text-success">{{number_format($submitedMoney)}}</b> VNĐ</h4>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <canvas id="pieChartLate"></canvas>
                        <br/>
                        <div class="row">
                            <div class="col-6 text-right">
                                <h4>Phạt đi muộn: <b class="text-danger">{{number_format($totalLateMoney)}}</b> VNĐ</h4>
                            </div>
                            <div class="col-6">
                                <h4>Vi phạm khác: <b class="text-success">{{number_format($otherMoney)}}</b> VNĐ</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion md-accordion mt-2 mt-xl-4" id="punish" role="tablist">
                    <table class="table">
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
                                <td class="text-right">{{$punish->infringe_date}}</td>
                                <td>{{ $punish->rule->name ?? 'Đi muộn'}}</td>
                                <td class="d-none d-md-table-cell">{{ $punish->detail }}</td>
                                <td class="text-right">{{ number_format($punish->total_money) }}</td>
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
        })
        //pie
        var ctxP = document.getElementById("pieChartTotal").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Chưa nộp phạt", "Đã nộp phạt"],
                datasets: [{
                    data: ['{{$unSubmitMoney}}', {{$submitedMoney}}],
                    backgroundColor: ["#F7464A", "#46BFBD"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
                }]
            },
            options: {
                responsive: true
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
                    backgroundColor: ["#F7464A", "#46BFBD"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endpush