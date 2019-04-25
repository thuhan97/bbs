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

<div class="col-md-7">
    <div class="content">
        <div class="tab-pane active">
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
                              <img src="http://placekitten.com/40/40" />
                            </div>
                            <div class="info-user-post">
                                <p class="">Hello this is a test comment.</p>
                                <span class="date sub-text">25/04/2019</span>
                            </div>
                            <div calss="content-posts">
                                <p><?php echo $experience->content; ?></p>   
                            </div>
                            <div class="like-comment border-top-buttom">
                                <i class="far fa-heart"></i> Thích &nbsp   
                                <i class="far fa-comment"></i> 15 Bình luận
                            </div>
                            <div class="content-comments form-group row">
                                <div class="col-sm-10">
                                    <input type="text"  class="form-control input-comment" name="contentComment" placeholder="Viết bình luận ..." autocomplete="off">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-light button-send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="form-group">
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
                                        <span class="reply"><a>Trả lời</a></span>
                                        <div class="row">
                                            <div class="userImage col-sm-1 col-2">
                                              <img src="http://placekitten.com/40/40" />
                                            </div>
                                            <div class="info-user-comment col-sm-11 col-10">
                                                <p class="">Dinh van phuc</p>
                                                <p>cam on ban da cho toi nhan xe ve bai viet nay</p>
                                                <span class="reply"><a>Trả lời</a></span>
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <input type="text"  class="form-control input-comment" name="contentComment" placeholder="Viết bình luận ..." autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-light button-send">
                                                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div> 
                                            </div>   
                                        </div>                                      
                                    </div>   
                                </div>    
                            </div>                           
                        </div>
                    </div>
                @endforeach    
        </div>
    </div>
</div>

<script> 
    $("#buttonExperience").click(function(){
        var content = $("#editorContainer_ifr").contents().find("body").text();
        if(content.trim() != ''){
            $('#formExp').submit();
        }
    });    
</script>

@endsection

@push('footer-scripts')
    <script>
        $(function () {
            myEditor($("#editorContainer"));
        })
    </script>
@endpush

<style>
.content-share-experience{
    width: 100%;
}
.posts{
    border-bottom: 1px solid #dee2e6f7;
    margin-bottom: 10px;    
}    
.input-reply{
    /*display: none !important;*/
}    
.button-send{
    margin-top: 0px !important;
}
.like-comment{
    margin-bottom: 5px;
}
.content-comments{
}
.border-top-buttom{
    border-top: 1px solid #dee2e66b;
    border-bottom: 1px solid #dee2e66b;
    padding:5px 0px;
}
.userImage {
    width:40px;
    /*height:100%;*/
    float:left;
    /*position: absolute;*/
}
.userImage img {
    width:40px;
    border-radius:50%;
}
.info-user-post p {
    margin:0;
}
.info-user-comment p {
    margin:0;
}
.info-user-comment{
    padding-left: 0px !important;
}
.reply{
    font-size:14px;
}
.sub-text {
    color:#aaa;
    font-family:verdana;
    font-size:11px;
}   
</style>