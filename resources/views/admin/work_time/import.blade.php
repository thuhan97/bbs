<?php
$baseRoute = 'admin::work_times';
?>

@extends('admin._resources._simple_form', [
    'breadCrumb'=> 'admin::work_times.import',
    'baseRoute'=> $baseRoute,
    'formAction'=> 'admin::work_times.import',
    'pageTitle'=> 'Nhập dữ liệu từ máy chấm công',
])

@section('form-content')
    <?php
    $hasError = isset($import_errors) && is_array($import_errors) && !empty($import_errors);
    ?>
    @if(isset($message))
        <div class="col-md-12">
            @if($hasError)
                <div class="callout callout-danger">
                    <h4>
                        <i class="icon fa fa-ban"></i>
                        Error!
                    </h4>
                    {{ $message }}
                </div>
            @else
                <div class="callout callout-success">
                    <h4>
                        <i class="icon fa fa-check"></i>
                        Success!
                    </h4>
                    {{ $message }}
                </div>
            @endif
        </div>

    @endif
    @if ($hasError)
        <div class="col-md-12">
            <div class="has-error">
                @foreach($import_errors as $error)
                    <span class="help-block">
                                                {{ $error }}
                                    </span>
                @endforeach
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-2">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('year') ? ' has-error' : '' }}">
                <label for="year">Chọn năm</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {{ Form::select('year', get_years(2, 'Năm '), request('year', date('Y')), ['class'=>'form-control']) }}
                </div>
                @if ($errors->has('year'))
                    <span class="help-block">
                    <strong>{{ $errors->first('year') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('month') ? ' has-error' : '' }}">
                <label for="month">Chọn tháng</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {{ Form::select('month', get_months('Tháng ', true), request('month'), ['class'=>'form-control']) }}
                </div>
                @if ($errors->has('month'))
                    <span class="help-block">
                    <strong>{{ $errors->first('month') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <p class="text-primary">
        hoặc
    </p>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_date') ? ' has-error' : '' }}">
                <label for="start_date">Từ ngày</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker"
                           name="start_date" autocomplete="off"
                           value="{{ old('start_date') }}" id="start_date">
                </div>
                @if ($errors->has('start_date'))
                    <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('end_date') ? ' has-error' : '' }}">
                <label for="end_date">Đến ngày</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker"
                           name="end_date" autocomplete="off"
                           value="{{ old('end_date') }}" id="end_date">
                </div>
                @if ($errors->has('end_date'))
                    <span class="help-block">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group{{ ($errors->has('import_file') || $errors->has('ext')) ? ' has-error' : '' }}">
        <label for="importFile">Chọn file</label>
        <input type="file" name="import_file" id="importFile" required
               accept=".xls, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
        @if ($errors->has('import_file'))
            <span class="help-block">
                                <strong>{{ $errors->first('import_file') }}</strong>
                            </span>
        @endif
        @if ($errors->has('ext'))
            <span class="help-block">
                                <strong>{{ $errors->first('ext') }}</strong>
                            </span>
        @endif
        <p class="help-block">Tải lên mẫu chấm công (.xls, .xlsx)</p>
    </div>

    <a href="/admin/work_times/download-template"><i class="fa fa-download"></i> Tải file mẫu!</a>
@endsection
@push('footer-scripts')
    <style>
        .datepicker-days table tbody tr td:nth-child(1),
        .datepicker-days table thead tr th.dow:nth-child(1),
        .datepicker-days table tbody tr td:nth-child(7),
        .datepicker-days table thead tr th.dow:nth-child(7) {
            background: #e2e2e2;
        }
    </style>
    <script>

        $(function () {
            myDatePicker($("#start_date, #end_date"));
        })
    </script>
@endpush
