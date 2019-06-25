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
        <div class="row mt-4">
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
                    <div class="card-header pr-0 pl-0" role="tab" id="headingOne{{$idx}}" data-id="{{$report->id}}">
                        <a data-toggle="collapse" data-parent="#report" href="#report_item_{{$report->id}}"
                           aria-expanded="true"
                           aria-controls="report_item_{{$report->id}}"
                           class="text-black"
                        >
                            <h5 class="mb-0">
                                <i class="fas @if($report->report_type) fa-sticky-note @else fa-flag @endif"
                                   @if($report->color_tag) style="color: {{$report->color_tag}}" @endif></i>

                                {{$report->getTitle($type, $year, $month, \Illuminate\Support\Facades\Auth::id())}}
                                <i class="fas fa-angle-down rotate-icon"></i>
                                <span class="txt-time float-right mr-2">
                                    <?php
                                    $inReport = $report->receivers->firstWhere('id', auth()->id());

                                    if (!$inReport)
                                        $inReport = $report->reportReplies->firstWhere('user_id', auth()->id());
                                    $totalReply = $report->reportReplies->count();
                                    ?>
                                    @if($inReport && $totalReply)
                                        <i class="fas fa-comments text-warning" title="{{$totalReply}} phản hồi">
                                            <span class="badge badge-info">{{$totalReply}}</span>
                                        </i>
                                    @endif
                                    <i class="fas fa-clock" title="{{$report->created_at}}"></i>
                                    <span class="time-subcribe"
                                          data-time="{{$report->created_at}}">{{get_beautiful_time($report->created_at)}}</span></span>

                            </h5>
                        </a>
                    </div>
                    <div id="report_item_{{$report->id}}" class="collapse row" role="tabpanel"
                         aria-labelledby="headingOne{{$idx}}"
                         data-parent="#report">
                        <div class="col-xl-6 report-item">
                            <div>
                                <div class="card-body p-0">
                                    @if(\Illuminate\Support\Facades\Auth::user()->can('delete', $report))
                                        <div class="text-right">
                                            <a href="{{route('deleteReport', $report->id)}}" class="btn btn-danger"><i
                                                        class="fa fa-trash"></i> Xóa</a>
                                        </div>
                                    @endif
                                    <div class="pl-2 mb-3 sent-to">
                                        Gửi cho:
                                        <div class="mt-2">
                                            @if($report->to_ids)
                                                {{$report->to_ids}}
                                            @else
                                                @foreach($report->receivers as $receiver)
                                                    <div class="float-left mb-2 report-receiver @if($receiver->id == \Illuminate\Support\Facades\Auth::id()) me @endif">
                                                        <img src="{{$receiver->avatar}}" class="rounded-circle"
                                                             onerror="this.src='{{URL_IMAGE_NO_AVATAR}}'">
                                                        <span>{{$receiver->name}}</span>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div>
                                        {!! $report->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 reply-content">
                            <div class="form-reply" style="display: none">
                                <label for="reply_{{$report->id}}" for="content">Gửi nhận xét</label>
                                <textarea id="reply_{{$report->id}}" class="md-form md-textarea w-100"></textarea>
                                <button class="btn ml-0 btn-danger btnSendReply" data-id="{{$report->id}}">Gửi nhận xét
                                </button>
                            </div>

                            <div class="replies mt-2">
                                @foreach($report->reportReplies as $reply)
                                    @if($reply->user)
                                        <div class="media mt-2 mb-2">
                                            <img class="d-flex rounded-circle avatar z-depth-1-half mr-3"
                                                 src="{{$reply->user->avatar}}"
                                                 alt="{{$reply->user->name}}">
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h6 class="mt-0 blue-text">{{$reply->user->name}}</h6>
                                                    </div>
                                                    <div class="col-6 text-right created_at">
                                                        @if($reply->created_at)
                                                            {{$reply->created_at->format(DATE_FORMAT)}}
                                                            <span>{{$reply->created_at->format(TIME_FORMAT)}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    {!! $reply->content !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        @endforeach

        <div id="tempReply" style="display: none">
            <div class="media mt-2 mb-2">
                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3"
                     src=""
                     alt="">
                <div class="media-body">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="mt-0 blue-text full_name"></h6>
                        </div>
                        <div class="col-6 text-right created_at"></div>
                    </div>
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
    <script type="text/javascript" src="{{ asset_ver('js/date-time-picker.min.js') }}"></script>

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
                var reportId = $(this).data('id');
                var $textArea = $('#reply_' + reportId);
                var content = tinymce.get('reply_' + reportId).getContent();
                if (content) {
                    var avatar = '{{\Illuminate\Support\Facades\Auth::user()->avatar}}';
                    var name = '{{\Illuminate\Support\Facades\Auth::user()->name}}';
                    commentReport(reportId, name, avatar, content, true);

                    $.ajax({
                        url: '{{route('reply_report')}}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {content: content, report_id: reportId},
                        success: function (q) {
                        },
                        error: function () {
                            $template.remove();
                        }
                    });
                }
            });

            function openReport(header) {
                var $that = $(header);
                var reportId = $(header).data('id');

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
                        setup: function (editor) {
                            editor.on('init', function () {
                                $that.next().find('.form-reply').slideDown();
                            });
                        }
                    });

                    $textArea.addClass('initialized');
                }
            }

            $('.card-header').click(function () {
                openReport(this);
            });

            if (location.hash) {
                var aTag = $("a[href='" + location.hash + "']");
                aTag.click();
                openReport(aTag.parent()[0]);
            }
        });

        window.commentReport = function (reportId, name, avatar, content, clearContent) {
            var date = new Date();
            var $template = $("#tempReply").children().first().clone();
            if (clearContent)
                tinymce.get('reply_' + reportId).setContent('');

            $template.find('.avatar').attr('src', avatar);
            $template.find('.avatar').attr('alt', name);
            $template.find('.full_name').text(name);

            $template.find('.created_at').text('vừa xong');
            $template.find('.content').html(content);

            $("#report_item_" + reportId).find('.replies').prepend($template);
        }

    </script>
@endpush

@push('extend-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush
