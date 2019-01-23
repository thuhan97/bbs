@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('report') !!}
@endsection
@section('content')
    <div class="createReport fixed-action-btn">
        <a href="{{route('create_report')}}" class="btn-floating btn-lg red waves-effect waves-light text-white"
           title="Tạo báo cáo tuần">
            <i class="fas fa-pencil-alt"></i>
        </a>
    </div>
    <form class="mb-4 mb-3" id="formReport">
        <div class="md-form active-cyan-2 mb-0">
            <div class="row">
                <div class="col-md-4">
                    <input id="txtSearch" name="search" class="form-control" type="text"
                           placeholder="Nhập tiêu đề báo cáo" aria-label="Search" value="{{$data['search'] ?? ''}}">
                </div>
                <div class="col-md-4 show-more" style="display: none">
                    <input type="text" class="form-control w-45 float-left" id="date_from" name="date_from"
                           value="{{$data['date_from'] ?? ''}}"
                           placeholder="Từ ngày">
                    <span class="split-date">
                    -
                        </span>
                    <input type="text" class="form-control w-45 float-right" id="date_to" name="date_to"
                           value="{{$data['date_to'] ?? ''}}"
                           placeholder="Đến ngày">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary btnSearch" type="submit">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                </div>
            </div>
            <div class="row mb-3 show-more" style="display: none">
                @include('elements.team_and_staff')
                <div class="col-md-4">
                    <button class="btn btn-warning btnReset" type="reset">
                        <i class="fas fa-redo"></i>
                        Reset
                    </button>
                </div>
            </div>

        </div>

        <label class="pure-material-checkbox">
            <input type="checkbox" name="check_all" id="chkShowMore" value="1"
                   @if($data['check_all'] ?? 0) checked @endif >
            <span>Tìm thêm</span>
        </label>
    </form>
    @if($reports->isNotEmpty())
        <div class="row">
            <div class="col-md-6">
                <p>{{__l('total_record', ['number' => $reports->total()])}}</p>

                <table class="table table-striped">
                    <colgroup>

                    </colgroup>
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tuần</th>
                        <th scope="col">Ngày gửi/sửa cuối</th>
                        <th scope="col">Tiêu đề báo cáo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $idx => $report)
                        <tr data-id="{{$report->id}}" class="trReportItem">
                            <th scope="row">{{$idx + 1}}</th>
                            <td class="text-right">{{str_pad($report->week_num, 2, '0', STR_PAD_LEFT)}}</td>
                            <td>{{$report->updated_at}}</td>
                            <td>{{$report->title}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($reports->lastPage() > 1)
                    @include('common.paginate_eu', ['records' => $reports])
                @endif

            </div>
            <div class="col-md-6">
                <div class=" show-loader" style="display: none">
                    <br/>
                    <br/>
                    <br/>
                    <div class="mt-5 d-flex flex-center">
                        <div class="loader fast"></div>
                    </div>
                </div>
                <div id="div-preview">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <h5 class="card-title mb-3"></h5>
                            <div class="card-text">
                                <p>To: <span class="txtTo"></span></p>
                                <p class="content">
                                </p>
                            </div>
                            <a href="#!" target="_blank" id="btn-detail" class="btn btn-primary">Xem chi tiết</a>
                        </div>
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
                            }
                            else {
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
            $('.btnReset').click(function () {
                clearForm($('#formReport'));
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
