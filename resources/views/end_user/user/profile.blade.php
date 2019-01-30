@extends('layouts.end_user')
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
    <!-- <i class="fas fa-camera-retro"></i> fa-camera-retro -->
    <button class="btn btn-primary float-right save " disabled="true" type="submit"><i class="fas fa-save mr-1"></i> Lưu</button>
    <div class="clearfix"></div>
    <div class="container profile" style="width: 70%;">
        <h1 class="text-center title-profile bold">Hồ sơ cá nhân</h1>

    	<div class="row">
    		<div class="col-md-6 float-left">
                <!-- <div class="md-form mt-1 mb-0">
                    <input type="text" name="" class="form-control">
                </div> -->
    			<h3 class="name-profile bold">{{$user->name}} </h3>
                <h5 class="possition-profile bold">Mã nhân viên: {{$user->staff_code}} </h5>
                <table class="table table-borderless ">
                    <tr>
                        <td >Ngày sinh:</td>
                        <td>{{$user->birthday}} </td>
                    </tr>
                     <tr>
                        <td>Giới tính:</td>
                        <td>{!!($user->gender==0)? "Nam":"Nữ" !!}</td>
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
                          <img src="{{($user->avatar== URL_IMAGE_NO_IMAGE)? URL_IMAGE_NO_IMAGE: asset('uploads/'.$user->avatar)}}" id="output" 
                            alt="example placeholder avatar" width="200px" height="200px">
                        </div>
                        <div class="d-flex justify-content-center">
                          <div class="btn btn-mdb-color btn-rounded float-left hidden">
                            <span class="changeImage">Đổi ảnh</span>
                            <input type="file" name="avatar" onchange="loadFile(event)">
                          </div>

                        </div>
                                }
                        </div>
                      </div>
                    </div>
    		    </div>

    	    </div>
        <div class="clearfix"></div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile" >Lý lịch</div>
                 <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD" class="col-sm-3 col-form-label">Địa chỉ thường trú</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="text" name="address" class="form-control enable" id="inputEmail3MD" value="{{$user->address}}" disabled="true" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD"  class="col-sm-3 col-form-label">Chỗ ở hiện tại</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="text" name="current_address" class="form-control enable" id="inputEmail3MD" value="{{$user->current_address}}" disabled="true" required>
                        <i class="fas fa-pencil-alt float-right" ></i>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD" class="col-sm-3 col-form-label">Chứng minh nhân dân</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="text" class="id_card"  class="form-control" id="inputEmail3MD" value="{{$user->id_card}}" disabled="true">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD" class="col-sm-3 col-form-label">Nơi cấp</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="text"  class="form-control" id="inputEmail3MD" value="{{$user->id_addr}}" disabled="true">
                      </div>
                    </div>
                  </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile" >Học vấn</div>
                 <div class="md-form ">
    <!-- Material input -->
                     <input type="text" name="school" class="form-control enable" id="inputEmail3MD" value="{{$user->school}}" disabled="true" required>
                     <i class="fas fa-pencil-alt float-right"></i>
                </div>
                    
            </div>
                 
            
        </div>
              
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile" >Tài khoản</div>
                 <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD" class="col-sm-3 col-form-label">Gmail</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="email" name="gmail" class="form-control enable" id="inputEmail3MD" value="{{$user->gmail}}" disabled="true">
                        <i class="fas fa-pencil-alt float-right"></i>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD" class="col-sm-3 col-form-label">Gitlab</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="text" name="gitlab" class="form-control enable" id="inputEmail3MD" value="{{$user->gitlab}}" disabled="true">
                        <i class="fas fa-pencil-alt float-right"></i>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
    <!-- Material input -->
                    <label for="inputEmail3MD"  class="col-sm-3 col-form-label">Chatwork</label>
                    <div class="col-sm-9">
                      <div class="md-form mt-0">
                        <input type="text" name="chatwork" class="form-control enable" id="inputEmail3MD" value="{{$user->chatwork}}" disabled="true">
                        <i class="fas fa-pencil-alt float-right"></i>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile">Kỹ năng</div>
                 <div class="md-form mt-0 " >
                    <textarea type="text"  name="skills" class=" md-textarea md-textarea-auto form-control enable " id="inputEmail3MD " disabled="true" height="100px">{{$user->skills}}</textarea>
                    <i class="fas fa-pencil-alt float-right"></i>
                </div>
            </div>
        </div>
         <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile" >Mục tiêu</div>
                 <div class="md-form mt-0">
                    <textarea type="text" name="in_future" class="md-textarea md-textarea-auto form-control enable" id="inputEmail3MD" disabled="true">{{$user->in_future}}</textarea>
                    <i class="fas fa-pencil-alt float-right"></i>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile" >Sở thích</div>
                 <div class="md-form mt-0">
                    <textarea type="text" name="hobby" class="md-textarea md-textarea-auto form-control enable" id="inputEmail3MD" disabled="true" >{{$user->hobby}}</textarea>
                    <i class="fas fa-pencil-alt float-right"></i>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                 <div  class="index-profile" >Ngoại ngữ</div>
                 <div class="md-form mt-0">
                    <textarea type="text" name="foreign_language" class="md-textarea md-textarea-auto form-control enable" id="inputEmail3MD" disabled="true">{{$user->foreign_language}}</textarea>
                    <i class="fas fa-pencil-alt float-right"></i>
                </div>
            </div>
        </div>
    </div>
</form>
    <div class="fixed-action-btn btn-edit-profile">
        <a href="" class="btn-floating btn-lg red waves-effect waves-light text-white " title="Sửa hồ sơ cá nhân">
            <i class="fas fa-pencil-alt"></i>
        </a>
    </div>
    <script type="text/javascript">
        $(".btn-edit-profile").click(function(event){
            event.preventDefault();
            $(".enable").prop( "disabled", false );
             $(".save").prop( "disabled", false );
            $(".md-form .fas").css("display","block");
            $(".hidden").css("display","block");
            
        });
        
            var loadFile = function(event) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function(){
                var output = document.getElementById('output');
                 output.src = reader.result;
                 console.log(output.src)
            };
             reader.readAsDataURL(event.target.files[0]);
        };
       
        
    </script>
@endsection

                        