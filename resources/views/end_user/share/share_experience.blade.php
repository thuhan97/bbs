@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('share_experience') !!}
@endsection
@section('content')
<link rel="stylesheet" href="{{URL::asset('css/share_experience.css')}}">

<div class="col-md-7">
    <div class="content">
        <div class="tab-pane active">
            <div class="divAddButton">
                <button type="button" class="btn btn-danger button-exp button-add">ĐĂNG BÀI</button>
                <button type="button" class="btn btn-danger button-exp button-hidden" style="display: none;">ẨN ĐĂNG BÀI</button>
            </div>
            <form action="{{ route('add_experience') }}" method="post" id="formExp" enctype="multipart/form-data">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="form-group margin-b-5 margin-t-5">
                    <label for="acronym_name">Kinh nghiệm làm việc*</label>
                    <textarea class="form-control" id="editorContainer" name="content" placeholder="Viết kinh nghiệm bạn muốn chia sẻ ..."></textarea>
                </div>
                <div class="pt-3 pb-4 d-flex border-top-0 rounded mb-0">
                    <button type="button" class="btn btn-primary" id="buttonExperience">ĐĂNG BÀI</button>
                </div>
            </form>
                @foreach($list_experience as $experience)
                    <div class="posts row">            
                        <div class="content-share-experience col-md-12">
                            <div class="userImage">
                              <img data-src="{{$experience->user->avatar}}" src="{{URL_IMAGE_NO_IMAGE}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'" />
                            </div>
                            <div class="info-user-post">
                                <p class=""><?php echo isset($experience->user->name) ? $experience->user->name : ''; ?></p>
                                <span class="date sub-text">{{date_format($experience->created_at,"Y-m-d")}}</span>
                            </div>
                            <div calss="content-posts">
                                <p><?php echo $experience->content; ?></p>   
                            </div>
<!--                             <div class="like-comment border-top-buttom">
                                <i class="far fa-heart"></i> 15 <a>Thích</a> &nbsp   
                                <i class="far fa-comment"></i> 15 <a class="form-comment1">Bình luận</a>
                            </div>
                            <form class="form-comment">
                                <div class="content-form-comment1 form-group row">
                                        <div class="col-sm-10">
                                            <input type="text"  class="form-control input-comment1 input-comment" name="contentComment" placeholder="Viết bình luận ..." autocomplete="off">
                                            <input type="text" name="shareID" class="hidden share_id" value="{{$experience->id}}">
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-light button-send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                        </div>
                                </div>
                            </form>   -->  
<!--                             <div class="form-group">
                                <a>Xem các bình luận trước ...</a>
                            </div>
                            <div class="comment form-group">
                                <div class="row">
                                    <div class="userImage col-sm-1">
                                      <img src="http://placekitten.com/40/40" />
                                    </div>
                                    <div class="info-user-comment col-sm-11">
                                        <p class="">Dinh van phuc</p>
                                        <p>cam on ban da cho toi nhan xe ve bai viet nay</p>
                                        <span class="reply"><a class="form-comment2">Trả lời</a></span>
                                        <div class="row">
                                            <div class="userImage col-sm-1 col-2">
                                              <img src="http://placekitten.com/40/40" />
                                            </div>
                                            <div class="info-user-comment col-sm-11 col-10 ">
                                                <p class="">Dinh van phuc</p>
                                                <p>cam on ban da cho toi nhan xe ve bai viet nay</p>
                                                <span class="reply"><a class="form-comment2">Trả lời</a></span>
                                                <form class="form-comment">
                                                    <div class="row content-form-comment2" style="display: none;">
                                                        <div class="col-sm-10">
                                                            <input type="text"  class="form-control input-comment2 input-comment" name="contentComment" placeholder="Viết bình luận ..." autocomplete="off">
                                                            <input type="text" name="shareID" class="hidden share_id" value="{{$experience->id}}">
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <button type="button" class="btn btn-light button-send">
                                                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>     
                                            </div>   
                                        </div>                                      
                                    </div>   
                                </div>  
                            </div>  -->                          
                        </div>
                    </div>
                @endforeach    
        </div>
    </div>
</div>

@endsection

@push('footer-scripts')
    <script>
        $(function () {
            myEditor($("#editorContainer"));
        })
    </script>
@endpush