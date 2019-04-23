@extends('layouts.end_user')
@section('page-title', __l('change_password'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('change_password') !!}
@endsection
@section('content')

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form class="mb-4 mb-3" method="post" action="{{route('update_password')}}">
                @csrf
                <div class="card mt-5">

                    <div class="card-header">
                        Đổi mật khẩu
                    </div>
                    <div class="card-body">
                        <div class="md-form">
                            <input type="password" id="current_password" name="current_password" class="form-control"
                                   required value="{{old('current_password')}}">
                            <label for="current_password">Mật khẩu hiện tại</label>
                        </div>
                        @if ($errors->has('current_password'))
                            <div class="red-text">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </div>
                        @endif
                        <div class="md-form">
                            <input type="password" id="confirmation" name="password" class="form-control" required>
                            <label for="confirmation">Mật khẩu mới</label>
                        </div>
                        @if ($errors->has('password'))
                            <div class="red-text">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                        <div class="md-form">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" required>
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" name="status" value="0">
                                <i class="fas fa-save"></i>
                                {{__l('update')}}</button>
                            <a href="#" onclick="window.history.back()" class="btn btn-warning">
                                <i class="fas fa-times"></i>
                                {{__l('cancel')}}</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection