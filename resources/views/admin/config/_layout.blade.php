{{-- Extends Layout --}}
@extends('layouts.admin.master')

<?php

?>

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin::configs') !!}
@endsection

{{-- Page Title --}}
@section('page-title', 'Cấu hình')

{{-- Page Subtitle --}}
@section('page-subtitle', 'Thiết lập hệ thống')

{{-- Header Extras to be Included --}}
@section('head-extras')

@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <!-- Edit Form -->
            <div class="box box-info" id="wrap-edit-box">

                <form class="form" role="form" method="POST"
                      action="{{ route('admin::configs.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="box-header with-border">
                        <h3 class="box-title">Thiết lập hệ thống</h3>

                        <div class="box-tools">
                            <button class="btn btn-sm btn-info margin-r-5 margin-l-5">
                                <i class="fa fa-save"></i> <span>Lưu</span>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        @include($resourceAlias)
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
