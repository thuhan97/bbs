@extends('layouts.admin.master')
@section('page-title', 'Admin page')
@section('breadcrumbs')
    {!! Breadcrumbs::render($resourceRoutesAlias) !!}
@endsection
@section('content')
    <h2>Welcome!</h2>
@endsection
