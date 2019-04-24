@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('list_share_document') !!}
@endsection
@section('content')

<div class="col-md-7">
    <div class="content">
        <div class="tab-pane active">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="acronym_name">Kinh nghiệm làm việc*</label>
                <textarea class="form-control" id="description" name="description" placeholder="Viết kinh nghiệm bạn muốn chia sẻ ..."></textarea>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-scripts')
    <script>
        $(function () {
            myEditor($("#description"));
        })
    </script>
@endpush