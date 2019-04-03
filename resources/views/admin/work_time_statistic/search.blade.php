{{-- Extends Layout --}}
@extends('layouts.admin.master')
<script>
    'use strict';
    window.chartColors = {
        red: 'rgb(255, 53, 72)',
        yellow: 'rgb(255, 187, 52)',
        green: 'rgb(1, 200, 81)',
        blue: 'rgb(67, 133, 245)',
        purple: 'rgb(173, 108, 214)'
    };
    var options = {
        responsive: true,
        legend: {
            position: 'right',
        },
        title: {
            display: false,
            text: 'Chart.js Doughnut Chart'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },
        layout: {
            padding: {
                left: 0,
                right: 10,
                top: 0,
                bottom: 0
            }
        },
        // maintainAspectRatio : false,
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                        return previousValue + currentValue;
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    var precentage = Math.floor(((currentValue/total) * 100)+0.5);
                    return precentage + "%";
                }
            }
        },
        plugins: {
            labels: {
                // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
                render: 'percentage',
                // precision for percentage, default is 0
                precision: 0,
                // identifies whether or not labels of value 0 are displayed, default is false
                showZero: true,
                // font size, default is defaultFontSize
                fontSize: 14,
                // font color, can be color array for each data or function for dynamic color, default is defaultFontColor
                fontColor: '#fff',
                // font style, default is defaultFontStyle
                fontStyle: 'normal',
                // font family, default is defaultFontFamily
                fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                // draw text shadows under labels, default is false
                textShadow: true,
                // text shadow intensity, default is 6
                shadowBlur: 10,
                // text shadow X offset, default is 3
                shadowOffsetX: -5,
                // text shadow Y offset, default is 3
                shadowOffsetY: 5,
                // text shadow color, default is 'rgba(0,0,0,0.3)'
                shadowColor: 'rgba(255,0,0,0.75)',
                // draw label in arc, default is false
                // bar chart ignores this
                arc: true,
                // position to draw label, available value is 'default', 'border' and 'outside'
                // bar chart ignores this
                // default is 'default'
                position: 'default',
                // draw label even it's overlap, default is true
                // bar chart ignores this
                overlap: true,
                // show the real calculated percentages from the values and don't apply the additional logic to fit the percentages to 100 in total, default is false
                showActualPercentages: true,

                // set images when `render` is 'image'
                images: [
                    {
                        src: 'image.png',
                        width: 16,
                        height: 16
                    }
                ],
                // add padding when position is `outside`
                // default is 2
                outsidePadding: 4,
                // add margin of text when position is `outside` or `border`
                // default is 2
                textMargin: 4
            }
        }
    }
</script>
<?php
$_pageTitle = (isset($addVarsForView['_pageTitle']) && !empty($addVarsForView['_pageTitle']) ? $addVarsForView['_pageTitle'] : ucwords($resourceTitle));
$_pageSubtitle = (isset($addVarsForView['_pageSubtitle']) && !empty($addVarsForView['_pageSubtitle']) ? $addVarsForView['_pageSubtitle'] : '');
$_listLink = route($resourceRoutesAlias . '.index');
$_createLink = route($resourceRoutesAlias . '.create');
$_mutipleDeleteLink = route($resourceRoutesAlias . '.deletes');
$_listLinkExport = route($resourceRoutesAlias . '.exprot');
$tableCounter = 0;
$total = 0;
$search_type = isset($request_input['statistics']) ? $request_input['statistics'] : 1;
?>
{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Page Subtitle --}}
@section('page-subtitle', $_pageSubtitle)

{{-- Header Extras to be Included --}}
@section('head-extras')
    @parent
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-info">
        <div class="box-header with-border">
                <form class="form" role="form" method="GET" action="{{ $_listLink }}">
                    @if( isset($resourceSearchExtend))
                        @include($resourceSearchExtend, ['search' => $search, '$createLink' => $_createLink])
                    @else
                        <div class="input-group input-group-sm margin-r-5 pull-left" style="width: 200px;">
                            <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search...">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    @endif
                </form>
            <!-- END Search -->
        </div>
        <div class="box-body no-padding">
            @if($search_type == app\Services\StatisticService::TYPE_ONE)
                @if (count($work_types) > 0)
                    @include($resourceAlias.'.chart')
                    @include($resourceAlias.'.table')
                @else
                    @if (!empty($chart['months']) || !empty($chart['weeks']))
                        @include($resourceAlias.'.chart')
                    @else
                        <p class="margin-l-5 lead text-green">Không có dữ liệu.</p>
                    @endif
                @endif
            @elseif($search_type == app\Services\StatisticService::TYPE_TWO)
                @if (count($work_types) > 0)
                    @include($resourceAlias.'.chart_team')
                    @include($resourceAlias.'.table_team')
                @else
{{--                    @include($resourceAlias.'.chart_team')--}}
                    <p class="margin-l-5 lead text-green">Không có dữ liệu.</p>
                @endif
            @elseif($search_type == app\Services\StatisticService::TYPE_THREE)
                @if (count($work_types) > 0)
                    @include($resourceAlias.'.chart_user')
                    @include($resourceAlias.'.table_user')
                @else
{{--                    @include($resourceAlias.'.chart_user')--}}
                    <p class="margin-l-5 lead text-green">Không có dữ liệu.</p>
                @endif
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
    @include('admin._resources._list-footer-extras', ['sortByParams' => []])
@endsection

@push('footer-scripts')

@endpush