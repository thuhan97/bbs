@extends('layouts.end_user')
@section('page-title', __l('edit_project'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('edit_project', $record) !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-2"></div>
        <div class="col-xxl-8 col-12">
            <div class="card">
                <form action="{{route('project_update', $record->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{__l('edit_project')}}
                        </h4>
                        <hr/>
                        <div class="card-text">
                            @include('end_user.project._updateOrCreate')
                            <br/>
                            <div class="text-right">
                                <a href="{{route('project')}}" class="btn btn-warning">Hủy</a>
                                <button type="submit" class="btn btn-success btn-send">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
