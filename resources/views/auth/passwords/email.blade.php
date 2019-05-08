@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header info-color white-text text-center py-4">Quên mật khẩu</h5>
                    <div class="card-body col-md-12">
                        <div class="text-center">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div>
                                    <label for="email" class=" control-label">Nhập địa chỉ email</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-center my-3 pt-3">
                                <div>
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
