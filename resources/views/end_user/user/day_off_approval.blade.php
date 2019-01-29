@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off_approval') !!}
@endsection
@section('content')
    @if(!$isApproval)
        <h2>Bạn không có quyền truy cập chức năng này</h2>
    @else

    @endif
@endsection