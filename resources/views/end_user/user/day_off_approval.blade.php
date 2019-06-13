@extends('layouts.end_user')
@section('page-title', __l('day_off_approval'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off_approval') !!}
@endsection
@section('content')
    <?php
    if (isset($dayOffSearch)) {
        $getDayOff = $dayOffSearch['data'];
    } elseif (isset($status)) {
        $getDayOff = $dataDayOff['dataDate'];
    } else {
        $getDayOff = $dataDayOff['data'];
    }
    if (session()->has('data')) {
        $data = session()->get('data');
    }
    if (session()->has('check')) {
        $check = session()->get('check');
    }
    if (session()->has('dayOff')) {
        $dayOff = session()->get('dayOff');
    }
    if (session()->has('manager')) {
        $manager = session()->get('manager');
    }
    $searchStart = date((date('Y') - 1) . '/01/01', strtotime('tomorrow + 1day'));
    ?>
    @if(session()->has('success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã duyệt đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif
    @if(session()->has('close'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã hủy đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif
    <form action="{{ route('day_off_search') }}" method="get" id="form-search">
        <div id="user-login" attr="{{ \Illuminate\Support\Facades\Auth::user()->name }}"></div>
        {{-- <div class="row mb-3">
             <div class="col-6 col-sm-2 col-xl-1 no-padding-right">
                 {{ Form::select('year', get_years(), $year ?? date('Y') , ['class'=>'yearselect browser-default custom-select w-100 border-0 select_year option-select p-1']) }}
             </div>
             <div class="col-6 col-sm-4 col-xl-2 no-padding-left">
                 {{ Form::select('month', MONTH, $month ?? '', ['class' => 'browser-default custom-select w-100 month option-select','placeholder'=>'Chọn tháng']) }}
             </div>
         </div>--}}

        <div class="d-flex mb-3" >
            <div class="mr-1 mr-md-3">
                <div class="d-md-flex justify-content-center" >
                    <div>
                        <label class="text-w-400 pt-2" for="">Từ ngày</label>
                    </div>
                    <div class="position-relative">
                        <input type="text"
                               class="form-control border-0 select-item z- ml-2"
                               id="search_start_at" autocomplete="off" name="search_start_at"
                               value="{{  $start ?? $searchStart  }}"
                               readonly="readonly">
                        <i class="far fa-calendar-alt position-absolute calendar-search"></i>
                    </div>
                </div>
            </div>
            <div class="mr-1 mr-md-3">
                <div class="d-md-flex justify-content-center">
                    <div>
                        <label class="text-w-400 pt-2 label-from-days" for="inputZip">Tới ngày</label>
                    </div>
                    <div class="position-relative">
                        <input type="text"
                               class="form-control select-item  border-0 ml-2"
                               id="search_end_at" autocomplete="off" name="search_end_at"
                               value="{{ $end ?? ''}}"
                               readonly>
                        <i class="far fa-calendar-alt position-absolute calendar-search"></i>
                    </div>
                </div>
            </div>
            <div>
                <div class="d-md-flex justify-content-center">
                    <div>
                        <button class="form-control select-item  border-0 btn-secondary" id="result-search"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>



        <div class="d-none d-xl-flex container-fluid col-12 row border-bottom-2 mb-3" style="position: relative;">
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
                <a href="{{ route('day_off_show',['status'=>ALL_DAY_OFF]) }}" class="card bg-primary border-radius-2 day-off-approval-card">
                    <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
                        <div class="media mr-xl-1 d-md-flex">
                            <span id="dayoff-option-header-1"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                <i class="fas fa-clipboard-list dayoff-icoin text-primary dayoff-cioin-1-2-3"></i>
                            </span>
                            <div class="media-body text-center text-md-left ml-xl-4">
                                <h1 class="white-text font-weight-bold content-card-day-off-approval">{{ $dataDayOff['total'] < TOTAL_COUNT_DAY_OFF ? ($dataDayOff['total'] == DEFAULT_VALUE ? $dataDayOff['total']: "0".$dataDayOff['total'])  : $dataDayOff['total'] }}</h1>
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
                   class="card bg-success border-radius-2 day-off-approval-card">
                    <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
                        <div class="media mr-lg-5 d-md-flex">
                            <span id="dayoff-option-header-2"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                <i class="fas fa-clipboard-check dayoff-icoin text-success dayoff-cioin-1-2-3"></i>
                            </span>
                            <div class="media-body text-center text-md-left ml-xl-4">
                                <h1 class="white-text font-weight-bold content-card-day-off-approval">{{ $dataDayOff['totalActive'] < TOTAL_COUNT_DAY_OFF ?  ($dataDayOff['totalActive'] == DEFAULT_VALUE ? $dataDayOff['totalActive']: "0".$dataDayOff['totalActive']) : $dataDayOff['totalActive'] }}</h1>
                                <p class="card-subtitle text-white-50 text-size-table">Đơn xin nghỉ</p>
                                <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header">
                                    ĐÃ DUYỆT</p>

                            </div>
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
                <a href="{{ route('day_off_show',['status'=>STATUS_DAY_OFF['abide']]) }}" class="card border-radius-2 day-off-approval-card"
                   id="bg-yellow">
                    <div class="card-body  row d-flex justify-content-center px-0 ml-xxl-2">
                        <div class="media mr-lg-5  d-md-flex">
                            <span id="dayoff-option-header-3"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                               <i class="fas fa-clipboard dayoff-icoin text-warning dayoff-cioin-1-2-3"></i>
                            </span>
                            <div class="media-body text-center text-md-left ml-xl-4">
                                <h1 class="white-text font-weight-bold content-card-day-off-approval">{{ $dataDayOff['totalAbide'] < TOTAL_COUNT_DAY_OFF ? ($dataDayOff['totalAbide'] == DEFAULT_VALUE ? $dataDayOff['totalAbide']: "0".$dataDayOff['totalAbide']) : $dataDayOff['totalAbide'] }}</h1>
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
                   class="card bg-danger border-radius-2 day-off-approval-card">
                    <div class="card-body mr-lg-3 row d-flex justify-content-center px-0 ml-xxl-1">
                        <div class="media mr-lg-3 d-md-flex">
                            <span id="dayoff-option-header-4"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                <i class="fas fa-times-circle dayoff-icoin dayoff-icoin-close text-danger size-table"></i>
                            </span>
                            <div class="media-body text-center text-md-left ml-xl-4">
                                <h1 class="white-text font-weight-bold content-card-day-off-approval">{{ $dataDayOff['totalnoActive'] < TOTAL_COUNT_DAY_OFF ? ($dataDayOff['totalnoActive'] == DEFAULT_VALUE ? $dataDayOff['totalnoActive']: "0".$dataDayOff['totalnoActive']) : $dataDayOff['totalnoActive'] }}</h1>
                                <p class="card-subtitle text-white-50 text-size-table">Đơn xin nghỉ</p>
                                <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header">
                                    KHÔNG DUYỆT</p>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 col-md-4">
            </div>
            <div class="col-sm-8 text-right col-md-8">
                <div class="row mb-2">
                    <div class="col-lg-2"></div>
                    <div class="col-12 col-sm-8 col-lg-6 pr-0">
                        <div class="{{--pr-lg-1 pr-sm-4--}} pr-4 pr-sm-0 mb-2">

                            <a href="{{route('day_off')}}" class="btn btn-primary"
                               id="btn-detail-day-off" type="button">
                                Xem ngày phép
                            </a>

                        </div>
                    </div>
                    <div class="d-none d-sm-block col-sm-4">
                        {{ Form::select('status', SHOW_DAY_OFFF, $status ?? ALL_DAY_OFF, ['class' => 'browser-default custom-select search-day-off border-radius-1 option-select float-right h-48 mt-1']) }}
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
    <div class="d-flex flex-column" id="table-phone">
        <!--Table-->
        <table id="tablePreview" class="table ">
            <!--Table head-->
            <thead class="grey lighten-2">
            <tr>
                <th class="text-center d-none d-xl-table-cell">STT</th>
                <th class="text-center ">Nhân viên</th>
                <th class="text-center ">Từ ngày</th>
                <th class="text-center d-none d-sm-table-cell">Tới ngày</th>
                <th class="text-center ">Tiêu đề</th>
                <th class="text-center d-none d-xl-table-cell">Nội dung</th>
                <th class="text-center d-none d-xl-table-cell">Nghỉ trừ phép</th>
                <th class="text-center  d-none d-sm-table-cell">Nghỉ không lương</th>
                <th class="text-center d-none d-sm-table-cell">Phê duyệt</th>
                <th class="text-center ">Xem thêm</th>
            </tr>
            </thead>
            <!--Table head-->
            <!--Table body-->
            <tbody id="ajax-show">
            @foreach($getDayOff as $keys => $record)
                <tr id="rowApprove{{$loop->index+1}}">
                    <th scope="row" class="text-center d-none d-xl-table-cell">
                        {!! ((($getDayOff->currentPage()*PAGINATE_DAY_OFF)-PAGINATE_DAY_OFF)+1)+$keys !!}
                    </th>

                    <td class="text-center ">
                        {{$record->user->name}}
                    </td>
                    <td class="text-center ">
                        {{ $record->title != DAY_OFF_TITLE_DEFAULT ? \App\Helpers\DateTimeHelper::checkTileDayOffGetDate($record->start_at) : $record->start_date  }}
                    </td>
                    <td class="text-center d-none d-sm-table-cell">
                        {{ $record->title != DAY_OFF_TITLE_DEFAULT ? \App\Helpers\DateTimeHelper::checkTileDayOffGetDate($record->end_at) : $record->end_date  }}
                    </td>
                    <td class="text-center ">{{ array_key_exists($record->title, VACATION_FULL) ? VACATION_FULL[$record->title] : ''  }}</td>
                    <td class="text-center d-none d-xl-table-cell">{!! nl2br($record->reason) !!}</td>
                    <td class="text-center d-none d-xl-table-cell">
                        {{!!!$record->number_off ? ($record->status != STATUS_DAY_OFF['noActive'] ? 'Đang duyệt' : '') : checkNumber($record->number_off).' ngày'}}
                    </td>
                    <td class="text-center d-none d-sm-table-cell">
                        {{!!! $record->absent == DEFAULT_VALUE  ? ($record->status == STATUS_DAY_OFF['abide'] ? 'Đang duyệt' : (  $record->status == STATUS_DAY_OFF['noActive'] ? '' : checkNumber($record->absent) .' ngày')) :  checkNumber($record->absent) .' ngày'}}
                    </td>

                    <td class="text-center p-0 d-none d-sm-table-cell" style="vertical-align: middle;">
                        @if($record->status == STATUS_DAY_OFF['abide'])
                            <i data-toggle="tooltip" data-placement="right" title="Chờ phê duyệt"
                               class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                        @elseif($record->status == STATUS_DAY_OFF['active'])
                            <i data-toggle="tooltip" data-placement="right" title="Đã duyệt đơn"
                               class="fas fa-grin-stars fa-2x text-success"></i>
                        @else
                            <i data-toggle="tooltip" data-placement="right" title="Không duyệt"
                               class="fas fa-frown fa-2x text-danger"></i>
                        @endif
                    </td>
                    <td class="text-center ">
                        <p id="{{ $record->id }}" class=" btn-sm m-0 detail-dayoff" style="cursor: pointer" attr="{{ $record->id }}">Chi
                            tiết >></p>
                    </td>

                </tr>
            @endforeach
            </tbody>

            <!--Table body-->
        </table>
    {{$getDayOff->render('end_user.paginate') }}
    <!--Table-->

        <form action="{{ route('edit_day_off_detail') }}" method="post" id="edit-day-off">
            @csrf
            <div class="modal fade modal-open custom-modal" id="modal-form" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-center approval-ipad-pro" role="document">
                    <div class="modal-content modal-center-display bg-img-day-off" id="bg-img"
                         style="background-image: url({{ asset_ver('img/font/xin_nghi.png') }})">
                        <div class="modal-header text-center border-bottom-0 pb-0">
                            <h4 class="modal-title w-100 font-weight-bold pt-2">NỘI DUNG ĐƠN</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="btn-close-icon" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body mx-3 mt-0 p-0">
                            <div class="mb-3">
                                <label class="ml-3 text-d-bold" for="exampleFormControlTextarea5">Tên nhân
                                    viên</label>
                                <div class="ml-3" id="user-day-off"></div>

                            </div>
                            <div class="mb-2">
                                <label class="ml-3 text-d-bold" for="exampleFormControlTextarea5">Số ngày nghỉ phép tồn : </label>
                                <strong class="" id="number_off_remain"></strong>

                            </div>
                            <div class="mb-2 ml-3 ">
                                <!-- Default input -->
                                <label class="text-d-bold" for="exampleForm2">Thời gian được tính:</label>
                                <strong class="" id="number_off"></strong>
                                <span id="approver_num" class="text-danger"></span>
                            </div>
                            <div class="mb-2">
                                <!-- Default input -->
                                <label class="ml-3 text-d-bold" for="exampleForm2">Ngày nghỉ:</label>
                                <div class="ml-3" id="strat_end"></div>
                            </div>
                            <div class="mb-3">
                                <!-- Default input -->
                                <label class="ml-3 text-d-bold" for="exampleForm2">Lý do:</label>
                                <div class="ml-3" id="title"></div>
                            </div>

                            <div class="mb-2">
                                <label class="ml-3 text-d-bold" for="exampleFormControlTextarea5">Chi tiết lý
                                    do:</label>
                                <div class="ml-3" id="reason"></div>
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="form-group col-6 m-0">
                                        <label class="ml-3 text-d-bold" for="inputCity">Người duyệt</label>
                                        <div class="ml-3">{{ auth()->user()->name }}</div>
                                    </div>
                                    <!-- Default input -->
                                    <div class="form-group col-6 m-0 p-0" id="remove-app-date">
                                        <label class="ml-3 text-d-bold" for="inputZip">Ngày duyệt</label>
                                        <div class="ml-3" id="approver_date"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 ml-3" id="remove-app-comment">
                                <label class="text-d-bold" for="exampleFormControlTextarea5">Ý kiến người
                                    duyệt</label>
                                <div class="" id="app-comment"></div>
                            </div>
                            <div class=" mb-1 pb-2 d-flex justify-content-center border-top-0 rounded mb-0"
                                 id="btn-submit-form">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('delete_day_off') }}" method="post" id="close_day_off">
            @csrf
            <div class="modal fade custom-modal" id="basicExampleModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <input type="hidden" value="" name="id_close" id="id-close">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="ml-4 modal-title text-center" id="exampleModalLabel">Bạn có chắc chắn muốn hủy
                                đơn
                                này không ? </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" name="approval_coment" id="approval_comment">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-secondary w-25">ĐỒNG Ý</button>
                            <span class="btn btn-primary w-25" data-dismiss="modal">HỦY</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        @push('extend-css')
            <link href="{{ asset_ver('bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
            <link href="{{ asset_ver('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
                  rel="stylesheet">
            <style>
                #textareaForm {
                    height: 150px;
                }

                label {
                    user-select: none;
                }
            </style>
        @endpush
        <script src="{{ asset_ver('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset_ver('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset_ver('js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function (e) {
               var hash =window.location.hash;
                if (hash){
                    var id =$(hash).attr('attr');
                    load_data(id)
                }
                $(document).on('click','#notification',function () {
                    location.reload();
                })
                $('.calendar-search').on('click', function () {
                    $(this).prev().datepicker('show');
                })

                $('.option-select').on('change', function () {
                    $("#form-search").submit();
                });
                $('#result-search').on('click', function () {
                    $("#form-search").submit();
                });
                $("#edit-day-off").validate({
                    rules: {
                        number_off: {
                            required: true,
                            number: true,
                            min: 0
                        },
                        approve_comment: {
                            minlength: 3,
                            maxlength: 100
                        }
                    },
                    messages: {
                        number_off: {
                            required: "Vui lòng nhập số ngày nghỉ được phê duyệt",
                            number: "Vui lòng nhập đúng định dạng số",
                            min: "Không thể chọn số ngày phê duyệt nhỏ hơn 0"
                        },
                        approve_comment: {
                            minlength: "nội dung ít nhất là 3 kí tự",
                            maxlength: "nội dung nhiều nhất là 100 kí tự"
                        }
                    }
                });

                $('#search_start_at , #search_end_at').datepicker({format: 'yyyy/mm/dd', orientation: 'bottom'});
                $('#start_date').datetimepicker({
                    hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                    daysOfWeekDisabled: [0, 6],


                });
                $('#end_date').datetimepicker({
                    hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                    daysOfWeekDisabled: [0, 6],
                });
                $('#btn-edit-day-off').on('click', function () {

                    $("#edit-day-off").submit();
                })


                $('.detail-dayoff').on('click', function () {
                    var id = $(this).attr('attr');
                    load_data(id)
                })
                $('.detail-dayoff').on('click', function () {
                    $(this).addClass('text-primary');
                })
                $(document).on('click' , '#close-day-off' , function () {
                    var comment=$(('#exampleFormControlTextarea4')).val();
                    if (comment.length < 3){
                        if (comment.length == 0){
                            $('#basicExampleModal').modal('show')
                        }
                        $('#basicExampleModal').modal('hide')
                    } else {
                        $('#basicExampleModal').modal('show')
                    }
                    $('#approval_comment').val(comment);
                })
            });
    function load_data(id) {
        var title = {
            "1": "Lý do cá nhân",
            "2": "Nghỉ đám cưới",
            "3": "Nghỉ đám hiếu",
            "4": "Nghỉ thai sản",
        }
        $.ajax
        ({
            'url': '{{ route('day_off_detail') }}' + '/' + id,
            'type': 'get',
            success: function (data) {
                $('#user-day-off').html(data.userdayoff);
                if (data.time) {
                    $('#strat_end').html(data.time);
                } else {
                    $('#strat_end').html(data.data.start_date + ' - ' + data.data.end_date);
                }
                if (data.data.reason) {
                    $('#reason').html(data.data.reason.replace(/\n/g, "<br />"));
                }
                $('#id-delete').val(data.data.id);
                if (title.hasOwnProperty(data.data.title)) {
                    $('#title').html(title[data.data.title]);
                }
                if (data.data.approver_date) {
                    $('#remove-app-date').show();
                    $('#approver_date').html(data.data.approver_date);
                } else {
                    $('#remove-app-date').hide();
                }
                if (data.data.numoff || data.data.absent) {
                    $('#remove-numoff').show();
                } else {
                    $('#remove-numoff').hide();
                }
                $('#number_off').html(data.approver_num + ' ngày') ;
                $('#number_off_remain').html(data.totalRemain +' ngày' )
                if (data.data.status == 0) {
                    $('#app-comment').html('<textarea class="form-control reason_id rounded-0 select-item "id="exampleFormControlTextarea4" rows="3" placeholder="Nhập ý kiến của người duyệt" name="approve_comment"></textarea>');
                    $('#approver_num').html('<input type="hidden" class="form-control select-item" autocomplete="off" name="number_off" value="'+ data.approver_num +'" id="">')
                    $('#btn-submit-form').html('<button type="submit" class="btn  btn-primary">DUYỆT ĐƠN</button> <span class="btn btn-danger btn-send" id="close-day-off" data-target="#basicExampleModal"> HỦY DUYỆT </span>')

                } else {

                    $('#btn-submit-form').html('');

                    $('#app-comment').html(data.data.approve_comment);
                }
                var urlForm = "{{ route('edit_day_off_detail') }}" + '/' + data.data.id;

                $('#edit-day-off').attr('action', urlForm);

                $('#id-close').val(data.data.id)
                $('#modal-form').modal('show');
            }
        });
    }
        </script>
    </div>
@endsection
