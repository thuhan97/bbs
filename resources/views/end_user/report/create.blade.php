@extends('layouts.end_user')
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
                <label for="choose_week">Chọn tuần</label>
                <div class="md-form mt-1 mb-0">
                    <select id="choose_week" name="choose_week" class="browser-default custom-select w-50">
                        <option selected value="0">Tuần {{get_week_info(0)}}</option>
                        <option value="-1">Tuần {{get_week_info(-1)}}</option>
                    </select>
                </div>
                <label class="mt-3" for="to_ids">Tiêu đề báo cáo</label>
                <div class="md-form mt-1 mb-0">
                    <input type="text" id="title" name="title" class="form-control"
                           value="{{old('title', $report->title)}}"
                           required>
                </div>
                @if ($errors->has('title'))
                    <div class="red-text">
                        <strong>{{ $errors->first('title') }}</strong>
                    </div>
                @endif
                <label class="mt-3" for="to_ids">Người nhận</label>
                <div class="md-form mt-1 mb-0">
                    <input type="text" id="to_ids" name="to_ids" class="form-control"
                           value="{{old('to_ids', $report->to_ids)}}"
                           required>
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
//            $('.mdb-select').materialSelect();
        });
        tinymce.init({
            selector: 'textarea',
            paste_data_images: true,
            height: '350px',

        });</script>
@endpush