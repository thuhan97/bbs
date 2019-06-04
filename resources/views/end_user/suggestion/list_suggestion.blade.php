@php
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/month=([0-9]+)/', $url, $m);
    $m = isset($m[1]) ? $m[1] : 0;
@endphp
@extends('layouts.end_user')
@section('page-title', __l('list_suggestions'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('list_suggestions') !!}
@endsection
@section('content')
    @if (session()->has('success'))
        <div id="main" class="pt-3">
            <div class="alert alert-success mb-0" role="alert">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form class="mb-4">
                    <div class="md-form active-cyan-2 mb-3">
                        @include('layouts.partials.frontend.search-input', ['search' => $search, 'text' => __l('Search')])
                        <input type="hidden" name="page_size" value="{{$perPage}}">
                    </div>
                </form>
                @if($list_suggestions->isNotEmpty())
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="blue lighten-5">
                            <th class="d-none d-xl-table-cell" style="width: 50px">
                                Stt
                            </th>
                            <th style="width: 220px">
                                Người góp ý
                            </th>
                            <th style="width:250px">
                                Nội dung
                            </th>
                            <th style="width:200px">
                                Ý kiến admin
                            </th>
                            <th class="d-none d-xl-table-cell" style="width:200px">
                                Ý kiến người duyệt
                            </th>
                            <th class="d-none d-xxl-table-cell" style="width: 150px">
                                Ngày góp ý
                            </th>
                            <th class="d-none d-xl-table-cell" style="width: 120px">
                                Trạng thái
                            </th>
                            <th class="" style="width: 100px">
                                Chức năng
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list_suggestions as $idx => $suggestion)
                            @if($suggestion->isseus_id == auth()->id())
                                <tr>
                                    <td class="d-none d-xl-table-cell center">
                                        {!! ((($list_suggestions->currentPage()*PAGINATE_DAY_OFF)-PAGINATE_DAY_OFF)+1)+$idx !!}
                                    </td>
                                    <td class="center">
                                        {{$suggestion->user->name ?? ''}}
                                    </td>
                                    <td class="center">
                                        {{str_limit(strip_tags(nl2br($suggestion->content) ), 25) }}
                                    </td>
                                    <td class="center">
                                        {{str_limit(strip_tags(nl2br($suggestion->comment) ), 25) }}
                                    </td>
                                    <td class="center d-none d-xl-table-cell">
                                        {{str_limit(strip_tags(nl2br($suggestion->isseus_comment) ), 25) }}
                                    </td>
                                    <td class="d-none d-xxl-table-cell center">
                                        {{$suggestion->created_at->format(DATE_FORMAT)}}
                                    </td>
                                    <td class="d-none d-xl-table-cell text-center">
                                        @if($suggestion->status == DEFAULT_VALUE)
                                            <i data-toggle="tooltip" data-placement="right" title="Chờ phê duyệt"
                                               class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                                        @else
                                            <i data-toggle="tooltip" data-placement="right" title="Đã duyệt đơn"
                                               class="fas fa-grin-stars fa-2x text-success"></i>
                                        @endif
                                    </td>
                                    <th class="">
                                        <a href="{{route('detail_suggestions', ['id' => $suggestion->id])}}"
                                           class="btn btn-primary btn-sm">Xem
                                        </a>
                                    </th>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        {{ $list_suggestions->links() }}
                    </div>
                @else
                    <h2>{{__l('list_empty', ['name'=>'đề xuất & góp ý'])}}</h2>
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{URL::asset('js/list_suggestion.js')}}"></script>
@endsection