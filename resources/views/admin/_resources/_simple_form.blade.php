@extends('layouts.admin.master')
@section('page-title', $pageTitle)
@section('breadcrumbs')
    {!! Breadcrumbs::render($breadCrumb) !!}
@endsection
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <!-- Edit Form -->
            <div class="box box-info" id="wrap-edit-box">
                <form class="form" role="form" method="POST" action="{{route($formAction)}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>

                        <div class="box-tools">
                            <a href="{{route($baseRoute . '.index')}}"
                               class="btn btn-sm btn-primary margin-r-5 margin-l-5">
                                <i class="fa fa-search"></i> <span>Danh sách</span>
                            </a>
                            <button class="btn btn-sm btn-info margin-r-5 margin-l-5">
                                <i class="fa fa-save"></i> <span>Lưu</span>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        @yield('form-content')
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <!-- Edit Button -->
                        <div class="col-xs-6">
                            <div class="text-center margin-b-5 margin-t-5">
                                <button class="btn btn-info">
                                    <i class="fa fa-save"></i> <span>Lưu</span>
                                </button>
                            </div>
                        </div>
                        <!-- /.col-xs-6 -->
                        <div class="col-xs-6">
                            <div class="text-center margin-b-5 margin-t-5">
                                <a href="{{route($baseRoute . '.index')}}" class="btn btn-default">
                                    <i class="fa fa-ban"></i> <span>Hủy</span>
                                </a>
                            </div>
                        </div>
                        <!-- /.col-xs-6 -->
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
            <!-- /End Edit Form -->
        </div>
    </div>
@endsection
