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
                    <h2 for="acronym_name"><strong>Nội dung chia sẻ kinh nghiệm làm việc</strong></h2>

                    <div class="divContent">
                        <div class="form-group">
                            <strong><?php echo $experience->introduction ?></strong>
                        </div>
                        <div class="form-group">
                            <h4>Nội dung:</h4>
                            <p><?php echo $experience->content ?></p>
                        </div>
                        <div class="card bg-danger text-white" id="ErrorMessaging"></div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" onclick="window.history.back()">Quay lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection