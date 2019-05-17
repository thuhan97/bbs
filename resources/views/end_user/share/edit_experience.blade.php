@extends('layouts.end_user')
@section('content')

<div class="col-md-8">
    <div class="content">
        <div class="tab-pane active">
            <form action="{{ route('save_edit_experience') }}" method="post" enctype="multipart/form-data" id="formExperience">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="margin-b-5 margin-t-5">
                    <h2 for="acronym_name" class="text-center"><strong>Sửa kinh nghiệm làm việc</strong></h2>
                    <input value="{{$experience->id}}" type="hidden" name="id">
                    <div class="divContent">
                        <div class="form-group">    
                            <label>Miêu tả*</label>
                            <textarea class="form-control" id="introduction" name="introduction" placeholder="Miêu tả...">{{$experience->introduction}}</textarea>
                        </div>
                        <div class="form-group">     
                            <label>Nội dung*</label>                          
                            <textarea class="form-control" id="editorContainer" name="content" placeholder="Viết kinh nghiệm bạn muốn chia sẻ ...">{{$experience->content}}</textarea>
                        </div>
                        <div class="card bg-danger text-white" id="ErrorMessaging"></div>    
                    </div>    
                </div>
                <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                    <button type="button" class="btn btn-primary" id="buttonExperience" onclick="sendForm()">Lưu</button>
                    <a href="{{ route('share_experience') }}"><button type="button" class="btn btn-primary">HỦY</button></a>
                </div>
            </form>             
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