<?php
$baseRoute = 'admin::posts';
?>

@extends('admin._resources._simple_form', [
    'breadCrumb'=> 'admin::posts.broadcast',
    'baseRoute'=> $baseRoute,
    'formAction'=> 'admin::posts.sendBroadcast',
    'pageTitle'=> 'Thông báo nhanh',
])

@section('form-content')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('user_id') ? ' has-error' : '' }}">
                <label for="user_id">Chọn nhân viên</label>
                {{ Form::select('users_id[]', $users, null, ['id'=> 'user_id', 'class'=>'form-control selectpicker', 'multiple', 'data-live-search'=>'true']) }}
            </div>
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Tiêu đề *</label>
                <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề"
                       value="{!! old('title') !!} " required>

                @if ($errors->has('title'))
                    <div class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('content') ? ' has-error' : '' }}">
                <label for="content">Nội dung *</label>
                <input type="text" class="form-control" name="content" placeholder="Nhập nội dung bạn muốn gửi"
                       value="{!! old('content') !!} " required>

                @if ($errors->has('content'))
                    <div class="help-block">
                        <strong>{{ $errors->first('content') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('url') ? ' has-error' : '' }}">
                <label for="url">Đường dẫn</label>
                <input type="text" class="form-control" name="url" placeholder="https://bbs.hatoq.com/etc..."
                       value="{!! old('url') !!}">

                @if ($errors->has('url'))
                    <div class="help-block">
                        <strong>{{ $errors->first('url') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('footer-scripts')
    <link rel="stylesheet" type="text/css"
          href="/css/bootstrap-select.min.css"/>
    <script rel="script" src="/js/bootstrap-select.min.js"></script>

    <script>
        $(function () {
            $("#user_id").selectpicker();
        });
    </script>
@endpush
