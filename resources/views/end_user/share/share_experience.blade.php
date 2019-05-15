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

<div class="col-md-8">
    <div class="content">
        <div class="tab-pane active">
<!--             <div class="divAddButton">
                <button type="button" class="btn btn-danger button-exp button-add">ĐĂNG BÀI</button>
                <button type="button" class="btn btn-danger button-exp button-hidden" style="display: none;">ẨN ĐĂNG BÀI</button>
            </div> -->
            <div class="createReport fixed-action-btn">
                <a href="#" class="button-add btn-lg red waves-effect waves-light text-white" title="Chia sẻ" data-target="#feedback" data-toggle="modal" style="border-radius: 45%;">
                    <img src="{{ asset('img/icon_exp.png') }}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'" alt="avatar image" />
                    Đăng bài
                </a>
            </div>
                @foreach($list_experience as $experience)
                    <div class="posts row">            
                        <div class="content-share-experience col-md-12">
                            <div class="userImage">
                              <img src="{{$experience->user->avatar}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'" alt="avatar image" />
                            </div>
                            <div class="info-user-post">
                                <p class="">
                                    <?php echo isset($experience->user->name) ? $experience->user->name : ''; ?>
                                    @if($experience->user->id == Auth::user()->id)
                                        <div class="dropdown">
                                            <i class="fa fa-ellipsis-h" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('edit_experience', $experience->id) }}">Sửa bài viết</a>
                                                <a class="dropdown-item" href="{{ route('deleted_experience', $experience->id) }}">Xóa bài viết</a>
                                            </div>                                            
                                        </div>
                                    @endif
                                </p>
                                <span class="date sub-text">{{date_format($experience->created_at,"Y-m-d")}}</span>
                            </div>
                            <div class="content-posts">
                                <p><?php echo $experience->content; ?></p>
                            </div>                      
                        </div>
                    </div>
                @endforeach 
                <div class="row">
                    {{ $list_experience->links() }}
                </div>                   
        </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content" id="bg-img">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <div class="background-close-icon">
                            <span class="btn-close-icon" aria-hidden="true">&times;</span>
                        </div>
                    </button>
                </div>
                <div class="form-group">
                    <form action="{{ route('add_experience') }}" method="post" enctype="multipart/form-data" id="formExperience">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="form-group margin-b-5 margin-t-5">
                            <div class="form-group">
                                <h2 for="acronym_name" class="text-center"><strong>Kinh nghiệm làm việc</strong></h2>
                            </div>
                            <div class="form-group divContent">    
                                <textarea class="form-control" id="editorContainer" name="content" placeholder="Viết kinh nghiệm bạn muốn chia sẻ ..."></textarea>
                            </div>    
                        </div>
                        <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                            <button type="button" class="btn btn-primary" id="buttonExperience">ĐĂNG BÀI</button>
                        </div>
                    </form>
                </div>
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
<style>
    .modal-dialog{
        overflow-x: hidden;
    }
    .divContent{
        margin: 0px 10px;
    }
</style>