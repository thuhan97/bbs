@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off') !!}
@endsection
@section('content')
    {{--<i class="fas fa-camera-retro"></i> fa-camera-retro--}}

    <div class="container-fluid col-12 row">
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">999</h1>
                    <p class="card-subtitle text-white-50">ngày</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Số ngày nghỉ</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-success">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">999</h1>
                    <p class="card-subtitle text-white-50">ngày</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Có phép</p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-xs-6">
            <div class="card bg-warning">
                <div class="card-body">
                    <h1 class="white-text font-weight-light">999</h1>
                    <p class="card-subtitle text-white-50">ngày</p>
                    <p class="card-title text-uppercase font-weight-bold card-text white-text">Khả dụng</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid col-12 flex-row-reverse d-flex">
        <button class="btn btn-primary dropdown-toggle mr-4" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">Hiển thị
        </button>

        <div class="dropdown-menu">
            <a class="dropdown-item">
                <span class="d-flex">
                    <span class="green-red-circle mr-2"></span>
                    <span class="content">Tất cả</span>
                </span>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
                <span class="d-flex">
                    <span class="red-circle mr-2"></span>
                    <span class="content">Chưa duyệt</span>
                </span>
            </a>
            <a class="dropdown-item" href="#">
                <span class="d-flex">
                    <span class="green-circle mr-2"></span>
                    <span class="content">Đã duyệt</span>
                </span>
            </a>
        </div>
    </div>

    <div class="container-fluid col-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Từ ngày</th>
                <th scope="col">Tới ngày</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Ngày nghỉ</th>
                <th scope="col">Phê duyệt</th>
                <th scope="col">Xem thêm</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0" data-toggle="modal"
                            data-target="#detailAbsence">Chi tiết
                    </button>
                </td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">1</th>
                <td>22/11/2018</td>
                <td>22/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>0.5 ngày</td>
                <td>
                    <div class="red-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>25/11/2018</td>
                <td>26/11/2018</td>
                <td>Lý do cá nhân</td>
                <td>1 ngày</td>
                <td>
                    <div class="green-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>01/12/2018</td>
                <td>03/12/2018</td>
                <td>Đám cưới</td>
                <td>2 ngày</td>
                <td>
                    <div class="green-circle"></div>
                </td>
                <td>
                    <button type="button" class="btn btn-indigo btn-sm m-0">Chi tiết</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal: modalPoll -->
    <div class="modal fade right" id="detailAbsence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-full-height modal-right modal-notify modal-info" role="document">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead d-flex flex-row">
                        Ngày nghỉ 22/11/2018
                        <span class="red-circle ml-2"></span>
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">×</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-left">
                        <h4 class="text-bold">Lý do:</h4>
                        <p>
                            <strong>Lý do cá nhân</strong>
                        </p>
                        <br>
                        <h4 class="text-bold">Ngày nghỉ:</h4>
                        <p>
                            <strong>22/11/2018 - 22/11/2018</strong>
                        </p>
                        <br>
                        <h4 class="text-bold">Thời gian được tính:</h4>
                        <p>
                            <strong>0.5 ngày</strong>
                        </p>
                    </div>
                    <hr>
                    <div class="text-left">
                        <h4 class="text-bold">Chi tiết lý do:</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias cum, dicta ea error expedita
                            facere harum possimus recusandae veritatis vitae.
                        </p>
                        <br>
                        <h4 class="text-bold">Ngày duyệt:</h4>
                        <p>22/11/2018 11:11:11 AM</p>
                        <br>
                        <h4 class="text-bold">Người duyệt:</h4>
                        <p>Admin</p>
                        <br>
                        <h4 class="text-bold important">Ý kiến</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur dolor error et iusto
                            nemo non. Debitis dolor nisi sed temporibus!
                        </p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-primary waves-effect waves-light">Báo cáo
                        <i class="fa fa-paper-plane ml-1"></i>
                    </a>
                    <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal: modalPoll -->
@endsection