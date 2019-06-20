<?php
$isMaster = auth()->user()->isMaster();
$isManager = auth()->user()->isManager();
$isStaff = !auth()->user()->isManager();
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
    @if(session()->has('delete_success'))
        <div class="alert alert-success text-primary" role="alert">
            {{ session()->get('delete_success') }}
        </div>
    @endif
    @if(session()->has('not_success'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('not_success') }}
        </div>
    @endif

    <div class=" fixed-action-btn" id="btn-show-modal-create">
        <a href="#" class="btn-lg red waves-effect waves-light text-white" title="Tiêu đề"
           data-target="#feedback" data-toggle="modal" id="btn-show-modal-create"
           style="border-radius: 35px;border: 5px solid #FED6D8;font-size: 17px;">
            <img class="imgAddExperience" src="{{ asset_ver('img/icon_exp.png') }}"
                 onerror="this.src='{{URL_IMAGE_NO_AVATAR}}'" alt="avatar image"/>
            Xin cấp thiết bị
        </a>
    </div>
    @if($providedDevic->count() > 0)
        <div class="row">
            <div class="col-sm-12 col-xxl-10">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="d-none d-md-table-cell" style="max-width: 70px">
                            #
                        </th>
                        @if($isMaster || $isManager)
                            <th>
                                Người đề xuất
                            </th>
                        @endif
                        <th>
                            Thiết bị đề xuất
                        </th>
                        <th class="d-none d-md-table-cell" style="min-width: 350px">
                            Tiêu đề
                        </th>
                        <th class="d-none d-md-table-cell">
                            Ngày hẹn trả
                        </th>
                        <th class="text-center">
                            Trạng thái
                        </th>
                        <th class="text-center">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($providedDevic as $key => $value)
                        <tr>
                            <td class="d-none d-md-table-cell" scope="row">{{ $key + INCREMENT }}</td>
                            @if($isMaster || $isManager)
                                <td>
                                    {{ $value->user->name }}
                                </td>
                            @endif
                            <td>
                                {{ array_key_exists($value->type_device,TYPES_DEVICE) ? TYPES_DEVICE[$value->type_device] : '' }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{str_limit(strip_tags(nl2br($value->title) ), 200) }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $value->return_date ?? '' }}
                            </td>
                            <td class="text-center">
                                @if($value->status == STATUS_DEVICE['not_active'])
                                    <i data-toggle="tooltip" data-placement="right" title="Không duyệt"
                                       class="fas fa-frown fa-2x text-danger"></i>
                                @elseif($value->status == STATUS_DEVICE['approving'])
                                    <i data-toggle="tooltip" data-placement="right" title="Chờ phê duyệt"
                                       class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                                @elseif($value->status == STATUS_DEVICE['done'])
                                    <i data-toggle="tooltip" data-placement="right" title="Đã nhận thiết bị"
                                       class="far fa-laugh-squint fa-2x text-success"></i>
                                @else
                                    <i data-toggle="tooltip" data-placement="right" title="Đã duyệt đơn"
                                       class="fas fa-grin-stars fa-2x text-primary"></i>
                                @endif

                            </td>
                            <td class="center-btn-td text-center">
                                @if($isMaster || $isManager)
                                    <button id="{{ $value->id }}" attr="{{ $value->id }}" type="button"
                                            class="btn btn-outline-blue waves-effect px-1 py-1 show-detail"><i
                                                class="far fa-eye"></i></button>
                                @else
                                    @if($value->status == DEVICE_STATUS_ABIDE)
                                        <button attr="{{ $value->id }}" type="button"
                                                class="btn btn-outline-primary waves-effect px-1 py-1 btn-edit"><i
                                                    class="far fa-edit"></i></button>
                                        <button attr="{{ $value->id }}" type="button"
                                                class="btn btn-outline-danger waves-effect px-1 py-1 btn-delete"
                                                data-toggle="modal"
                                                data-target="#basicExampleModal"><i class="far fa-trash-alt"></i>
                                        </button>
                                    @else
                                        <button id="{{ $value->id }}" attr="{{ $value->id }}" type="button"
                                                class="btn btn-outline-blue waves-effect px-1 py-1 show-detail"><i
                                                    class="far fa-eye"></i></button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade device-create-modal" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                      id="form-send">
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="margin-b-5 margin-t-5">
                        <div class="divContent">
                            <input type="hidden" name="id_check" id="id-check">
                            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
                                <label for="types_device_id">Thiết bị đề xuất *</label>
                                {{ Form::select('type_device', TYPES_DEVICE, null, ['class'=>'browser-default custom-select select-type mb-3', 'placeholder'=>'Vui lòng chọn thiết bị']) }}
                                @if ($errors->has('types_device_id'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('types_device_id') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Tóm tắt *</label>
                                <textarea class="form-control" id="title" name="title"
                                          placeholder="Tóm tắt nội dung đề xuất"></textarea>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('title') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Nội dung (hiện trạng/lý do/chi tiết thiết bị cần đề xuất) *</label>
                                <textarea class="form-control" id="content" name="content"
                                          placeholder="Viết chi tiết nội dung về thiết bị ..."></textarea>
                                @if ($errors->has('content'))
                                    <span class="help-block">
                                         <strong>{{ $errors->first('content') }}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="card bg-danger text-white" id="ErrorMessaging"></div>
                        </div>
                    </div>
                    <div class="pt-3 pb-4 d-flex justify-content-end border-top-0 rounded mb-0">
                        <button type="submit" id="btn-submit" class="btn btn-warning">GỬI ĐỀ XUẤT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Nội dung đề xuất thiết bị</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('device_approval') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <p class="bold">Thiết bị đề xuất:</p>
                            <span id="type-device"></span>
                        </div>
                        <div>
                            <p class="bold">Tiêu đề:</p>
                            <span id="title-devide"></span>
                        </div>
                        <div>
                            <p class="bold">Nội dung yêu cầu:</p>
                            <span id="content-device"></span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="bold">Người đề xuất:</p>
                                <span id="name-device"></span>
                            </div>
                            <div class="col-6">
                                <p class="bold">Ngày đề xuất:</p>
                                <span id="content-date"></span>
                            </div>
                        </div>
                        <hr/>
                        <div id="approve-form"></div>
                    </div>

                    <div class="modal-footer" id="footer-approval">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <form action="{{ route('device_delete') }}" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn hủy đề xuất này không
                            ? </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="id" id="device_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('extend-css')
    <link rel="stylesheet" href="{{asset_ver('css/share_experience.css')}}">
@endpush
@push('footer-scripts')
    <script src="{{ asset_ver('js/jquery.validate.min.js') }}"></script>
    <script src="{{asset_ver('js/tinymce/tinymce.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            var hash = window.location.hash;
            if (hash) {
                var id = $(hash).attr('attr');
                getData(id)
            }
            $(document).on('click', '#notification', function () {
                location.reload();
            })

            tinymce.init({
                selector: '#content',
                paste_data_images: true,
                height: '250px',
                plugins: [
                    "advlist autolink lists charmap preview hr anchor pagebreak",
                ],
            });

            $('.btn-delete').on('click', function () {
                var id = $(this).attr('attr');
                var id = $('#device_id').val(id);
            })
            $('.btn-edit').on('click', function () {
                var id = $(this).attr('attr');
                $.ajax
                ({
                    'url': '{{ route('device_edit') }}' + '/' + id,
                    'type': 'get',
                    success: function (data) {
                        if (data.success == 200) {
                            $('#id-check').val(data.data.id);
                            $('#title').html(data.data.title.replace(/\n/g, "<br />"));
                            $('.select-type').val(data.data.type_device)
                            tinymce.get('content').setContent(data.data.content);
                            $('#title-error , #type_device-error ,#content-error').remove()
                            $('#feedback').modal('show');
                        }
                    }
                });
            });

            $("#form-send").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                    },
                    type_device: {
                        required: true
                    },
                    content: {
                        required: function () {
                        },
                    },
                },
                messages: {
                    title: "Vui lòng nhập tóm tắt",
                    type_device: "Vui lòng chọn thiết bị",
                    content: {
                        required: "Vui lòng nhập nội dung đề xuất ",
                    },
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
            $('#btn-show-modal-create').on('click', function () {
                $('#id-check , .select-type ').val('');
                $('#title').text('');
            })

            $('.show-detail').on('click', function () {
                var id = $(this).attr('attr');
                getData(id);

            })

            function getData(id) {
                var jobtitleId = '{{ auth()->user()->jobtitle_id }}';
                var idUserLogin = '{{ auth()->id() }}'
                var typesDevice = {
                    "0": "Case",
                    "1": "Màn hình",
                    "2": "Chuột",
                    "3": "Bàn phím",
                    "4": "Điện thoại",
                    "5": "Máy tính bảng",
                    "6": "Khác",
                }

                $.ajax
                ({
                    'url': '{{ route('device_edit') }}' + '/' + id,
                    'type': 'get',
                    success: function (data) {
                        $('.btn-send-form').remove();
                        $('#name-device').text(data.name);
                        $('#title-devide').html(data.data.title.replace(/\n/g, "<br />"));
                        $('#content-device').html(data.data.content)
                        $('#content-date').html(data.date_create)
                        $('#content-date').append('<input type="hidden" name="id_check" id="id-check" value="' + data.data.id + '">');
                        if (typesDevice.hasOwnProperty(data.data.type_device)) {
                            $('#type-device').html(typesDevice[data.data.type_device]);
                        }
                        if (jobtitleId >= 2 && data.data.status == 2) {
                            $('#approve-form').html(renderViewApproval(data.data.id));
                            $('#footer-approval').append('<button id="" type="submit" class="btn btn-primary btn-send-form">DUYỆT</button>');
                        } else {
                            var comment = data.data.approval_manager ? data.data.approval_manager : '';
                            var hcnvComment = data.data.approval_hcnv ? data.data.approval_hcnv : '';
                            $('#approve-form').html(renderViewApprovalStatus(data.data.status, data.return_date, hcnvComment, comment));
                            if (data.data.status == 1 && data.data.user_id == idUserLogin) {
                                $('#footer-approval').append('<input class="btn btn-primary btn-send-form" id="coffee-submit" type="submit" name="done" value="ĐÃ NHẬN">');

                            }
                        }
                        $('#exampleModal').modal('show')
                    }
                });

            }

            function renderViewApproval(id) {
                var html = '';
                html += '<div>'
                html += ' <p class="bold">Ý kiến phê duyệt :</p>'
                html += ' <textarea class="form-control" name="approval_manager"></textarea>'
                html += '</div>'
                html += '<div>'
                html += ' <p class="bold">Trạng thái</p>'
                html += '<div class="d-inline-block custom-control custom-radio mr-2">'
                html += ' <input type="radio" class="custom-control-input" checked="checked" id="defaultChecked" value="3" name="status">'
                html += '<label class="custom-control-label" for="defaultChecked">Duyệt đơn</label>'
                html += '</div>'
                html += '<div class="d-inline-block custom-control custom-radio">'
                html += '<input type="radio" class="custom-control-input" id="defaultUnchecked" name="status" value="0">'
                html += '<label class="custom-control-label" for="defaultUnchecked">Hủy đơn</label>'
                html += ' </div>'
                /* html+= '<input type="hidden" name="id_check" id="id-check" value="'+ id +'">'*/
                html += '</div>'
                return html;
            }

            function renderViewApprovalStatus(status, returnDate, hcnv_comment = ' ', comment = ' ') {
                var html = '';

                html += '<div>';
                html += ' <p class="bold">Ý kiến của quản lý:</p>';
                html += ' <span>' + comment + '</span>';
                html += '</div> <hr />';
                html += '<div>';
                html += ' <p class="bold">Ý kiến của HCNS:</p>';
                html += ' <span>' + hcnv_comment + '</span>';
                html += '</div>';
                html += '<div>';
                if (status == 1) {
                    html += '<div>';
                    html += ' <p class="bold">Ngày hẹn trả :</p>';
                    html += ' <span>' + returnDate + '</span>';
                    html += '</div>';
                }
                html += ' <p class="bold">Trạng thái</p>';
                html += '<span>' + checkStatus(status) + '</span>';
                html += '</div>';
                return html;
            }

            function checkStatus(status) {
                switch (status) {
                    case 0:
                        return 'Đã hủy';
                    case 1:
                        return 'Đã duyệt';
                    case 2:
                        return 'Chờ duyệt';
                    case 3:
                        return 'Manager đã duyệt';
                    case 4:
                        return 'Đã nhận thiết bị';
                }
            }
        })
    </script>
@endpush
