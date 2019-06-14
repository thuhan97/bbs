<?php
$isMaster=auth()->user()->isMaster();
$isManager=auth()->user()->isManager();
?>
@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('device') !!}
@endsection
@section('content')
    @if(session()->has('success'))
    <div class="alert alert-success text-primary" role="alert">
        {{ session()->get('success') }}
    </div>
    @endif
    @if(session()->has('not_success'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('not_success') }}
        </div>
    @endif
    <div class="mt-4 col-md-10">
        <div class="content">
            <div class="tab-pane active">
                <div class="createReport fixed-action-btn">
                    <a href="#" class="btn-lg red waves-effect waves-light text-white" title="Đăng bài"
                       data-target="#feedback" data-toggle="modal"
                       style="border-radius: 35px;border: 5px solid #FED6D8;font-size: 17px;">
                        <img class="imgAddExperience" src="{{ asset_ver('img/icon_exp.png') }}"
                             onerror="this.src='{{URL_IMAGE_NO_AVATAR}}'" alt="avatar image"/>
                        Thêm đề xuất
                    </a>
                </div>
            </div>
        </div>
    </div>


        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">
                    #
                </th>
                @if(auth()->user()->jobtitle_id > TEAMLEADER_ROLE)
                <th scope="col">
                    Người đề xuất
                </th>
                @endif
                <th scope="col">
                    Thiết bị đề xuất
                </th>
                <th scope="col">
                   Tiêu đề
                </th>
                <th scope="col">
                    Nội dung
                </th>
                <th scope="col">
                    Trạng thái
                </th>
                <th scope="col">
                    Ngày hẹn trả
                </th>
                <th scope="col">
                    Ý kiến Manager
                </th>
                <th scope="col">
                    Ý kiến HCNS
                </th>
                <th scope="col">
                    Chức năng
                </th>

            </tr>
            </thead>
            <tbody>
            @foreach($providedDevic as $key => $value)
                <tr>
                <td class="center-btn-td" scope="row">{{ $key +1 }}</td>
                @if($isMaster || $isManager)
                    <td>
                        {{ $value->user->name }}
                    </td>
                @endif
                <td>

                    {{ array_key_exists($value->type_device,TYPES_DEVICE) ? TYPES_DEVICE[$value->type_device] : '' }}

                </td>
                <td>
                    {{ $value->title }}
                </td>
                <td>
                    {{ $value->content }}
                </td>
                <td>
                    @if($value->status == 2)
                        Chờ Duyệt
                    @elseif($value->status ==3)
                        Manager đã duyệt
                    @elseif($value->status ==1)
                        HCNV đã duyệt
                    @elseif($value->status ==0)
                        Đã hủy
                    @endif
                </td>
                <td>
                    {{ $value->return_date ?? '' }}
                </td>
                <td>
                    {{ $value->approval_manager ?? '' }}
                </td>
                <td>
                    {{ $value->approval_hcnv ?? '' }}
                </td>
                <td class="center-btn-td">
                    @if($isMaster || $isManager)
                        <button type="button" class="btn btn-outline-blue waves-effect px-1 py-1"><i class="far fa-eye"></i></button>
                    @else
                        <button type="button" class="btn btn-outline-primary waves-effect px-1 py-1"><i class="far fa-edit"></i></button>
                        <button type="button" class="btn btn-outline-danger waves-effect px-1 py-1"><i class="far fa-trash-alt"></i></button>
                    @endif

                </td>
                </tr>
            @endforeach
            </tbody>
        </table>



    <!-- Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h2 for="acronym_name" class="text-title"><strong>Đề xuất thiết bị làm việc</strong></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <div class="background-close-icon">
                            <span class="btn-close-icon" aria-hidden="true">&times;</span>
                        </div>
                    </button>
                </div>
                <form action="{{ route('device_create') }}" method="post" enctype="multipart/form-data"
                      id="formExperience">
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="margin-b-5 margin-t-5">
                        <div class="divContent">
                            <div class="form-group">
                                <label>Tóm tắt *</label>
                                <textarea class="form-control" id="introduction" name="title"
                                          placeholder="Tóm tắt nội dung đề xuất"></textarea>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('title') }}</strong>
                                     </span>
                                @endif
                            </div>

                            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
                                <label for="types_device_id">Thiết bị đề xuất *</label>
                                {{ Form::select('types_device', TYPES_DEVICE, null, ['class'=>'browser-default custom-select  mb-3']) }}
                                @if ($errors->has('types_device_id'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('types_device_id') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nội dung đề xuất *</label>
                                <textarea class="form-control" id="editorContainer" name="content"
                                          placeholder="Viết kinh nghiệm bạn muốn chia sẻ ..."></textarea>
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('content') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="card bg-danger text-white" id="ErrorMessaging"></div>
                        </div>
                    </div>
                    <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                        <button type="button" class="btn btn-primary" id="buttonExperience" onclick="sendForm()">GỬI ĐỀ XUẤT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open
        modal for @getbootstrap</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="md-form">
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="md-form">
                            <textarea type="text" id="message-text" class="form-control md-textarea" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicExampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn hủy đề xuất này không ? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('extend-css')
    <link rel="stylesheet" href="{{asset_ver('css/share_experience.css')}}">
@endpush
@push('footer-scripts')
    <script src="{{asset_ver('js/end-user-share-experience.js')}}"></script>

    <script>
        $(function () {
            myEditor($("#editorContainer"));
        })
    </script>
@endpush
