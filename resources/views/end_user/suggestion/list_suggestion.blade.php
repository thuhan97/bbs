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
	<div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Người góp ý
                </th>
                <th>
                    Nội dung
                </th>
                <th>
                    Ngày góp ý
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($list_suggestions as $suggestion)
                <tr>
                    <td class="center">
                    	<?php echo isset($suggestion->user->name) ? $suggestion->user->name : ''; ?>
                    </td>
                    <td class="center">
                        {{$suggestion->content}}
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
    </div>
@endsection