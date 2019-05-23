@extends('layouts.end_user')
@section('page-title', __l('Report_create'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('report_create') !!}
@endsection
@section('content')
    <form class="mb-4 mb-3" method="post" action="{{route('save_report')}}">
        @csrf
        <div class="row">
            <input type="hidden" name="is_new" value="{{$report->is_new}}">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-warning" name="status" value="0">
                            <i class="fas fa-save"></i>
                            {{__l('save_as_draft')}}</button>
                        <button type="submit" class="btn btn-primary" name="status" value="1">
                            <i class="fas fa-paper-plane"></i>
                            {{__l('sent')}}</button>
                    </div>
                </div>
                <label for="choose_week">Hình thức báo cáo</label>
                <div class="md-form mt-1 mb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <select id="choose_week" name="choose_week" class="browser-default custom-select">
                                <option value="{{date('d/m')}}">Báo cáo ngày [{{date('d/m')}}]</option>
                                <option value="{{date('d/m', strtotime('- 1 days'))}}">Báo cáo ngày
                                    [{{date('d/m', strtotime('- 1 days'))}}]
                                </option>
                                <option value="{{date('d/m', strtotime('- 2 days'))}}">Báo cáo ngày
                                    [{{date('d/m', strtotime('- 2 days'))}}]
                                </option>
                                <option selected value="0">Báo cáo tuần {{get_week_info(0)}}</option>
                                <option value="1">Báo cáo tuần {{get_week_info(1)}}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <!-- Material inline 1 -->
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="materialInline1" name="is_private"
                                       value="{{REPORT_PUBLISH}}" checked>
                                <label class="form-check-label" for="materialInline1">Toàn công ty</label>
                            </div>

                            <!-- Material inline 2 -->
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="materialInline2" name="is_private"
                                       value="{{REPORT_PRIVATE}}">
                                <label class="form-check-label" for="materialInline2">Nội bộ team</label>
                            </div>
                        </div>

                    </div>
                </div>
                <label class="mt-3" for="to_ids">Bạn gửi báo cáo cho ai?</label>
                <div class="md-form mt-1 mb-0">
                    <select class="mdb-select md-form" multiple searchable="Tìm người nhận ..." name="to_ids[]">
                        <option disabled>Chọn người gửi báo cáo</option>
                        @foreach($receivers as $groupName => $users)
                            <optgroup label="{{$groupName}}">
                                @foreach($users as $user)
                                    <option value="{{$user['id']}}"
                                            data-icon="{{$user['avatar']}}"
                                            class="rounded-circle">{{$user['name']}}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('to_ids'))
                    <div class="red-text">
                        <strong>{{ $errors->first('to_ids') }}</strong>
                    </div>
                @endif
                <label class="mt-3" for="content">Nội dung báo cáo</label>
                <div class="md-form mt-1 mb-0">
                    <i class="fas fa-pencil-alt prefix grey-text"></i>
                    <textarea type="text" id="content" name="content"
                              class="md-textarea form-control">{{old('content', $report->content)}}</textarea>
                    @if ($errors->has('content'))
                        <div class="red-text">
                            <strong>{{ $errors->first('content') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection

@push('extend-js')
    <script src="{{cdn_asset('/js/tinymce/tinymce.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.mdb-select').materialSelect();
        });
        tinymce.init({
            selector: 'textarea',
            paste_data_images: true,
            height: '350px',
            plugins: [
                "advlist autolink lists charmap preview hr anchor pagebreak",
            ],
        });</script>
@endpush
