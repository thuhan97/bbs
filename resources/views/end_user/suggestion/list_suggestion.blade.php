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
    <div class="row">
        <div class="col-12 col-xxl-10">
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
                        <th style="width: 50px">
                            #
                        </th>
                        <th style="width: 200px">
                            Người góp ý
                        </th>
                        <th>
                            Nội dung
                        </th>
                        <th style="width: 200px">
                            Ngày góp ý
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list_suggestions as $idx => $suggestion)
                        <tr>
                            <td class="center">
                                {{$idx + 1}}
                            </td>
                            <td class="center">
                                {{$suggestion->user->name ?? ''}}
                            </td>
                            <td class="center">
                                {!! nl2br($suggestion->content) !!}
                            </td>
                            <td class="center">
                                {{$suggestion->created_at}}
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
@endsection