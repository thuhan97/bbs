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
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-10">
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
                            <th class="d-none d-sm-table-cell" style="width: 50px">
                                #
                            </th>
                            <th style="width: 180px">
                                Người góp ý
                            </th>
                            <th>
                                Nội dung
                            </th>
                            <th class="d-none d-sm-table-cell" style="width: 150px">
                                Ngày góp ý
                            </th>
                            <th class="d-none d-sm-table-cell" style="width: 200px">
                                Trạng thái duyệt
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list_suggestions as $idx => $suggestion)
                            <tr>
                                <td class="d-none d-sm-table-cell center">
                                    <a href="{{route('detail_suggestions', ['id' => $suggestion->id])}}">{{$idx + 1}}
                                    </a>

                                </td>
                                <td class="center">
                                    {{$suggestion->user->name ?? ''}}
                                </td>
                                <td class="center">
                                    {!! nl2br($suggestion->content) !!}
                                </td>
                                <td class="d-none d-sm-table-cell center">
                                    {{$suggestion->created_at->format(DATE_FORMAT)}}
                                </td>
                                <td class="d-none d-sm-table-cell center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input checkout-approve" id="{{$idx}}"
                                               data="{{$suggestion->id}}"
                                               data-status="{{$suggestion->status}}" <?php echo ($suggestion->status == 1) ? 'checked = checked' : null ?>>
                                        <label class="form-check-label"
                                               for="{{$idx}}"><?php echo ($suggestion->status == 1) ? '<strong style="color:blue;">Đã duyệt</strong>' : '<strong style="color:red;">Chưa duyệt</strong>' ?></label>
                                    </div>
                                </td>
                            </tr>
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
    <script type="text/javascript" src="{{asset_ver('js/list_suggestion.js')}}"></script>
@endsection
