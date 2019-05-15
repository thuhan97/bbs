@extends('layouts.end_user')
@section('page-title', __l('day_off'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('day_off') !!}
@endsection
@section('content')
    @php
        if (session()->has('data')) {
           $record = session()->get('data');
       }
       $dataDayOff= $dayOff ?? $availableDayLeft['data'];
        $searchStart = date((date('Y')-1).'/01/01', strtotime('tomorrow + 1day'));

    @endphp
    <form action="{{ route('day_off') }}" method="get" id="form-search">
        <div class="row mb-3 ml-1">
            <div class="col-sm-4 col-xl-2 pr-3 pl-0">
                <label class=" text-w-400" for="">Từ ngày</label>
                <input type="text"
                       class="form-control border-0 select-item"
                       id="search_start_at" autocomplete="off" name="search_start_at"
                       value="{{  $searchStratDate ?? $searchStart  }}"
                       readonly="readonly">
            </div>
            <div class="col-sm-4 col-xl-2 no-padding-left">
                <label class="text-w-400" for="inputZip">Tới ngày</label>
                <input type="text"
                       class="form-control select-item  border-0 "
                       id="search_end_at" autocomplete="off" name="search_end_at"
                       value="{{ $searchEndDate ?? ''}}"
                       readonly>
            </div>
            <div class="col-sm-2 col-xl-1 no-padding-left">
                <label class=" text-w-400" for="inputCity"> &nbsp;</label>
                <button class="form-control select-item  border-0 btn-secondary" id="result-search"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="d-none d-xl-flex container-fluid col-12 row border-bottom-2 mb-3" style="position: relative;">
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
            <span class="card bg-primary border-radius-2">
                <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media ml-2 d-md-flex">
                            <span id="dayoff-option-header-1"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                {{--<i class="fas fa-clipboard-list dayoff-icoin text-primary dayoff-cioin-1-2-3"></i>--}}
                                <i class="fas fa-calendar-alt dayoff-icoin text-primary day-off-icoi"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold">{{ $countDayOff['previous_year'] + $countDayOff['current_year'] }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Ngày khả dụng</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                TÍNH TỪ NĂM TRƯỚC</p>

                        </div>
                    </div>

                </div>
            </span>
            </div>
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative ">
            <span
                    class="card bg-success border-radius-2">
                <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-2 d-md-flex">
                            <span id="dayoff-option-header-2"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                {{--<i class="fas fa-clipboard-check dayoff-icoin text-success dayoff-cioin-1-2-3"></i>--}}
                                <i class="fas fa-calendar-times dayoff-icoin text-success day-off-icoi"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold">{{ $countDayOff['previous_year'] + DEFAULT_VALUE }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Ngày sắp hết hạn</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                CUỐI NĂM HỦY</p>

                        </div>
                    </div>

                </div>
            </span>
            </div>
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
            <span class="card border-radius-2"
                  id="bg-yellow">
                <div class="card-body  row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-2  d-md-flex">
                            <span id="dayoff-option-header-3"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                               {{--<i class="fas fa-clipboard dayoff-icoin text-warning dayoff-cioin-1-2-3"></i>--}}
                                <i class="fas fa-calendar-check dayoff-icoin text-warning day-off-icoi"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold ">{{ $countDayOff['total'] + DEFAULT_VALUE  }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Ngày đã nghỉ</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                TRONG NĂM {{date('Y')}}</p>
                        </div>
                    </div>

                </div>
            </span>
            </div>
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative pr-0 show-modal">
            <span class="card bg-danger border-radius-2" style="cursor: pointer">
                <div class="card-body  row d-flex justify-content-center px-0 ml-xxxl-1">
                    <div class="media d-md-flex">
                            <span id="dayoff-option-header-4"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                {{--<i class="fas fa-times-circle dayoff-icoin text-danger size-table"></i>--}}
                                <i class="fas fa-calendar-plus dayoff-icoin text-danger size-table"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold">Đơn</h1>
                            <p class="card-subtitle text-white-50 text-size-table">&nbsp;</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                XIN NGHỈ / NGHỈ PHÉP</p>
                        </div>
                    </div>

                </div>
            </span>
            </div>
        </div>
        <div class="">
            <div class="row">
                <div class="col-sm-4 col-md-4">

                </div>
                <div class="col-sm-8 text-right col-md-8">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-12 col-lg-6">
                            <div class="pr-1">
                                <?php
                                $user = \Illuminate\Support\Facades\Auth::user();
                                ?>
                                @if($user->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE)
                                    <a href="{{route('day_off_approval')}}" class="btn btn-primary" id="btn-detail-day-off" type="button">
                                        {{__l('day_off_approval')}}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="d-none d-sm-block col-sm-4">
                            {{ Form::select('status_search', SHOW_DAY_OFFF, $statusSearch ?? ALL_DAY_OFF, ['class' => 'browser-default custom-select w-100 month option-select select-search','placeholder'=>'']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
    <div class="">
        <table class="table table-bordered ">
            <thead class="grey lighten-2">
            <tr>
                <th class="d-none d-md-table-cell text-center">STT</th>
                <th class="text-center">Từ ngày</th>
                <th class="d-none d-md-table-cell text-center">Tới ngày</th>
                <th class="text-center">Tiêu đề</th>
                <th class="text-center">Nội dung</th>
                <th class="d-none d-md-table-cell text-center">Ngày được duyệt</th>
                <th class="text-center">Phê duyệt</th>
                <th class="d-none d-md-table-cell text-center">Xem thêm</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($dataDayOff as $keys => $absence)
                <tr class="dayoffEU_record">
                    <th class="d-none d-md-table-cell text-center" scope="row">
                        {!! ((($dataDayOff->currentPage()*PAGINATE_DAY_OFF)-PAGINATE_DAY_OFF)+1)+$keys !!}
                    </th>
                    <td class="text-center">{{ $absence->title != DAY_OFF_TITLE_DEFAULT ? \App\Helpers\DateTimeHelper::checkTileDayOffGetDate($absence->start_at) : $absence->start_date  }}</td>
                    <td class="d-none d-md-table-cell text-center">{{ $absence->title != DAY_OFF_TITLE_DEFAULT ? \App\Helpers\DateTimeHelper::checkTileDayOffGetDate($absence->end_at) : $absence->end_date  }}</td>
                    <td class="text-center">{{ array_key_exists($absence->title, VACATION_FULL) ? VACATION_FULL[$absence->title] : ''  }}</td>
                    <td class="text-center">{!! nl2br($absence->reason) !!}</td>
                    <td class="d-none d-md-table-cell text-center">{{!!!($absence->number_off || $absence->absent > DEFAULT_VALUE)? ($absence->status != STATUS_DAY_OFF['noActive'] ? 'Đang duyệt' : '') : checkNumber($absence->number_off) + checkNumber($absence->absent).' ngày'}}

                    </td>
                    <td class="text-center">
                        @if($absence->status == STATUS_DAY_OFF['abide'])
                            <i class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                        @elseif($absence->status == STATUS_DAY_OFF['active'])
                            <i class="fas fa-grin-stars fa-2x text-success"></i>
                        @else
                            <i class="fas fa-frown fa-2x text-danger"></i>
                        @endif
                    </td>
                    <td class=" d-none d-md-table-cell text-center">
                        <p class=" btn-sm m-0 detail-dayoff" style="cursor: pointer" attr="{{ $absence->id }}">Chi
                            tiết >></p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $dataDayOff->render('end_user.paginate') }}
    </div>

    <!-- Modal: View detail absence form -->
    <div class="modal fade right" id="detailAbsence" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-full-height modal-right modal-notify modal-info"
             role="document">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead d-flex flex-row" id="dayoff_heading">
                        Loading...
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
                            <strong id="dayoff_title"></strong>
                        </p>
                        <br>
                        <h4 class="text-bold">Ngày nghỉ:</h4>
                        <p>
                            <strong id="dayoff_duration"></strong>
                        </p>
                        <br>
                        <h4 class="text-bold">Thời gian được tính:</h4>
                        <p>
                            <strong id="dayoff_total"></strong>
                        </p>
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
                        <p id="dayoff_comment"></p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-primary waves-effect waves-light">Báo cáo
                        <i class="fa fa-paper-plane ml-1"></i>
                    </a>
                    <a type="button" class="btn btn-outline-primary waves-effect"
                       data-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal: View detail absence form -->
    <div class="modal fade modal-open" id="modal-form" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class="modal-title w-100 font-weight-bold pt-2 ml-5">XIN NGHỈ PHÉP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h6 class="modal-title w-100 font-weight-bold text-danger" id="usable-check"></h6>
                </div>
                <div class="modal-body mt-0 pb-0 d-flex justify-content-start ml-3">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input option-dayoff" id="defaultUnchecked"
                               name="defaultExampleRadios" checked value="0">
                        <label class="custom-control-label" for="defaultUnchecked"><h5>Xin nghỉ phép</h5></label>
                    </div>

                    <!-- Default checked -->
                    <div class="custom-control custom-radio ml-5">
                        <input type="radio" class="custom-control-input option-dayoff" id="defaultChecked"
                               name="defaultExampleRadios" value="1" @if(old('title')) checked @endif>
                        <label class="custom-control-label " for="defaultChecked"><h5>Xin nghỉ chế độ</h5></label>
                    </div>
                </div>
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('day_off_create') }}" method="post" id="form_create_day_off">
                            @csrf
                            <div class="modal-body mx-3 mt-0 pb-0">
                                <div class="mb-3">
                                    <label class="text-w-400" for="exampleFormControlTextarea5">Nội dung <span
                                                class="text-danger">*</span></label>
                                    <textarea
                                            class="form-control reason_id rounded-0 select-item check-value {{ $errors->has('reason') ? ' has-error' : '' }}"
                                            id="exampleFormControlTextarea2" rows="3" placeholder="Lý do xin nghỉ..."
                                            name="reason">{{  old('reason') }}</textarea>
                                    @if ($errors->has('reason'))
                                        <div class="mt-1">
                                            <span class="help-block text-danger">{{ $errors->first('reason') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="form-group col-sm-6 m-0">
                                            <div class="row">
                                                <div class="col-sm-7 py-0 pr-0">
                                                    <label class=" text-w-400" for="inputCity">Ngày bắt đầu<span
                                                                class="text-danger">*</span></label>
                                                    <?php
                                                    $autoDateStart = date('Y/m/d', strtotime('tomorrow'));
                                                    ?>
                                                    <input type="text"
                                                           class="form-control border-0 select-item {{ $errors->has('start_at') ? ' has-error' : '' }}"
                                                           id="start_date" autocomplete="off" name="start_at"
                                                           value="{{ old('start_at', $autoDateStart) }}"
                                                           readonly="readonly">
                                                </div>
                                                <div class="col-sm-4 p-0 mt-2">
                                                    {{ Form::select('start', CHECK_TIME_DAY_OFF, null, ['class' => 'form-control option-time-day-off browser-default custom-select select-item mannager_id check-value time-start' ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 m-0">
                                            <div class="row">
                                                <div class="col-sm-7 py-0 pr-0">
                                                    <?php
                                                    $autoDateEnd = date('Y/m/d', strtotime('tomorrow + 1day'));
                                                    ?>
                                                    <label class="text-w-400" for="inputZip">Ngày kết thúc<span
                                                                class="text-danger">*</span></label>
                                                    <input type="text"
                                                           class="form-control select-item  border-0 {{ $errors->has('end_at') ? ' has-error' : '' }}"
                                                           id="end_date" autocomplete="off" name="end_at"
                                                           value="{{  old('end_at',$autoDateEnd) }}"
                                                           readonly>
                                                </div>
                                                <div class="col-sm-4 p-0 mt-2">
                                                    {{ Form::select('end', CHECK_TIME_DAY_OFF, null, ['class' => 'form-control border-0 option-time-day-off browser-default custom-select select-item mannager_id check-value time-end' ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Default input -->
                                        <span id="errors_date" class="text-danger ml-3 "></span>
                                    </div>
                                    @if ($errors->has('start_at'))
                                        <div>
                                            <span class="help-block text-danger">{{ $errors->first('start_at') }}</span>
                                        </div>
                                    @endif
                                    @if ($errors->has('end_at'))
                                        <div class="mt-1">
                                            <span class="help-block text-danger">{{ $errors->first('end_at') }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- <div class="mb-3">
                                     <!-- Default input -->
                                     <label class="text-w-400" for="exampleForm2">Thời gian nghỉ*</label>
                                     {{ Form::select('option_check', CHECK_TIME_DAY_OFF_NAME,null,['class' => 'form-control my-1 mr-1  browser-default custom-select md-form select-item reason_id check-value','placeholder'=>'Chọn thời gian nghỉ']) }}
                                     @if ($errors->has('option_check'))
                                         <div class="">
                                             <span class="help-block text-danger">{{ $errors->first('option_check') }}</span>
                                         </div>
                                     @endif
                                 </div>--}}


                                <div class="">
                                    <label class="text-w-400" for="exampleForm2">Người duyệt<span
                                                class="text-danger">*</span></label>
                                    {{ Form::select('approver_id', $userManager, null, ['class' => 'form-control my-1 mr-1 browser-default custom-select md-form select-item mannager_id check-value','placeholder'=>'Chọn người duyệt đơn' ]) }}
                                    @if ($errors->has('approver_id'))
                                        <div class="mt-1 ml-3">
                                            <span class="help-block text-danger">{{ $errors->first('approver_id') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0"
                                 id="create_day_off">
                                <button class="btn btn-primary" id="btn-send">GỬI ĐƠN</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{ route('day_off_create_vacation') }}" method="post"
                              id="form_create_day_off_vacation">
                            @csrf
                            <div class="modal-body mx-3 mt-0 pb-0">
                                <div class="mb-3">
                                    <!-- Default input -->
                                    <label class="text-w-400" for="exampleForm2">Chế độ nghỉ<span
                                                class="text-danger">*</span></label>
                                    {{ Form::select('title', VACATION,null,['class' => 'form-control my-1 mr-1  browser-default custom-select md-form select-item reason_id check-value']) }}
                                    @if ($errors->has('title'))
                                        <div class="">
                                            <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" name="day_off_id" value="">
                                <div class="mb-3">
                                    <label class="text-w-400" for="exampleFormControlTextarea5">Nội dung<span
                                                class="text-danger">*</span></label>
                                    <textarea
                                            class="form-control reason_id rounded-0 select-item check-value {{ $errors->has('reason') ? ' has-error' : '' }}"
                                            id="exampleFormControlTextarea2" rows="3" placeholder="Lý do xin nghỉ..."
                                            name="reason">{{  old('reason') }}</textarea>
                                    @if ($errors->has('reason'))
                                        <div class="mt-1">
                                            <span class="help-block text-danger">{{ $errors->first('reason') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="form-group col-sm-6 m-0">
                                            <label class=" text-w-400" for="inputCity">Ngày bắt đầu<span
                                                        class="text-danger">*</span></label>
                                            <?php

                                            $autoDate = date('Y/m/d', strtotime('tomorrow'));

                                            ?>
                                            <input type="text"
                                                   class="form-control select-item  {{ $errors->has('start_at') ? ' has-error' : '' }}"
                                                   id="start_date1" autocomplete="off" name="start_at"
                                                   value="{{ old('start_at', $autoDate) }}" readonly="readonly">
                                        </div>
                                        <!-- Default input -->
                                        <div class="form-group col-sm-6 m-0">
                                            <label class="text-w-400" for="inputZip">Ngày kết thúc<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control select-item {{ $errors->has('end_at') ? ' has-error' : '' }}"
                                                   id="end_date1" autocomplete="off" name="end_at"
                                                   value="{{  old('end_at') }}"
                                                   readonly="readonly">
                                        </div>
                                        <span id="errors_date1" class="text-danger ml-3 "></span>
                                    </div>
                                    @if ($errors->has('start_at'))
                                        <div>
                                            <span class="help-block text-danger">{{ $errors->first('start_at') }}</span>
                                        </div>
                                    @endif
                                    @if ($errors->has('end_at'))
                                        <div class="mt-1">
                                            <span class="help-block text-danger">{{ $errors->first('end_at') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="">
                                    <label class=" mt-1 text-w-400" for="exampleForm2">Người duyệt<span
                                                class="text-danger">*</span></label>
                                    {{ Form::select('approver_id', $userManager, null, ['class' => 'form-control my-1 mr-1 browser-default custom-select md-form select-item mannager_id check-value','placeholder'=>'Chọn người duyệt đơn' ]) }}
                                    @if ($errors->has('approver_id'))
                                        <div class="mt-1 ml-3">
                                            <span class="help-block text-danger">{{ $errors->first('approver_id') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="pt-3 pb-4 d-flex justify-content-center border-top-0 rounded mb-0"
                                 id="create_day_off">
                                <button class="btn btn-primary" id="btn-send-day-off">GỬI ĐƠN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-open" id="modal-form-detail" tabindex="-1" role="dialog"
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
                        <!-- Default input -->
                        <label class="ml-3 text-d-bold" for="exampleForm2">Lý do:</label>
                        <div class="ml-3" id="title"></div>
                    </div>

                    <div class="mb-3">
                        <label class="ml-3 text-d-bold" for="exampleFormControlTextarea5">Chi tiết lý
                            do:</label>
                        <div class="ml-3" id="reason"></div>
                    </div>
                    <div class="mb-3">
                        <!-- Default input -->
                        <label class="ml-3 text-d-bold" for="exampleForm2">Ngày nghỉ:</label>
                        <div class="ml-3" id="strat_end"></div>
                    </div>
                    <div class="mb-3 ml-3" id="remove-numoff">
                        <!-- Default input -->
                        <label class="text-d-bold" for="exampleForm2">Thời gian được tính:</label>
                        <strong id="number_off"></strong> ngày
                    </div>
                    <div class="mb-4 pb-2">
                        <div class="row">
                            <div class="form-group col-6 m-0">
                                <label class="ml-3 text-d-bold" for="inputCity">Người duyệt</label>
                                <div id="approver_id" class="ml-3"></div>
                            </div>
                            <!-- Default input -->
                            <div class="form-group col-6 m-0" id="remove-app-date">
                                <label class="ml-3 text-d-bold" for="inputZip">Ngày duyệt</label>
                                <div id="approver_date" class="ml-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5" id="remove-app-comment">
                        <label class="text-d-bold ml-3" for="exampleFormControlTextarea5">Ý kiến người
                            duyệt</label>
                        <div class="ml-3" id="app-comment"></div>
                    </div>

                    <div class=" mb-1 pb-4 d-flex justify-content-center border-top-0 rounded mb-0" id="btn-show-modal">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <form action="{{ route('delete_day_off') }}" method="post">
        @csrf
        <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <input type="hidden" value="" name="day_off_id" id="id-delete">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="ml-4 modal-title text-center" id="exampleModalLabel">Bạn có chắc chắn muốn xóa đơn
                            này không ? </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary w-25">ĐỒNG Ý</button>
                        <span class="btn btn-primary w-25" data-dismiss="modal">HỦY</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- Modal: Create absence form--}}
    @if (count($errors) > 0)
        {{--@dd($errors)--}}
        <script>
            $(function () {
                $('#modal-form').modal('show');
            });
        </script>
        @if(old('title'))
            <script>
                $(function () {
                    $('#home').removeClass('active show');
                    $('#profile').addClass('active show');
                    $('#defaultChecked').attr('checked');
                });
            </script>

        @endif
    @endif

    @if(session()->has('day_off_success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã gửi đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif

    @if(session()->has('delete_day_off'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã xóa đơn thành công!",
                icon: "success",
                button: "Đóng",
            });
        </script>
    @endif

    <script type="text/javascript">

        $(document).ready(function () {

            checkUsable();

            $('.option-select').on('change', function () {
                $("#form-search").submit();
            });
            $('#result-search').on('click', function () {
                $("#form-search").submit();
            });
            $('form').each(function () {
                $(this).validate({
                    ignore: '[readonly]',
                    rules: {
                        title: {
                            required: true,
                            range: [1, 4],
                            digits: true
                        },
                        start_at: {
                            required: true,
                            date: true
                        },
                        end_at: {
                            required: true,
                            date: true
                        },
                        approver_id: {
                            required: true,
                            digits: true
                        },
                        reason: {
                            required: true,
                            maxlength: 100
                        }
                        ,
                        number_off: {
                            required: true,
                            number: true
                        },
                        option_check: {
                            required: true,
                            range: [0, 2],
                            digits: true
                        }

                    },
                    messages: {
                        title: {
                            required: "Vui lòng chọn lý do xin nghỉ",
                            digits: "Vui lòng nhập đúng định dạng số",
                            range: "Vui lòng xem lại lý do xin nghỉ"
                        },
                        start_at: {
                            required: "Vui lòng vui lòng chọn lý do ngày nghỉ",
                            date: "Vui lòng nhập đúng địn dạng ngày tháng"
                        },
                        end_at: {
                            required: "Vui lòng vui lòng chọn ngày kết thúc",
                            date: "Vui lòng nhập đúng địn dạng ngày tháng"
                        },
                        approver_id: {
                            required: "Vui lòng chọn người phê duyệt",
                            digits: "Vui lòng nhập đúng định dạng số"
                        },
                        reason: {
                            required: "Vui lòng nhập nội dung đơn",
                            maxlength: "Bạn đã nhập quá 100 kí tự"
                        },
                        number_off: {
                            required: "Vui lòng nhập số ngày dự kiến",
                            number: "Vui lòng nhập đúng định dạng số"
                        },
                        option_check: {
                            required: "Vui lòng chọn thời gian nghỉ",
                            digits: "Vui lòng nhập đúng định dạng số",
                            range: "Vui lòng kiểm tra lại thời gian"
                        },
                    }
                });
            });


            $('.show-modal').on('click', function () {
                $('#modal-form').modal('show');
            });

            var today = new Date();
            var mon = today.getMonth() + 1;
            var date = today.getFullYear() + '-' + mon + 1 + '-' + today.getDate();


            @if($autoShowModal)
            $('#modal-form').modal('show');
            @endif

            $('#search_start_at , #search_end_at').datepicker({format: 'yyyy/mm/dd',orientation: 'bottom'});
            $('#start_date , #start_date1').datepicker({
                format: 'yyyy/mm/dd',
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
            });

            $('#end_date,#end_date1').datepicker({
                format: 'yyyy/mm/dd',
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
            });

            $('#end_date,#start_date,.time-start,.time-end').on('change', function () {
                checkUsable();
            })
            $('#end_date1,#start_date1').on('change', function () {
                checkDate('#start_date1', '#end_date1', '#errors_date1', false, '#btn-send-day-off');
            })

            $('.check-value').on('change', function () {
                var val = $(this).val();
                if (val != '') {
                    $(this).css('opacity', 1);
                }
            })
            $('.btn-close-icon').on('click', function () {
                $('.check-value').css('opacity', 0.7);
            })

            $('.detail-dayoff').on('click', function () {
                var id = $(this).attr('attr');
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
                        $('#approver_id').html(data.approver);
                        $('#number_off').html(data.data.number_off);
                        $('#strat_end').html(data.data.start_date + ' - ' + data.data.end_date);
                        $('#reason').html(data.data.reason.replace(/\n/g, "<br />"));
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
                        if (data.data.approve_comment) {
                            $('#remove-app-comment').show();
                            $('#app-comment').html(data.data.approve_comment);
                        } else {
                            $('#remove-app-comment').hide();
                        }
                        if (data.numoff) {
                            $('#number_off').html(data.numoff);
                            $('#remove-numoff').show();
                        } else {
                            $('#remove-numoff').hide();
                        }
                        if (data.data.status == 0) {
                            $('#btn-show-modal').html('<span class="btn btn-danger" data-toggle="modal" data-target="#basicExampleModal">HỦY ĐƠN</span>');
                        }
                        $('#modal-form-detail').modal('show');
                    }
                });
            })

            $('.detail-dayoff').on('click', function () {
                $(this).addClass('text-primary');
            })

            $('.option-dayoff').on('click', function () {
                var check = $(this).val();
                if (check == 1) {
                    $('#usable-check').text(' ')
                    $('#home').removeClass('active show');
                    $('#home').removeClass('active show');
                    $('#profile').addClass('active show');
                } else {
                    $('#home').addClass('active show');
                    $('#profile').removeClass('active show');
                }
            })
        });
        function checkUsable() {
            checkDate('#start_date', '#end_date', '#errors_date', true, '#btn-send');
            var dateStart=$('#start_date').val();
            var dateEnd =$('#end_date').val();
            var timeStart= $('.time-start').val();
            var timeEnd = $('.time-end').val();
            $.ajax
            ({
                'url': '{{ route('check-usable-day-offf') }}',
                'type': 'get',
                'data': {'start_date':dateStart  , 'end_date': dateEnd,'start_time':timeStart  , 'end_time': timeEnd, },
                success: function (data) {
                    // console.log(data);
                    if(data.check){
                        $('#usable-check').text('Bạn sẽ bị tính ' + data.absent + ' ngày nghỉ không phép vì ngày phép còn lại không đủ.' )
                    }else {
                        $('#usable-check').text(' ')
                    };
                }
            });
        }

        function checkDate(start, end, errors, check, btn) {
            var start1 = $(start).val();
            var end1 = $(end).val();
            if (start1 == "" || end1 == "") {
                $(errors).text('vui lòng chọn ngày bắt đầu và ngày kết thúc');
                return;
            }
            if (start1 > end1) {
                $(btn).attr('disabled', 'disabled');
                $(errors).text('Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.');
            } else if (start1 == end1 && check == true) {
                var timeStrat = new Date("November 13, 2013 " + $('.time-start').val()).getTime();
                var timeEnd = new Date("November 13, 2013 " + $('.time-end').val()).getTime();
                if (timeStrat >= timeEnd) {
                    $(btn).attr('disabled', 'disabled');
                    $(errors).text('Giờ kết thúc phải lớn hơn giờ bắt đầu.');
                } else {
                    $(btn).removeAttr('disabled');
                    $(errors).text('');
                }

            } else {
                $(btn).removeAttr('disabled');
                $(errors).text('');
            }
        }
    </script>
@endsection

@push('extend-css')
    <link href="{{ cdn_asset('/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <style>
        #textareaForm {
            height: 150px;
        }

        label {
            user-select: none;
        }
    </style>
@endpush

@push('extend-js')
    <script src="{{ cdn_asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ cdn_asset('/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ cdn_asset('js/jquery.validate.min.js') }}"></script>
@endpush
