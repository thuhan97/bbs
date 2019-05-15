@extends('layouts.end_user')
@section('content')

<div class="col-md-8">
    <div class="content">
        <div class="tab-pane active">
            <form action="{{ route('save_edit_experience') }}" method="post" id="formAddExperience" enctype="multipart/form-data">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="form-group margin-b-5 margin-t-5">
                    <h2 for="acronym_name"><strong>Kinh nghiệm làm việc</strong></h2><br />
                    <input value="{{$experience->id}}" type="hidden" name="id">
                    <textarea class="form-control" id="editorContainer" name="content" placeholder="Viết kinh nghiệm bạn muốn chia sẻ ...">{{$experience->content}}</textarea>
                </div>
                <div class="pt-3 pb-4 d-flex border-top-0 rounded mb-0">
                    <button type="button" class="btn btn-primary" id="buttonExperience">LƯU</button>
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