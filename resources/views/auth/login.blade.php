@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <br/>
                <br/>
                <br/>
                <!-- Material form login -->
                <div class="card">

                    <h5 class="card-header info-color white-text text-center py-4">
                        <strong>BBS System</strong>
                    </h5>

                    <!--Card content-->
                    <div class="card-body px-lg-5 pt-4">
                        <!-- Form -->
                        <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            @if ($error = $errors->first('email'))
                                <div class="alert alert-danger ">
                                    {{ $error }}
                                </div>
                                <br/>
                        @endif

                        <!-- Email -->
                            <div class="md-form mt-2">
                                <input type="text" id="email" name="email" class="form-control" required
                                       value="{{ old('email') }}">
                                <label for="email">E-mail</label>
                            </div>

                            <!-- Password -->
                            <div class="md-form">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <label for="password">Mật khẩu</label>
                            </div>

                            <div class="d-flex justify-content-around">
                                <div>
                                    <!-- Remember me -->
                                    <label class="pure-material-checkbox">
                                        <input type="checkbox" name="remember">
                                        <span>Nhớ đăng nhập</span>
                                    </label>
                                </div>
                                <div>
                                    <!-- Forgot password -->
                                    <a href="{{url('/password/reset')}}">Quên mật khẩu?</a>
                                </div>
                            </div>

                            <!-- Sign in button -->
                            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                                    type="submit">Đăng nhập
                            </button>
                        </form>
                        <!-- Form -->

                    </div>

                </div>
                <!-- Material form login -->
            </div>
        </div>
    </div>
@endsection
