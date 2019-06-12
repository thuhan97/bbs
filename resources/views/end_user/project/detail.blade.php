@extends('layouts.end_user')
@section('page-title', $project->name)

@section('breadcrumbs')
    {!! Breadcrumbs::render('project_detail', $project) !!}
@endsection
@section('content')
    <div class="mt-4">
        <div class="text-uppercase">
            <i class="fas fa-circle"
               style="{{COLOR_STATUS_PROJECT[$project->status]}}"> {{STATUS_PROJECT[$project->status]}}</i>
        </div>
        @can('edit', $project)
            <a href="{{route('project_edit', ['id'=> $project->id])}}"
               class="d-none d-lg-block float-right btn btn-warning" style="position: relative; top: -40px;">Chỉnh
                sửa</a>
        @endcan
    </div>
    <div class="row mt-4">
        <div class="col-md-4 text-center">
            <img src="{{$project->image_url}}" class="img-fluid z-depth-1 mb-3">
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
                    <td>{{$project->scale}} man/month</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Thời gian</td>
                    <td>{{$project->amount_of_time}} months</td>
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
            <div class="card">
                <div class="card-body">
                    <div id="table" class="table-editable">
                        <span><h5 class="text-center">Tất cả các thành viên trong dự án</h5></span>
                        <table class="table table-bordered table-responsive-md table-striped text-center">
                            <tr>
                                <th class="text-center center-td" rowspan="2">Tên</th>
                                <th class="text-center center-td" rowspan="2">Vai trò</th>
                                <th class="text-center" colspan="2">Công số</th>
                                <th class="text-center " colspan="2">Thời gian</th>
                            </tr>
                            <tr>
                                <th class="text-center">Hợp đồng</th>
                                <th class="text-center">Thực tế</th>
                                <th class="text-center">Bắt đầu</th>
                                <th class="text-center">Kết thúc</th>
                            </tr>
                            <tbody>
                            <td class="pt-3-half pb-0 ">
                                {{ $project->leader->name ?? ''}}
                            </td>
                            <td class="pt-3-half pb-0" contenteditable="true">
                                leader
                            </td>
                            <td class="pt-3-half pb-0">{{ $projectMember->contract ?? '' }}</td>
                            <td class="pt-3-half pb-0">{{ $projectMember->reality ?? '' }}</td>
                            <td class="pt-3-half pb-0">{{ $projectMember->time_start ?? '' }}</td>
                            <td class="pt-3-half pb-0">{{ $projectMember->time_end ?? '' }}</td>

                            @foreach($project->projectMembers as $projectMember)
                            <tr>
                                <td class="pt-3-half pb-0">
                                    {{ $projectMember->user->name ?? ''}}
                                </td>
                                <td class="pt-3-half pb-0">
                                    {{ array_key_exists($projectMember->mission,MISSION_PROJECT) ? MISSION_PROJECT[$projectMember->mission] : '' }}
                                </td>
                                <td class="pt-3-half pb-0">{{ $projectMember->contract ?? '' }}</td>
                                <td class="pt-3-half pb-0">{{ $projectMember->reality ?? '' }}</td>
                                <td class="pt-3-half pb-0">{{ $projectMember->time_start ?? '' }}</td>
                                <td class="pt-3-half pb-0">{{ $projectMember->time_end ?? '' }}</td>
                            </tr>
                            @endforeach
                            <!-- This is our clonable table line -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" border border-light rounded mb-0">
        <div class=>
            <h5 class="text-info">Kỹ thuật</h5>
            <p>  {!! nl2br(e($project->technical)) !!}</p>
        </div>
        <div class="mt-4">
            <h5 class="text-info">Công cụ sử dụng</h5>
            <span id="font-top-subtitle"> {!! nl2br(e($project->tools)) !!} </span>
        </div>
        <div class="mt-4">
            <h5 class="text-info">Mô tả</h5>
            <p>{!! $project->description !!}</p>
        </div>
    </div>
    <br/>
@endsection