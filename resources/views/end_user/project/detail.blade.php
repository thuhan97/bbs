@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('project_detail', $project) !!}
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header h5">{{$project->name}}</h5>
        <div class="card-body">
            <div class="text-uppercase">
                <i class="fas fa-circle  " style="{{COLOR_STATUS_PROJECT[$project->status]}}"> {{STATUS_PROJECT[$project->status]}}</i>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <img src="{{$project->image_url}}" class="img-fluid z-depth-1">
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered table-striped">
                <tr>
                   <td width="30%" class="font-weight-bold">Khách hàng</td>
                   <td>{{$project->customer}}</td>
                </tr>
                <tr>
                   <td class="font-weight-bold">Loại dự án</td>
                   <td>{{PROJECT_TYPE[$project->project_type]}}</td>
                </tr>
                <tr>
                   <td class="font-weight-bold">Quy mô</td>
                   <td>{{$project->scale}}</td>
                </tr>
                <tr>
                   <td class="font-weight-bold">Thời gian</td>
                   <td>{{$project->amount_of_time}}</td>
                </tr>
                <tr>
                   <td class="font-weight-bold">Leader dự án</td>
                   <td>{{$project->lead_id}}</td>
                </tr>
                <tr>
                   <td class="font-weight-bold">Ngày bắt đầu</td>
                   <td>{{$project->start_date}}</td>
                </tr>
                <tr>
                   <td class="font-weight-bold">Ngày kết thúc</td>
                   <td>{{$project->end_date}}</td>
                </tr>
                    </table>
                </div>
            </div>
            <div class=" border border-light rounded mb-0 px-4">
                <div class="mt-4">
                    <h5>Kỹ thuật</h5>
                    <p>{{$project->technicals}}</p>
                </div>
                <div class="mt-4">
                    <h5>Công cụ sử dụng</h5>
                    <p>{{$project->tools}}</p>
                </div>
                <div class="mt-4">
                    <h5>Mô tả</h5>
                    <p>{{$project->description}}</p>
                </div>
            </div>
        </div>
    </div>
    
@endsection