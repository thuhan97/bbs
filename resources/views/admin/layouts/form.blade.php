{{-- Extends Layout --}}
@extends('layouts.admin.master')

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render($breadCrumbName) !!}
@endsection

{{-- Page Title --}}
@section('page-title', $_pageTitle)

{{-- Page Subtitle --}}
@section('page-subtitle', $_pageSubtitle)

{{-- Header Extras to be Included --}}
@section('head-extras')

@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <!-- Edit Form -->
            <div class="box box-info" id="wrap-edit-box">

                <form class="form" role="form" method="POST"
                      action="{{ $_storeLink }}" {!! $_formFiles === true ? 'enctype="multipart/form-data"' : '' !!}>
                    {{ csrf_field() }}

                    <div class="box-header with-border">
                        <h3 class="box-title">Add new</h3>

                        <div class="box-tools">
                            <a href="#" class="btn btn-sm btn-default margin-r-5 margin-l-5" onclick="history.go(-1)">
                                <i class="fa fa-caret-left"></i> <span>Back</span>
                            </a>
                            <button class="btn btn-sm btn-info margin-r-5 margin-l-5">
                                <i class="fa fa-save"></i> <span>Save</span>
                            </button>
                            @yield('more-buttons')
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        @yield('form-body')
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <!-- Edit Button -->
                        <div class="col-xs-6">
                            <div class="text-center margin-b-5 margin-t-5">
                                <button class="btn btn-info">
                                    <i class="fa fa-save"></i> <span>Save</span>
                                </button>
                            </div>
                        </div>
                        <!-- /.col-xs-6 -->
                        <div class="col-xs-6">
                            <div class="text-center margin-b-5 margin-t-5">
                                <a href="{{ $_listLink }}" class="btn btn-default">
                                    <i class="fa fa-ban"></i> <span>Cancel</span>
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
    <!-- /.row -->
@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')

@endsection
