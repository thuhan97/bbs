@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <br/>
                <br/>
                <br/>
                <div class="card">
                    <h5 class="card-header info-color white-text text-center py-4">Đặt lại mật khẩu</h5>

                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group mb-3" >
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-12">
                                    <input id="email" readonly type="email" class="form-control" name="email"
                                           value="{{ $email }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} my-5">
                                <label for="password" class="col-md-4 control-label">Mật khẩu</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Xác nhận mật khẩu</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group form-group d-flex justify-content-center my-5 pt-3">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">
                                        Reset mật khẩu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
