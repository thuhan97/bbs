@extends('layouts.end_user')
@section('page-title', __l('Punish'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('punish') !!}
@endsection
@php
    $totalMoney = $punishes->sum('total_money');
    $unSubmitMoney = $punishes->where('is_submit', PUNISH_SUBMIT['new'])->sum('total_money');
    $submitedMoney = $totalMoney - $unSubmitMoney;
@endphp
@section('content')
    <form class="mb-4 mb-3" id="formReport">
        <div class="md-form active-cyan-2 mb-0">
            <div class="row">
                <div class="col-sm-1">
                    {{ Form::select('year', get_years(2), request('year', date('Y')), ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::select('month', get_months('Tháng '), request('month', date('n')), ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </form>
    @if($punishes->isNotEmpty())
        <div class="row">
            <div class="col-md-5">
                <canvas id="pieChart"></canvas>
                <br/>
                <div class="row">
                    <div class="col-6 text-right">
                        <h4>Tiền phạt: <b class="text-danger">{{number_format($totalMoney)}}</b> VNĐ</h4>
                    </div>
                    <div class="col-6">
                        <h4>Đã nộp phạt: <b class="text-success">{{number_format($submitedMoney)}}</b> VNĐ</h4>
                    </div>
                </div>

            </div>
            <div class="col-md-7">
                <div class="accordion md-accordion" id="punish" role="tablist">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ngày vi phạm</th>
                            <th scope="col">Xử phạt</th>
                            <th scope="col">Ghi chú</th>
                            <th scope="col">Số tiền</th>
                            <th scope="col">Đã nộp tiền</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($punishes as $idx => $punish)
                            <tr>
                                <th scope="row">{{$idx + 1}}</th>
                                <td class="text-right">{{$punish->infringe_date}}</td>
                                <td>{{ $punish->rule->name ?? 'Đi muộn'}}</td>
                                <td>{{ $punish->detail }}</td>
                                <td class="text-right">{{ number_format($punish->total_money) }}</td>
                                <td class="text-center">
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
                @if ($punishes->lastPage() > 1)
                    @include('common.paginate_eu', ['records' => $punishes])
                @endif
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
        var ctxP = document.getElementById("pieChart").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Chưa nộp phạt", "Đã nộp phạt", "Phạt đi muộn"],
                datasets: [{
                    data: ['{{($unSubmitMoney)}}', {{($submitedMoney)}}, 0],
                    backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endpush