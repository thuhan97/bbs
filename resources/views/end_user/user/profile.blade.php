@extends('layouts.end_user')
@section('page-title', __l('Profile'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('profile') !!}
@endsection
@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <form method="post" action="{{route('save_profile')}}" enctype="multipart/form-data">
        @csrf
        <div class=" container mb-3">
            <div class="row">
                <div class="col-md-7">
                    <h3 class="text-left title-profile bold">Hồ sơ cá nhân</h3>
                </div>
                <div class="col-md-5" style="padding-right: 0">
                    <div class="float-right">
                        <button class="btn btn-primary float-right save  hidden " type="submit"><i
                                    class="fa fa-save mr-1"></i>
                            Lưu
                        </button>
                        <button class="btn btn-default float-right   btn-close hidden "><i class="fa fa-times mr-1"></i>Đóng
                        </button>
                        <button class="btn btn-danger float-right   btn-edit-profile "><i class="fa fa-edit mr-1"></i>
                            Sửa
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="container profile" style="">
            <div class="row">

                <div class="col-md-6 float-left">
                    @if($errors->any())
                        <div class="mt-4">
                            <strong class="red-text">* Có lỗi xảy ra: </strong>
                            @foreach ($errors->all() as $error)
                                <div class="red-text"> - {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <h3 class="name-profile bold my-3">{{$user->name}} - {{$user->staff_code}} </h3>
                    <hr/>
                    <table class="table table-borderless ">
                        <tr>
                            <td>Chức vụ:</td>
                            <td>{{ array_key_exists($user->position_id,POSITIONS) ? POSITIONS[ $user->position_id ] : '' }} </td>
                        </tr>
                        <tr>
                            <td>Team:</td>
                            <td>{{ $user->team()->name ?? ''}} </td>
                        </tr>
                        <tr>
                            <td>Ngày sinh:</td>
                            <td>{{$user->birthday}} </td>
                        </tr>
                        <tr>
                            <td>Giới tính:</td>
                            <td>{!!($user->sex==0)? "Nam":"Nữ" !!}</td>
                        </tr>
                        <tr>
                            <td>Điện thoại:</td>
                            <td>{{$user->phone}} </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{$user->email}} </td>
                        </tr>

                    </table>
                </div>
                <div class="col-md-6 ">
                    <div class="md-form">
                        <div class="file-field float-right">
                            <div class=" mb-4 ">
                                <img src="{{$user->avatar}}" id="output"
                                     alt="example placeholder avatar" width="200px" height="200px" class="float-right">
                            </div>
                            <div class="clearfix"></div>
                            <div class="d-flex justify-content-center">
                                <div class="btn btn-mdb-color btn-rounded text-center hidden">
                                    <span class="changeImage">Đổi ảnh</span>
                                    <input type="file" accept="image/*" name="avatar" onchange="loadFile(event)">

                                </div>
                            </div>
                            @if ($errors->has('avatar'))
                                <p class="red-text">{{ $errors->first('avatar') }}</p>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Lý lịch</div>
                    <div class="form-group row mt-3">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Nguyên quán</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="text" name="address" class="form-control " id="inputEmail3MD"
                                       value="{{$user->address}}" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Chỗ ở hiện tại</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="text" name="current_address" class="form-control enable" id="inputEmail3MD"
                                       value="{{old('current_address', $user->current_address)}}" disabled="true"
                                       required>
                                <i class="fas fa-pencil-alt float-right"><span
                                            class="float-left required hidden">(*)</span></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Chứng minh nhân dân</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="text" class="id_card" class="form-control" id="inputEmail3MD"
                                       value="{{$user->id_card}}" disabled="true">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Nơi cấp</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="text" class="form-control" id="inputEmail3MD" value="{{$user->id_addr}}"
                                       disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Học vấn (Đại học, Cao Đẳng, ...)</div>
                    <div class="md-form ">
                        <!-- Material input -->
                        <input type="text" name="school" class="form-control enable" id="inputEmail3MD"
                               value="{{ old('school', $user->school)}}" disabled="true" required>
                        <i class="fas fa-pencil-alt float-right"><span class="float-left required hidden">(*)</span></i>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Tài khoản</div>
                    <div class="form-group row mt-3">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Gmail</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="email" name="gmail" class="form-control enable" id="inputEmail3MD"
                                       value="{{old('gmail', $user->gmail)}}" disabled="true">
                                <i class="fas fa-pencil-alt float-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Gitlab</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="text" name="gitlab" class="form-control enable" id="inputEmail3MD"
                                       value="{{ old('gitlab', $user->gitlab) }}" disabled="true">
                                <i class="fas fa-pencil-alt float-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Material input -->
                        <label for="inputEmail3MD" class="col-sm-3 col-form-label">Chatwork</label>
                        <div class="col-sm-9">
                            <div class="md-form mt-0">
                                <input type="text" name="chatwork" class="form-control enable" id="inputEmail3MD"
                                       value="{{old('chatwork', $user->chatwork)}}" disabled="true">
                                <i class="fas fa-pencil-alt float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Kỹ năng</div>
                    <div class="md-form mt-0 ">
                        <textarea type="text" name="skills" class=" md-textarea md-textarea-auto form-control enable "
                                  id="inputEmail3MD " disabled="true"
                                  height="100px">{{old('skills', $user->skills)}}</textarea>
                        <i class="fas fa-pencil-alt float-right"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Mục tiêu tương lai</div>
                    <div class="md-form mt-0">
                        <textarea type="text" name="in_future" class="md-textarea md-textarea-auto form-control enable"
                                  id="inputEmail3MD" disabled="true">{{ old('in_future', $user->in_future)}}</textarea>
                        <i class="fas fa-pencil-alt float-right"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Sở thích</div>
                    <div class="md-form mt-0">
                        <textarea type="text" name="hobby" class="md-textarea md-textarea-auto form-control enable"
                                  id="inputEmail3MD" disabled="true">{{old('hobby', $user->hobby)}}</textarea>
                        <i class="fas fa-pencil-alt float-right"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="index-profile">Ngoại ngữ</div>
                    <div class="md-form mt-0">
                        <textarea type="text" name="foreign_language"
                                  class="md-textarea md-textarea-auto form-control enable" id="inputEmail3MD"
                                  disabled="true">{{old('foreign_language',$user->foreign_language)}}</textarea>
                        <i class="fas fa-pencil-alt float-right"></i>
                    </div>
                </div>
            </div>
            <p><span class="required">Ghi chú: (*) là trường bắt buộc.</span></p>
        </div>
        <div class="clearfix"></div>
        <div class="container">
            <div class="row float-right">
                <button class="btn btn-primary float-right save  hidden " type="submit"><i class="fa fa-save mr-1"></i>
                    Lưu
                </button>
                <button class="btn btn-default float-right   btn-close hidden "><i class="fa fa-times mr-1"></i> Đóng
                </button>
                <button class="btn btn-danger float-right   btn-edit-profile "><i class="fa fa-edit mr-1"></i> Sửa
                </button>
            </div>
        </div>
    </form>

    <br/>
    <br/>
    <br/>
    <script type="text/javascript">
        $(".btn-edit-profile").click(function (event) {
            event.preventDefault();
            $(".enable").prop("disabled", false);
            $(".md-form .fas").css("display", "block");
            $(".hidden").css("display", "block");
            $(".btn-edit-profile").css("display", "none")

        });
        $('.btn-close').click(function (event) {
            event.preventDefault();
            //console.log(123)
            location.reload();
        });

        var loadFile = function (event) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
                console.log(output.src)
            };
            reader.readAsDataURL(event.target.files[0]);
        };


    </script>
@endsection

@push('extend-css')
    <style>
        table.table td, table.table th {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .form-group, .md-form {
            margin-bottom: 0.5rem;
        }
    </style>
@endpush