@extends('layouts.end_user')

@section('page-title', __l('Report'))
@section('breadcrumbs')
    {!! Breadcrumbs::render('report') !!}
@endsection
<?php
$user = \Illuminate\Support\Facades\Auth::user();
$year = request('year', date('Y'));
$month = request('month', date('m'));
if ($user->isMaster() || $user->isGroupManager()) {
    $teamId = 0;
}
if ($teamId != 0) {
    $reportType = 2;
} else {
    $reportType = 1;
}
$type = request('type', $reportType);

?>
@section('content')
    <div class=" fixed-action-btn">
        <a href="#" onclick="location.href='{{route('create_report')}}'"
           class="btn-floating btn-lg red waves-effect waves-light text-white"
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
                        {{ Form::select('team_id', ['' => 'Chọn team'] + $teams, request('team_id', $teamId), ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                    </div>
                </div>
            @endif
            <div class="col-6 col-sm-2 col-xxl-1 report-select-year">
                <div class="md-form m-0">
                    {{ Form::select('year', get_years(2), $year, ['class'=>'mr-1 w-30 browser-default custom-select']) }}
                </div>
            </div>
            <div class="col-6 col-sm-3 col-md-2 col-xxl-1 report-select-year">
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
        @foreach($reports as $idx => $report)
            <div class="accordion md-accordion" id="report" role="tablist" aria-multiselectable="true">

                <div class="card">
                    <div class="card-header" role="tab" id="headingOne{{$idx}}" data-id="{{$report->id}}">
                        <a data-toggle="collapse" data-parent="#report" href="#report_item_{{$idx}}"
                           aria-expanded="true"
                           aria-controls="report_item_{{$idx}}"
                           class="text-black"
                        >
                            <h5 class="mb-0">
                                <i class="fas fa-sticky-note"
                                   @if($report->color_tag) style="color: {{$report->color_tag}}" @endif></i>
                                {{$report->getTitle($type, $year, $month)}}

                                <i class="fas fa-angle-down rotate-icon"></i>
                            </h5>
                        </a>
                    </div>
                    <div id="report_item_{{$idx}}" class="collapse row" role="tabpanel"
                         aria-labelledby="headingOne{{$idx}}"
                         data-parent="#report">
                        <div class="col-xl-6 report-item">
                            <div>
                                <div class="card-body">
                                    <div class="pl-2 mb-3">Gửi cho:
                                        @if($report->to_ids)
                                            {{$report->to_ids}}
                                        @else
                                            @foreach($report->receivers as $receiver)
                                                <span class="report-receiver @if($receiver->id == \Illuminate\Support\Facades\Auth::id()) me @endif">
                                                    <img src="{{$receiver->avatar}}" class="rounded-circle">
                                                    <span>{{$receiver->name}}</span>
                                                </span>
                                            @endforeach
                                        @endif

                                    </div>

                                    {!! $report->content !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 reply-content">
                            <label for="reply_{{$report->id}}" for="content">Gửi nhận xét</label>
                            <textarea id="reply_{{$report->id}}" class="md-form md-textarea w-100"></textarea>
                            <button class="btn ml-0 btn-danger btnSendReply" data-id="{{$report->id}}">Gửi nhận xét
                            </button>
                            <div class="replies">
                                <div class="media mt-2 mb-2">
                                    <img class="d-flex rounded-circle avatar z-depth-1-half mr-3" width="100"
                                         height="100"
                                         src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg"
                                         alt="Avatar">
                                    <div class="media-body">
                                        <h5 class="mt-0 font-weight-bold blue-text">Anna Smith</h5>
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                                        sollicitudin. Cras purus
                                        odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                                        ac nisi vulputate
                                        fringilla. Donec lacinia congue felis in faucibus.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        @endforeach

        <div id="tempReply" style="display: none">
            <div class="media mt-2 mb-2">
                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3" width="100" height="100"
                     src=""
                     alt="">
                <div class="media-body">
                    <h5 class="mt-0 font-weight-bold blue-text full_name"></h5>
                    <div class="content">
                    </div>
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
            $('#formReport select').change(function () {
                $("#formReport").submit();
            });

            $('#date_from').dateTimePicker({
                limitMax: $('#date_to')
            });

            $('#date_to').dateTimePicker({
                limitMin: $('#date_from')
            });
            $(".btnSendReply").click(function () {
                var $template = $("#tempReply").children().first().clone();
                var reportId = $(this).data('id');
                var $textArea = $('#reply_' + reportId);
                var content = tinymce.get('reply_' + reportId).getContent();
                tinymce.get('reply_' + reportId).setContent('');

                $template.find('.avatar').attr('src', '{{\Illuminate\Support\Facades\Auth::user()->avatar}}');
                $template.find('.avatar').attr('alt', '{{\Illuminate\Support\Facades\Auth::user()->name}}');
                $template.find('.full_name').html('{{\Illuminate\Support\Facades\Auth::user()->name}}');
                $template.find('.content').html(content);

                $(this).next().prepend($template);


            });
            $('.card-header').click(function () {
                var reportId = $(this).data('id');

                var $textArea = $('#reply_' + reportId);
                if (!$textArea.hasClass('initialized')) {
                    tinymce.init({
                        selector: 'textarea#reply_' + reportId,
                        paste_data_images: true,
                        height: '80px',
                        plugins: [
                            "advlist autolink lists link charmap preview hr anchor pagebreak paste textcolor colorpicker",
                        ],
                        toolbar1: "insertfile undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
                    });

                    $textArea.addClass('initialized');
                }
            });
        });


    </script>
@endpush
