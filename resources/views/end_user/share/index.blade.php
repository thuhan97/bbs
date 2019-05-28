@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('page-title', __l('list_share_document'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_share_document') !!}
@endsection
@section('content')
    <link rel="stylesheet" href="{{URL::asset('css/list_share_document.css')}}">
    <div class="createReport fixed-action-btn">
        <a href="#" class="button-add btn-lg red waves-effect waves-light text-white" title="Chia sẻ"
           data-target="#feedback" data-toggle="modal">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </a>
    </div>
    <div class="row">
        <div class="container-fluid">
            <form class="mb-4">
                <div class="md-form active-cyan-2 mb-3">
                    @include('layouts.partials.frontend.search-input', ['search' => $search, 'text' => __l('Search')])
                    <input type="hidden" name="page_size" value="{{$perPage}}">
                </div>
            </form>

            @if($list_document->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            Nội dung tài liệu chia sẻ
                        </th>
                        <th>
                            Người đăng
                        </th>
                        <th>
                            Ngày tải lên
                        </th>
                        <th>
                            Tải ngay
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list_document as $document)
                        <tr>
                            <td>
                                {{html_entity_decode($document->name)}}
                            </td>
                            <td class="center">
                                <?php echo isset($document->user->name) ? $document->user->name : ''; ?>
                            </td>
                            <td class="center">
                                {{$document->created_at}}
                            </td>
                            <?php
                            $ext = pathinfo($document->file, PATHINFO_EXTENSION);
                            ?>
                            <td class="center">
                                <a href="/download_file_share/{{$document->id}}" target="_blank">
                                    <i class="<?php echo isset(ICONS_TYPES_FILES[$ext]) ? ICONS_TYPES_FILES[$ext] : ''; ?>"
                                       aria-hidden="true" style="color: #4285f4;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    {{ $list_document->links() }}
                </div>
            @else
                <h2>{{__l('list_empty', ['name'=>'chia sẻ tài liệu'])}}</h2>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content" id="bg-img"
                 style="background-image: url({{ asset('img/background_share.png') }})">
                <div class="modal-header justify-content-center border-bottom-0 p-3">
                    <img class="imgHeaderPopup" src="{{ asset('img/header-popup-share.png') }}" alt="img">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <div class="background-close-icon">
                            <span class="btn-close-icon" aria-hidden="true">&times;</span>
                        </div>
                    </button>
                </div>
                <form action="{{ route('add_document') }}" method="post" id="formDocument"
                      enctype="multipart/form-data">
                @csrf <!-- {{ csrf_field() }} -->
                    <div class="modal-body">
                        <div id="contentCreateForm">
                            <label class="ml-3 text-w-400" for="titleDocument">Tiêu đề tài liệu *</label>
                            <input type="text" required id="titleDocument" class="form-control mb-3"
                                   name="titleDocument"
                                   placeholder="Tên tài liệu bạn muốn chia sẻ..." autocomplete="off">
                            <label class="ml-3 text-w-400" for="titleForm">Upload file và chia sẻ file *</label>
                            <div class="inputDnD">
                                <input type="file" required name="fileDocument"
                                       class="form-control-file text-primary font-weight-bold" id="inputFile"
                                       onchange="readUrl(this)" data-title="NHẤP CHUỘT HOẶC KÉO THẢ FILE VÀO ĐÂY">
                            </div>
                            <div class="card bg-danger text-white" id="ErrorMessaging">
                            </div>
                        </div>
                        <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                            <button type="button" class="btn btn-primary" onclick="sendAbsenceForm()">CHIA SẺ</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{URL::asset('js/list_share_document.js')}}"></script>

@endsection
