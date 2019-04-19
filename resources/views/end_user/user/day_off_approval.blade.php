@extends('layouts.end_user')
@section('breadcrumbs')
@endsection
@section('content')
    <?php
    if (isset($dayOffSearch)) {
        $getDayOff = $dayOffSearch['data'];
    }elseif (isset($status)){
        $getDayOff = $dataDayOff['dataDate'];
    }
    else {
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
    ?>
    @if(session()->has('success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã sửa đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif
    @if(session()->has('active'))
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
        <div class="row mb-5 ml-3">
            <div class="col-3 position-relative">
                <div class="row border-radius-1" id="option-calendar" style="height: 50px">
                    <div class="col-3 p-0 m-auto">
                        {{ Form::select('year', get_years(), $year ?? date('Y') , ['class'=>'yearselect browser-default custom-select w-100 border-0 select_year option-select p-1']) }}
                    </div>
                    <div class="col-9 p-0 m-auto pr-2 ">
                        {{ Form::select('month', MONTH, $month ?? null, ['class' => 'browser-default custom-select w-100 month option-select','placeholder'=>'Chọn tháng']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid col-12 row border-bottom-2 mb-2" style="position: relative;">
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
                <a href="{{ route('day_off_show',['status'=>ALL_DAY_OFF]) }}" class="card bg-primary border-radius-2">
                    <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
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
                    <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
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
                    <div class="card-body  row d-flex justify-content-center px-0 ml-xxl-2">
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
                    {{ Form::select('status', SHOW_DAY_OFFF, $status ?? ALL_DAY_OFF, ['class' => 'browser-default custom-select w-100 search-day-off border-radius-1 option-select']) }}
                </div>
                <div class="col-7 pl-0">
                    <div class="input-group col-12">
                        <input type="text" class="form-control search-day-off border-radius-1"
                               placeholder="Tìm tên nhân viên"
                               name="search" id="content-search" value="{{ $search ?? '' }}">
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
    </form>
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
            @foreach($getDayOff as $keys => $record)
                <tr id="rowApprove{{$loop->index+1}}">
                    <th scope="row" class="text-center">
                        {!! ((($getDayOff->currentPage()*PAGINATE_DAY_OFF)-PAGINATE_DAY_OFF)+1)+$keys !!}
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
                    <td class="text-center">{{!!!$record->number_off ? 'Chưa rõ' : checkNumber($record->number_off)  }} ngày</td>

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
                        <a class="show-day-off @if($keys ==0)text-primary @endif"
                           href="{{ route('day_off_detail',['id'=>$record->id]) }}">chi tiết >></a>
                    </td>
                </tr>
            @endforeach
            </tbody>

            <!--Table body-->
        </table>
    {{$getDayOff->render('end_user.paginate') }}
    <!--Table-->
        @if(!empty($data))
            <form action="{{ route('edit_day_off_detail',['id'=>$data->id]) }}" method="post" id="edit-day-off">
                @csrf
                <input type="hidden" name="status" value="1">
                <div class="modal fade modal-open" id="modal-form" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel"
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
                                <div class="mb-3">
                                    <label class="ml-3 text-w-400" for="exampleFormControlTextarea5">Tên nhân
                                        viên</label>
                                    <div class="ml-3">{{ $data->user->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <!-- Default input -->
                                    <label class="ml-3 text-d-bold" for="exampleForm2">Lý do:</label>
                                    <div class="ml-3">{{ array_key_exists($data->title,VACATION) ?  VACATION[$data->title] : '' }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="ml-3 text-d-bold" for="exampleFormControlTextarea5">Chi tiết lý
                                        do:</label>
                                    <div class="ml-3">{{ $data->reason}}</div>
                                </div>
                                <div class="mb-3">
                                    <!-- Default input -->
                                    <label class="ml-3 text-d-bold" for="exampleForm2">Ngày nghỉ:</label>
                                    <div class="ml-3">{{ $data->start_date .' - '. $data->end_date}}</div>
                                </div>

                                <div class="mb-3 ml-3 ">
                                    <!-- Default input -->
                                    <label class="text-d-bold" for="exampleForm2">Thời gian được tính:</label>
                                    @if($data->status ==0)
                                        <input type="text"
                                               class="form-control select-item {{ $errors->has('number_off') ? ' has-error' : '' }}"
                                               autocomplete="off" name="number_off"
                                               value="{{ old('number_off',$data->number_off) }}" id="number_off">
                                        @if ($errors->has('title'))
                                            <div class="">
                                                <span class="help-block text-danger">{{ $errors->first('start_at') }}</span>
                                            </div>
                                        @endif

                                    @else
                                        <div class="ml-3">{{!!!$data->number_off ? 'Chưa rõ' : checkNumber($data->number_off)}} ngày</div>
                                    @endif
                                </div>
                                <div class="mb-4 pb-2">
                                    <div class="row">
                                        <div class="form-group col-6 m-0">
                                            <label class="ml-3 text-d-bold" for="inputCity">Người duyệt</label>
                                            <div class="ml-3">{{ auth()->user()->name }}</div>
                                        </div>
                                        <!-- Default input -->
                                        <div class="form-group col-6 m-0">
                                            <label class="ml-3 text-d-bold" for="inputZip">Ngày duyệt</label>
                                            <div class="ml-3">{{ $data->approver_date }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if(isset($data) && $data->status==0)
                                    <div class="mb-3 ml-3">
                                        <label class="text-d-bold" for="exampleFormControlTextarea5">Ý kiến người duyệt</label>
                                        <textarea
                                                class="form-control reason_id rounded-0 select-item {{ $errors->has('approve_comment') ? ' has-error' : '' }}"
                                                id="exampleFormControlTextarea2" rows="3" placeholder="Nhập ý kiến của người duyệt"
                                                name="approve_comment">{{ $data->approve_comment ?? old('approve_comment') }}</textarea>
                                        @if ($errors->has('approve_comment'))
                                            <div class="mt-1">
                                                <span class="help-block text-danger">{{ $errors->first('approve_comment') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if($data->status ==0)
                                    <div class=" mb-1 pb-4 d-flex justify-content-center border-top-0 rounded mb-0">
                                        <button type="submit" class="btn  btn-primary">DUYỆT ĐƠN</button>
                                        <a href="{{ route('day_off_detail',['id'=>$data->id,'check'=>true]) }}"
                                           class="btn btn-danger btn-send">
                                            HỦY DUYỆT</a>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        @if(!empty($data))
            <script>
                $(function () {
                    $('#modal-form').modal('show');
                });
            </script>
        @endif
        @push('extend-css')
            <link href="{{ cdn_asset('/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
            <link href="{{ cdn_asset('/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
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
        <script src="{{ cdn_asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ cdn_asset('/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ cdn_asset('js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('.option-select').on('change',function () {
                    $( "#form-search" ).submit();
                });

                $("#edit-day-off").validate({
                    rules: {
                        number_off: {
                            required: true,
                            number: true
                        }
                    },
                    messages: {
                        number_off: {
                            required: "Vui lòng nhập số ngày nghỉ được phê duyệt",
                            number: "Vui lòng nhập đúng định dạng số"
                        }
                    }
                });


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

            });

            /*        $('.select_year , .month , .search-day-off').on('change', function () {
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
                                var pagiante=pagination(data);
                                $('#ajax-show').html(html);
                                $('#pagiante-ajax').html(pagiante);

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




                    $(document).on('click','.papginate-page', function () {
                       var page=$(this).attr('attr');
                       alert(page);

                        $.ajax
                        ({
                            'url': '/phe-duyet-ngay-nghi/search?page='+page,
                            'type': 'get',
                            success: function (data) {
                                console.log(data)
                               /!* $('.pagination').hide();
                                var html = teamplate(data);
                                var pagiante=pagination(data);
                                $('#ajax-show').html(html);
                                $('#pagiante-ajax').html(pagiante);*!/
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
                        html += ' <a  class="';
                        if (key == 0) {
                            html += 'text-primary';
                        }
                        html += ' show-day-off "attr="' + value['id'] + '"';
                        html += 'href="'

                    html += '">chi tiết>></a>';
                    html += '</td> </tr>';
                });
                return html;
            }

            function pagination(data) {
            var pagi='';

                pagi+='<ul class="pagination" role="navigation">';

                pagi+='<li class="page-item" id="first-page" aria-disabled="true" aria-label="« Trang sau">';
                pagi+='<span class="page-link waves-effect waves-effect" aria-hidden="true">‹</span> </li>'
for (var i=1;i < data.data.total +1;i++){
    pagi+='<li attr="'+ i +'" class="page-item papginate-page';
    if (data.data.current_page == i)
        pagi+=' active';
    pagi+='"><span class="page-link waves-effect waves-effect ">'+ i + '</span></li>';
}
                pagi+='<li class="page-item" id="last-page">';
                pagi+='›</li> </ul>';
return pagi;

            }*/
        </script>
    </div>
@endsection
