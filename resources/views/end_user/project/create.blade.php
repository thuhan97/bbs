@extends('layouts.end_user')
@section('page-title', __l('create_project'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('project_create') !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-2"></div>
        <div class="col-xxl-8 col-12">
            <div class="card">
                <form action="{{route('store_project')}}" method="post" enctype="multipart/form-data" id="form-project">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{__l('create_project')}}
                        </h4>
                        <hr/>
                        <div class="card-text">
                            @include('end_user.project._updateOrCreate')
                            <br/>
                            <div class="text-right">
                                <a href="{{route('project')}}" class="btn btn-warning">Hủy</a>
                                <button type="submit" class="btn btn-success btn-send">Tạo mới</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
