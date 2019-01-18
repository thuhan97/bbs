@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('report') !!}
@endsection
@section('content')
    <div class="createReport fixed-action-btn">
        <a href="{{route('create_report')}}" class="btn-floating btn-lg red waves-effect waves-light text-white">
            <i class="fas fa-pencil-alt"></i>
        </a>
    </div>
    <form class="mb-4 mb-3">
        <div class="md-form active-cyan-2 mb-0">
            <div class="row">
                <div class="col-md-4">
                    <input id="txtSearch" name="search" class="form-control" type="text"
                           placeholder="Nhập tiêu đề báo cáo" aria-label="Search">
                </div>
                <div class="col-md-4">
                    <input name="search" class="form-control" type="text"
                           placeholder="Nhập tên nhân viên" aria-label="Search">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                </div>
            </div>

        </div>
        <label class="pure-material-checkbox">
            <input type="checkbox" name="check_all">
            <span>Xem tất cả báo cáo</span>
        </label>
    </form>

@endsection