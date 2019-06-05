@extends('layouts.end_user')
@section('page-title', __l('share_experience'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('share_experience_detail', $experience) !!}
@endsection
@section('content')
    <div class="col-md-8">
        <div class="content">
            <div class="tab-pane active">
                <div class="margin-b-5 margin-t-5">
                    <div class="divContent">
                        <strong>{!! nl2br($experience->introduction) !!}</strong>
                        <br/>
                        <p>{!! $experience->content !!}</p>
                        <hr/>
                        <strong>{{$experience->user->name ?? ''}} - {{$experience->created_at}}</strong>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" onclick="window.history.back()">Quay lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-scripts')
    <script src="{{asset_ver('js/end-user-share-experience.js')}}"></script>
@endpush
