@extends('layouts.end_user')
@section('breadcrumbs')
@endsection
@section('content')
    <div id="user-login" attr="{{ \Illuminate\Support\Facades\Auth::user()->name }}"></div>
    <div class="row mb-5 ml-3">
        <div class="col-3 position-relative">
            <div class="row border-radius-1" id="option-calendar" style="height: 50px">
                <div class="col-3 p-0 m-auto">
                    {{ Form::select('year', get_years(), date('Y') , ['class'=>'yearselect browser-default custom-select w-100 border-0 select_year']) }}
                </div>
                <div class="col-9 p-0 m-auto pr-2 ">
                    {{ Form::select('month', MONTH, date('m'), ['class' => 'browser-default custom-select w-100 month ']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid col-12 row border-bottom-2 mb-2" style="position: relative;">
        <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
            <a href="{{ route('day_off_show',['status'=>ALL_DAY_OFF]) }}" class="card bg-primary border-radius-2">
                <div class="card-body mr-lg-2 row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-xl-1 d-md-flex">
                            <span id="dayoff-option-header-1"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                <i class="fas fa-clipboard-list dayoff-icoin text-primary dayoff-cioin-1-2-3"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold">{{ $dataDayOff['total'] < 10 ? "0".$dataDayOff['total'] : $dataDayOff['total'] }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Tổng đơn xin nghỉ</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header">
                                TRONG NĂM {{date('Y')}}</p>

                        </div>
                    </div>

                </div>
            </a>
        </div>
        <div class="col-sm-3 col-md-6 col-lg-3 position-relative ">
            <a href="{{ route('day_off_show',['status'=>STATUS_DAY_OFF['active']]) }}"
               class="card bg-success border-radius-2">
                <div class="card-body mr-lg-2 row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-lg-5 d-md-flex">
                            <span id="dayoff-option-header-2"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                <i class="fas fa-clipboard-check dayoff-icoin text-success dayoff-cioin-1-2-3"></i>

                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold">{{ $dataDayOff['totalActive'] < 10 ? "0".$dataDayOff['totalActive'] : $dataDayOff['totalActive'] }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Đơn xin nghỉ</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header">
                                ĐÃ DUYỆT</p>

                        </div>
                    </div>

                </div>
            </a>
        </div>
        <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
            <a href="{{ route('day_off_show',['status'=>STATUS_DAY_OFF['abide']]) }}" class="card border-radius-2"
               id="bg-yellow">
                <div class="card-body mr-lg-2 row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-lg-5  d-md-flex">
                            <span id="dayoff-option-header-3"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                               <i class="fas fa-clipboard dayoff-icoin text-warning dayoff-cioin-1-2-3"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold ">{{ $dataDayOff['totalAbide'] < 10 ? "0".$dataDayOff['totalAbide'] : $dataDayOff['totalAbide'] }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Đơn xin nghỉ</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header">
                                CHỜ DUYỆT</p>
                        </div>
                    </div>

                </div>
            </a>
        </div>
        <div class="col-sm-3 col-md-6 col-lg-3 position-relative pr-0">
            <a href="{{ route('day_off_show',['status'=>STATUS_DAY_OFF['noActive']]) }}"
               class="card bg-danger border-radius-2">
                <div class="card-body mr-lg-3 row d-flex justify-content-center px-0 ml-xxl-1">
                    <div class="media mr-lg-3 d-md-flex">
                            <span id="dayoff-option-header-4"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                <i class="fas fa-times-circle dayoff-icoin text-danger size-table"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold">{{ $dataDayOff['totalnoActive'] < 10 ? "0".$dataDayOff['totalnoActive'] : $dataDayOff['totalnoActive'] }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Đơn xin nghỉ</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header">
                                KHÔNG DUYỆT</p>
                        </div>
                    </div>

                </div>
            </a>
        </div>
    </div>
    <br>
    <div class="container-fluid row">
        <div class="col-sm-7 col-xs-12 row">
            <div class="col-5">
                {{ Form::select('search-day-off', SHOW_DAY_OFFF, ALL_DAY_OFF, ['class' => 'browser-default custom-select w-100 search-day-off border-radius-1']) }}
            </div>
            <div class="col-7 pl-0">
                <div class="input-group col-12">
                    <input type="text" class="form-control search-day-off border-radius-1"
                           placeholder="Tìm tên nhân viên"
                           name="search" id="content-search">
                    <div class="input-group-append">
                        <button class="btn btn-md btn-default m-0 py-2 z-depth-0 waves-effect form-control border-radius-1"
                                type="submit"
                                id="btnSearch">
                            <i class="fas fa-search color-search"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <br>
    <div class="container-fluid d-flex flex-column">
        <!--Table-->
        <table id="tablePreview" class="table" style="width: 99%">
            <!--Table head-->
            <thead class="grey lighten-2">
            <tr>
                <th class="text-center">STT</th>
                <th class="text-center">Nhân viên</th>
                <th class="text-center">Từ ngày</th>
                <th class="text-center">Tới ngày</th>
                <th class="text-center">Tiêu đề</th>
                <th class="text-center">Ngày nghỉ</th>
                <th class="text-center">Phê duyệt</th>
                <th class="text-center">Xem thêm</th>
            </tr>
            </thead>
            <!--Table head-->
            <!--Table body-->
            <tbody id="ajax-show">
            @foreach($dataDayOff['dateDate'] as $keys => $record)

                <tr id="rowApprove{{$loop->index+1}}">
                    <th scope="row" class="text-center">
                        {!! ((($dataDayOff['dateDate']->currentPage()*PAGINATE_DAY_OFF)-PAGINATE_DAY_OFF)+1)+$keys !!}
                    </th>

                    <td class="text-center table-name">
                        {{$record->user->name}}
                    </td>
                    <td class="text-center">
                        {{$record->start_date}}
                    </td>
                    <td class="text-center">
                        {{$record->end_date}}
                    </td>
                    <td class="text-center table-title">
                        @foreach(VACATION as $key => $value)
                            @if($key == $record->title)
                                {{ $value }}
                            @endif
                        @endforeach
                    </td>
                    <td class="text-center">{{!!!$record->number_off ?'Chưa rõ': $record->number_off}} ngày</td>

                    <td class="text-center p-0" style="vertical-align: middle;">
                        @if($record->status == STATUS_DAY_OFF['abide'])
                            <i class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                        @elseif($record->status == STATUS_DAY_OFF['active'])
                            <i class="fas fa-grin-stars fa-2x text-success"></i>
                        @else
                            <i class="fas fa-frown fa-2x text-danger"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        <span attr="{{ $record->id }}"
                              class="show-day-off @if($keys ==0)text-primary @endif">chi tiết>></span>
                    </td>
                </tr>
            @endforeach
            </tbody>

            <!--Table body-->
        </table>
    {{ $dataDayOff['dateDate']->links() }}
    <!--Table-->


        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-center" role="document">
                <div class="modal-content" id="bg-img"
                     style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                    <div class="modal-header text-center border-bottom-0 p-3">
                        <h4 class="modal-title w-100 font-weight-bold pt-2">NỘI DUNG ĐƠN</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="btn-close-icon" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3 mt-0 pb-0">
                        {{--<div class="mb-2">
                            <label class="ml-3 mt-1 text-w-400" for="exampleForm2">Người nộp đơn</label>
                            <input type="text" class="form-control select-item text-left" id="mangnaer" style="text-align: left !important;" autocomplete="off" name="end_at" readonly="readonly">
                        </div>--}}
                        <div class="mb-3">
                            <!-- Default input -->
                            <label class="ml-3 text-w-400" for="exampleForm2">Lý do:</label>
                            <input type="text"
                                   class="form-control select-item text-left" id="title" autocomplete="off"
                                   name="start_at" readonly="readonly">
                        </div>

                        <div class="mb-3">
                            <label class="ml-3 text-w-400" for="exampleFormControlTextarea5">Chi tiết lý do:</label>
                            <textarea readonly="readonly"
                                      class="form-control rounded-0 select-item {{ $errors->has('reason') ? ' has-error' : '' }}"
                                      id="exampleFormControlTextarea2" rows="3" placeholder="lý do xin nghỉ..."
                                      name="reason">{{ old('reason') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <!-- Default input -->
                            <label class="ml-3 text-w-400" for="exampleForm2">Ngày nghỉ:</label>
                            <input type="text"
                                   class="form-control select-item text-left" id="start_date" autocomplete="off"
                                   name="start_at" readonly="readonly">
                        </div>

                        <div class="mb-3">
                            <!-- Default input -->
                            <label class="ml-3 text-w-400" for="exampleForm2">Thời gian được tính:</label>
                            <input type="text"
                                   class="form-control select-item text-left" id="number_off" autocomplete="off"
                                   name="start_at" readonly="readonly">
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="form-group col-6 m-0">
                                    <label class="ml-3 text-w-400" for="inputCity">Người duyệt</label>
                                    <input type="text" class="form-control select-item" id="manager_login"
                                           autocomplete="off" name="start_at" readonly="readonly">
                                </div>
                                <!-- Default input -->
                                <div class="form-group col-6 m-0">
                                    <label class="ml-3 text-w-400" for="inputZip">Ngày duyệt</label>
                                    <input type="text" class="form-control select-item" id="approver_at"
                                           autocomplete="off" name="end_at" readonly="readonly">
                                </div>
                                <span id="errors_date" class="text-danger ml-3 "></span>
                            </div>
                        </div>
                        <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                            <button class="btn btn-primary btn-send">GỬI ĐƠN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade right" id="detailApproval" tabindex="-1" role="dialog"
             aria-labelledby="detail Approval dialog" aria-hidden="true" data-backdrop='false'>
            <div class="modal-dialog modal-full-height modal-right" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex flex-row" id="dayoff_heading"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-left">
                            <h4 class="text-bold">Nhân viên:</h4>
                            <p>
                                <strong id="dayoff_user"></strong>
                            </p>
                            <h4 class="text-bold">Lý do:</h4>
                            <p>
                                <strong id="dayoff_title"></strong>
                            </p>
                            <br>
                            <h4 class="text-bold">Ngày nghỉ:</h4>
                            <p>
                                <strong id="dayoff_duration"></strong>
                            </p>
                            <br>
                            <h4 class="text-bold">Thời gian được tính:</h4>
                            <p id="dayoff_total"></p>
                        </div>
                        <hr>
                        <div class="text-left">
                            <h4 class="text-bold">Chi tiết lý do:</h4>
                            <p id="dayoff_reason"></p>
                            <br>
                            <h4 class="text-bold">Ngày duyệt:</h4>
                            <p id="dayoff_approveDate"></p>
                            <br>
                            <h4 class="text-bold">Người duyệt:</h4>
                            <p id="dayoff_approval"></p>
                            <br>
                            <h4 class="text-bold important">Ý kiến</h4>
                            <p id="dayoff_comment" contentEditable="true"></p>
                        </div>
                        <div class="card bg-danger text-white" id="ErrorMessaging">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Đóng
                        </button>
                        <button type="button" class="btn btn-primary" id="detailApproveBtn">Phê duyệt</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('.select_year , .month , .search-day-off').on('change', function () {
                    var year = $('.select_year ').val();
                    var month = $('.month ').val();
                    var status = $('.search-day-off ').val();
                    $.ajax
                    ({
                        'url': '/phe-duyet-ngay-nghi/search/',
                        'type': 'get',
                        'data': {'year': year, 'month': month, 'status': status},
                        success: function (data) {
                            $('.pagination').hide();
                            var html = teamplate(data);
                            $('#ajax-show').html(html);
                        }
                    });
                })

                $('#btnSearch').on('click', function () {
                    var search = $('#content-search').val();
                    var year = $('.select_year ').val();
                    var month = $('.month ').val();
                    var status = $('.search-day-off ').val();
                    $.ajax
                    ({
                        'url': '/phe-duyet-ngay-nghi/search/',
                        'type': 'get',
                        'data': {'year': year, 'month': month, 'status': status, 'search': search},
                        success: function (data) {
                            $('.pagination').hide();
                            var html = teamplate(data);
                            $('#ajax-show').html(html);
                        }
                    });
                })

                $(document).on('click', '.show-day-off', function () {
                    var id = $(this).attr('attr');
                    var name = $(this).parent().prev().prev().prev().prev().prev().prev().text();
                    var number_off = $(this).parent().prev().prev().text();
                    $.ajax
                    ({
                        'url': '/duyet-ngay-nghi/' + id,
                        'type': 'get',
                        success: function (datas) {
                            var vacation = [];
                            vacation[1] = 'Lý do cá nhân';
                            vacation[2] = 'Nghỉ đám cưới';
                            vacation[3] = 'Nghỉ đám hiếu';
                            $.each(vacation, function (key, value) {
                                if (key == datas.title) {
                                    $('#title').val(value)
                                }
                            });
                            $('#exampleFormControlTextarea2').text(datas.reason);
                            $('#start_date').val(datas.start_date + ' - ' + datas.end_date);
                            $('#end_date').val(datas.end_at);
                            $.each(vacation, function (key, value) {
                                if (key == datas.title) {
                                    $('#title').val(value)
                                }
                            });
                            $('#number_off').val(number_off);
                            $('#mangnaer').val(name);
                            $('#manager_login').val($('#user-login').attr('attr'));
                            $('#approver_at').val(datas.approver_date);
                            if (datas.status == 0) {
                                $('.btn-send').text('DUYỆT ĐƠN');
                            } else if (datas.status == 1) {
                                $('.btn-send').text('HỦY DUYỆT');
                            } else if (datas.status == 2) {
                                $('.btn-send').text('DUYỆT ĐƠN');
                            }

                            $('#modal-form').modal('show');


                        }
                    });
                });
            });

            function teamplate(data) {
                var html = '';
                $.each(data.data.data, function (key, value) {
                    console.log(data.data)
                    html += '<tr><th scope="row" class="text-center">';
                    html += key + 1;
                    html += ' </th> <td class="text-center table-name">';
                    html += value['name'];
                    html += ' </td> <td class="text-center">';
                    html += value['start_date'];
                    html += '</td> <td class="text-center">';
                    html += value['end_date']

                    html += '</td> <td class="text-center table-title">';
                    if (value['title'] == 1) {
                        html += 'Lý do cá nhân';
                    } else if (value['title'] == 2) {
                        html += 'Nghỉ đám cưới';
                    }
                    else {
                        html += 'Nghỉ đám hiếu';
                    }
                    html += '</td><td class="text-center">'
                    if (value['number_off']) {
                        html += value['number_off'] + 'ngày';
                    } else {
                        html += 'chưa rõ';
                    }
                    html += '</td> <td class="text-center p-0" style="vertical-align: middle;">';
                    if (value['status'] == 0) {
                        html += '<i class="fas fa-meh-blank fa-2x text-warning text-center"></i>';
                    } else if (value['status'] == 1) {
                        html += '<i class="fas fa-grin-stars fa-2x text-success"></i>';
                    }
                    else {
                        html += '<i class="fas fa-frown fa-2x text-danger"></i>';
                    }
                    html += '</td> <td class="text-center">';
                    html += ' <span class="';
                    if (key == 0) {
                        html += 'text-primary';
                    }
                    html += ' show-day-off "attr="' + value['id'] + '"';
                    html += '>chi tiết>></span>';
                    html += '</td> </tr>';
                });
                return html;
            }
        </script>
    </div>
@endsection
