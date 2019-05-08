@extends('layouts.end_user')

@section('page-title', __l('Report'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('report') !!}
@endsection
<?php
$type = request('type', 0);
$year = request('year', date('Y'));
$month = request('month', date('m'));
?>
@section('content')
    <div class="createReport fixed-action-btn">
        <a href="{{route('create_report')}}" class="btn-floating btn-lg red waves-effect waves-light text-white"
           title="Tạo báo cáo">
            <i class="fas fa-pencil-alt"></i>
        </a>
    </div>
    <form class="mb-2 mb-3" id="formReport">
        <div class="row">
            <div class="col-12 col-sm-3 col-md-3 col-xl-2 mb-2">
                <div class="md-form m-0">
                    {{ Form::select('type', REPORT_SEARCH_TYPE_NAME, $type, ['class'=>'mr-1 mt-md-0 w-30 browser-default custom-select']) }}
                </div>
            </div>
            @if($type == REPORT_SEARCH_TYPE['team'])
                <div class="col-12 col-sm-3 col-md-3 col-xl-2 mb-2">
                    <div class="md-form m-0">
                        {{ Form::select('team_id', ['' => 'Chọn team'] + $teams, request('team_id'), ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                    </div>
                </div>
            @endif
            <div class="col-6 col-sm-2 report-select-year">
                <div class="md-form m-0">
                    {{ Form::select('year', get_years(2), $year, ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2 report-select-year">
                <div class="md-form m-0">
                    {{ Form::select('month', get_months('Tháng '), $month, ['class'=>'mt-md-0 w-30 browser-default custom-select']) }}
                </div>
            </div>
        </div>
        @if($type != REPORT_SEARCH_TYPE['private'])
            <div class="row">
                <div class="col-12 col-xl-6 mb-2">
                    <div class="md-form m-0 mt-3">
                        <input type="text" id="search" name="search" value="{{request('search')}}"
                               class="form-control">
                        <label for="search">Nhập từ khóa tìm kiếm</label>
                    </div>
                </div>
            </div>
        @endif
    </form>
    @if($reports->isNotEmpty())
        <div class="row">
            <div class="col-xl-6">
                <div class="accordion md-accordion" id="report" role="tablist" aria-multiselectable="true">
                    @foreach($reports as $idx => $report)
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne{{$idx}}">
                                <a data-toggle="collapse" data-parent="#report" href="#report_item_{{$idx}}"
                                   aria-expanded="true"
                                   aria-controls="report_item_{{$idx}}"
                                   class="text-black"
                                >
                                    <h5 class="mb-0">
                                        <i class="fas fa-sticky-note"></i>
                                        {{$report->getTitle($type, $year, $month)}}

                                        <i class="fas fa-angle-down rotate-icon"></i>
                                    </h5>
                                </a>
                            </div>
                            <div id="report_item_{{$idx}}" class="collapse" role="tabpanel"
                                 aria-labelledby="headingOne{{$idx}}"
                                 data-parent="#report">
                                <div class="card-body">
                                    {!! $report->content !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <h2>{{__l('list_empty', ['name'=>'báo cáo'])}}</h2>
    @endif

@endsection
@push('extend-js')
    <script type="text/javascript" src="{{ asset('js/date-time-picker.min.js') }}"></script>

    <script>
        $(function () {
            var $divPreview = $("#div-preview");
            var $chkShowMore = $("#chkShowMore");

            function hanldeShowMore() {
                $('.show-more').slideToggle();
            }

            function clearForm($form) {
                $form.find('.form-control')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .prop('checked', false)
                    .prop('selected', false);
                $chkShowMore.click();
                $chkShowMore.removeAttr('checked');
            }

            function handleReportItemClick($tr) {
                $(' #div-preview').hide();
                $('.show-loader').fadeIn();
                var $id = $tr.data('id');
                $divPreview.find('#btn-detail').attr('href', '/bao-cao/' + $id);

                $.ajax({
                    url: '{{route('getReport')}}?id=' + $id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.code == 200 && response.data.report) {
                            var report = response.data.report;
                            if (report.user) {
                                $divPreview.find('.card-header').text(report.user.name + " [Tuần " + report.week_num + "]");
                            } else {
                                $divPreview.find('.card-header').text("Tuần " + report.week_num);
                            }
                            $divPreview.find('.card-title').text(report.title);
                            $divPreview.find('.txtTo').text(report.to_ids);
                            $divPreview.find('.content').html(report.content);
                        }
                    },
                    complete: function () {
                        $('.show-loader').hide();
                        $('#div-preview').fadeIn();
                    }
                });
            }

            $chkShowMore.change(hanldeShowMore);

            if ($chkShowMore.is(':checked')) {
                hanldeShowMore();
            }

            $('.trReportItem').click(function () {
                var that = $(this);
                that.siblings().removeClass('select');
                that.addClass('select');
                handleReportItemClick(that);
            });
            $('#formReport select').change(function () {
                $("#formReport").submit();
            });

            $('.trReportItem').first().click();

            $('#date_from').dateTimePicker({
                limitMax: $('#date_to')
            });

            $('#date_to').dateTimePicker({
                limitMin: $('#date_from')
            });
        })
    </script>
@endpush
