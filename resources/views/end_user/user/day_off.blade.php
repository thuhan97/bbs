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
        <div class="row mb-0 ml-1 mb-sm-4 mt-sm-3">
            <div class="row col-6 col-sm-4 col-xl-4 pr-3 pl-3 pt-2">
                    <label class="text-w-400 pt-2" for="">Từ ngày</label>
                    <div class="position-relative">
                        <input type="text"
                               class="form-control border-0 select-item z- ml-2"
                               id="search_start_at" autocomplete="off" name="search_start_at"
                               value="{{  $searchStratDate ?? $searchStart  }}"
                               readonly="readonly">
                        <i class="far fa-calendar-alt position-absolute calendar-search"></i>
                    </div>



            </div>
            <div class="row col-6 col-sm-4 col-xl-4 pr-3 pl-3 pt-2 div-day-off-from-day">
                <label class="text-w-400 pt-2 label-from-days" for="inputZip">Tới ngày</label>
                <div class="position-relative">
                    <input type="text"
                           class="form-control select-item  border-0 ml-2"
                           id="search_end_at" autocomplete="off" name="search_end_at"
                           value="{{ $searchEndDate ?? ''}}"
                           readonly>
                    <i class="far fa-calendar-alt position-absolute calendar-search"></i>
                </div>
            </div>
            <div class="col-sm-2 col-xl-1 no-padding-left mt-3 mt-sm-0 group-btn-search-day-off">
                <label class=" text-w-400 d-none d-sm-block" for="inputCity"> &nbsp;</label>
                <button class="form-control select-item  border-0 btn-secondary btn-secondary-search-day-off" id="result-search"><i
                            class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="d-none d-xl-flex container-fluid col-12 row border-bottom-2 mb-3" style="position: relative;">
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
            <span class="card bg-primary border-radius-2 day-off-card">
                <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media ml-2 d-md-flex">
                            <span id="dayoff-option-header-1"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                {{--<i class="fas fa-clipboard-list dayoff-icoin text-primary dayoff-cioin-1-2-3"></i>--}}
                                <i class="fas fa-calendar-alt dayoff-icoin text-primary day-off-icoi"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold content-card-day-off">{{ $countDayOff['previous_year'] + $countDayOff['current_year'] }}</h1>
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
                    class="card bg-success border-radius-2 day-off-card">
                <div class="card-body row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-2 d-md-flex">
                            <span id="dayoff-option-header-2"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                {{--<i class="fas fa-clipboard-check dayoff-icoin text-success dayoff-cioin-1-2-3"></i>--}}
                                <i class="fas fa-calendar-times dayoff-icoin text-success day-off-icoi"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold content-card-day-off">{{ $countDayOff['previous_year'] + DEFAULT_VALUE }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Ngày sắp hết hạn</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                CUỐI NĂM HỦY</p>

                        </div>
                    </div>

                </div>
            </span>
            </div>
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative">
            <span class="card border-radius-2 day-off-card"
                  id="bg-yellow">
                <div class="card-body  row d-flex justify-content-center px-0 ml-xxl-2">
                    <div class="media mr-2  d-md-flex">
                            <span id="dayoff-option-header-3"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                               {{--<i class="fas fa-clipboard dayoff-icoin text-warning dayoff-cioin-1-2-3"></i>--}}
                                <i class="fas fa-calendar-check dayoff-icoin text-warning day-off-icoi"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold content-card-day-off">{{ $countDayOff['total'] + DEFAULT_VALUE  }}</h1>
                            <p class="card-subtitle text-white-50 text-size-table">Ngày đã nghỉ</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                TRONG NĂM {{date('Y')}}</p>
                        </div>
                    </div>

                </div>
            </span>
            </div>
            <div class="col-sm-3 col-md-6 col-lg-3 position-relative pr-0 show-modal">
            <span class="card bg-danger border-radius-2 day-off-card">
                <div class="card-body  row d-flex justify-content-center px-0 ml-xxxl-1">
                    <div class="media d-md-flex">
                            <span id="dayoff-option-header-4"
                                  class="d-flex rounded-circle avatar z-depth-1-half mb-3 mx-auto dayoff-header mt-1">
                                {{--<i class="fas fa-times-circle dayoff-icoin text-danger size-table"></i>--}}
                                <i class="fas fa-calendar-plus dayoff-icoin text-danger size-table"></i>
                            </span>
                        <div class="media-body text-center text-md-left ml-xl-4">
                            <h1 class="white-text font-weight-bold content-card-day-off">Đơn</h1>
                            <p class="card-subtitle text-white-50 text-size-table">&nbsp;</p>
                            <p class="card-title text-uppercase font-weight-bold card-text white-text text-size-header-1">
                                XIN NGHỈ / NGHỈ PHÉP</p>
                        </div>
                    </div>

                </div>
            </span>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-4 col-md-4">
            </div>
            <div class="col-sm-8 text-right col-md-8">
                <div class="row mb-2">
                    <div class="col-lg-2"></div>
                    <div class="col-12 col-sm-8 col-lg-6 pr-0">
                        <div class="{{--pr-lg-1 pr-sm-4--}} pr-4 pr-sm-0">
                            <?php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            ?>
                            @if($user->jobtitle_id >= \App\Models\Report::MIN_APPROVE_JOBTITLE)
                                <a href="{{route('day_off_approval')}}" class="btn btn-primary"
                                   id="btn-detail-day-off" type="button">
                                    {{__l('day_off_approval')}}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="d-none d-sm-block col-sm-4">
                        {{ Form::select('status_search', SHOW_DAY_OFFF, $statusSearch ?? ALL_DAY_OFF, ['class' => 'browser-default custom-select mt-1 w-100 month option-select select-search','placeholder'=>'']) }}
                    </div>
                </div>
            </div>
        </div>

    </form>
    <div class="">
        <table class="table table-bordered ">
            <thead class="grey lighten-2">
            <tr>
                <th class="d-none d-md-table-cell text-center">STT</th>
                <th class="text-center">Từ ngày</th>
                <th class="d-none d-md-table-cell text-center">Tới ngày</th>
                <th class="text-center">Tiêu đề</th>
                <th class="text-center d-none d-xl-table-cell">Nội dung</th>
                <th class=" text-center">Ngày có phép</th>
                <th class="d-none d-md-table-cell text-center">Ngày không phép</th>
                <th class="text-center">Phê duyệt</th>
                <th class=" text-center">Xem thêm</th>
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
                    <td class="text-center d-none d-xl-table-cell">{!! nl2br($absence->reason) !!}</td>
                    <td class="d-none d-md-table-cell text-center">
                        {{!!!$absence->number_off ? ($absence->status != STATUS_DAY_OFF['noActive'] ? 'Đang duyệt' : '') : checkNumber($absence->number_off) .' ngày'}}
                    </td>
                    <td class="text-center">
                        {{!!! $absence->absent == DEFAULT_VALUE  ? ($absence->status == STATUS_DAY_OFF['abide'] ? 'Đang duyệt' : (  $absence->status == STATUS_DAY_OFF['noActive'] ? '' : checkNumber($absence->absent) .' ngày')) :  checkNumber($absence->absent) .' ngày'}}
                    </td>
                    <td class="text-center">
                        @if($absence->status == STATUS_DAY_OFF['abide'])
                            <i data-toggle="tooltip" data-placement="right" title="Chờ phê duyệt" class="fas fa-meh-blank fa-2x text-warning text-center"></i>
                        @elseif($absence->status == STATUS_DAY_OFF['active'])
                            <i data-toggle="tooltip" data-placement="right" title="Đã duyệt đơn"  class="fas fa-grin-stars fa-2x text-success"></i>
                        @else
                            <i data-toggle="tooltip" data-placement="right" title="Không duyệt"  class="fas fa-frown fa-2x text-danger"></i>
                        @endif
                    </td>
                    <td class=" text-center">
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
    <div class="modal fade right custom-modal" id="detailAbsence" tabindex="-1"
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
    <div class="modal fade modal-open custom-modal" id="modal-form" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content modal-center-display" id="bg-img" style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 pb-2 p-sm-4">
                    <h4 class="modal-title w-100 font-weight-bold">XIN NGHỈ PHÉP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header text-center border-bottom-0 p-0 modal-center-display">
                    <h6 class="modal-title w-100 font-weight-bold text-danger" id="usable-check"></h6>
                </div>
                <div class="modal-body mt-0 pb-0 pt-2 d-flex justify-content-start ml-3" id="toggle-show">
                    <div class="row w-100">
                        <div class="col-6 col-sm-12 col-md-6 pl-0 pr-0">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input option-dayoff" id="defaultUnchecked"
                                       name="defaultExampleRadios" checked value="0">
                                <label class="custom-control-label" for="defaultUnchecked"><h5 class="mb-h5">Xin nghỉ phép</h5></label>
                            </div>
                        </div>
                        <div class="col-6 col-sm-12 col-md-6 pl-0 pr-0">
                            <!-- Default checked -->
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input option-dayoff" id="defaultChecked1"
                                       name="defaultExampleRadios" value="1" @if(old('title')) checked @endif>
                                <label class="custom-control-label " for="defaultChecked1"><h5 class="mb-h5">Xin nghỉ chế độ</h5></label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-content p-0" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('day_off_create') }}" method="post" id="form_create_day_off">
                            @csrf
                            <input type="hidden" name="id_hid" class="id_hide">
                            <div class="modal-body mx-3 mt-0 pt-2 pb-1 pb-sm-3">
                                <div class="mb-3">
                                    <label class="text-w-400" for="exampleFormControlTextarea5">Nội dung <span
                                                class="text-danger">*</span></label>
                                    <input type="reset" value="reset" style="opacity: -0.5" id="value-rs">
                                    <textarea
                                            class="form-control reason_id rounded-0 select-item check-value {{ $errors->has('reason') ? ' has-error' : '' }}"
                                            id="exampleFormControlTextarea2" rows="3" placeholder="Lý do xin nghỉ..."
                                            required
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
                                                <div class=" col-8 col-sm-7 pr-0">
                                                    <label class=" text-w-400" for="inputCity">Ngày bắt đầu<span
                                                                class="text-danger">*</span></label>
                                                    <?php
                                                    $autoDate = date('Y/m/d', strtotime('tomorrow'));
                                                    ?>
                                                    <input type="text"
                                                           class="form-control border-0 select-item {{ $errors->has('start_at') ? ' has-error' : '' }}"
                                                           id="start_date" autocomplete="off" name="start_at"
                                                           value="{{ old('start_at', $autoDate) }}"
                                                           readonly="readonly">
                                                </div>
                                                <div class="col-4 col-sm-4 py-0 pl-0 mt-2">
                                                    {{ Form::select('start', CHECK_TIME_DAY_OFF, old('start'), ['class' => 'form-control option-time-day-off browser-default custom-select select-item  check-value time-start' ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 m-0 mt-1">
                                            <div class="row">
                                                <div class="col-8 col-sm-7 pr-0">
                                                    <?php
                                                    $autoDateEnd = date('Y/m/d', strtotime('tomorrow + 1day'));
                                                    ?>
                                                    <label class="text-w-400" for="inputZip">Ngày kết thúc<span
                                                                class="text-danger">*</span></label>
                                                    <input type="text"
                                                           class="form-control select-item  border-0 {{ $errors->has('end_at') ? ' has-error' : '' }}"
                                                           id="end_date" autocomplete="off" name="end_at"
                                                           value="{{  old('end_at',$autoDate) }}"
                                                           readonly>
                                                </div>
                                                <div class="col-4 col-sm-4 py-0 pl-0 mt-2">
                                                    {{ Form::select('end', CHECK_TIME_DAY_OFF, old('end',REMAIN_DAY_OFF_DEFAULT) , ['class' => 'form-control border-0 option-time-day-off browser-default custom-select select-item  check-value time-end ds-end' ]) }}
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
                                    {{ Form::select('approver_id', $userManager, null, ['class' => 'form-control my-1 mr-1 browser-default custom-select select-item mannager_id check-value mt-0']) }}
                                    @if ($errors->has('approver_id'))
                                        <div class="mt-1 ml-3">
                                            <span class="help-block text-danger">{{ $errors->first('approver_id') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="pb-2 pb-sm-3 d-flex justify-content-center border-top-0 rounded mb-0"
                                 id="create_day_off">
                                <button class="btn btn-primary" id="btn-send">GỬI ĐƠN</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{ route('day_off_create_vacation') }}" method="post"
                              id="form_create_day_off_vacation">
                            @csrf
                            <input type="hidden" name="id_hid" class="id_hide">
                            <div class="modal-body mx-3 mt-0 pb-1 pb-sm-3">
                                <div class="mb-1 mb-sm-3">
                                    <!-- Default input -->
                                    <label class="text-w-400" for="exampleForm2">Chế độ nghỉ<span
                                                class="text-danger">*</span></label>
                                    {{ Form::select('title', VACATION,null,['class' => 'form-control my-1 mr-1  browser-default custom-select md-form select-item  check-value edit-regime']) }}
                                    @if ($errors->has('title'))
                                        <div class="">
                                            <span class="help-block text-danger">{{ $errors->first('title') }}</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" name="day_off_id" value="">
                                <div class="mb-1 mb-sm-3">
                                    <label class="text-w-400" for="exampleFormControlTextarea5">Nội dung</label>
                                    <input type="reset" value="reset" style="opacity: -0.5" id="value-rs1">
                                    <textarea
                                            class="form-control reason_id rounded-0 select-item check-value {{ $errors->has('reason') ? ' has-error' : '' }}"
                                            id="exampleFormControl" rows="3" placeholder="Lý do xin nghỉ..."
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
                                            $autoDateEnd = date('Y/m/d', strtotime('tomorrow + 1day'));

                                            ?>
                                            <input type="text"
                                                   class="form-control select-item  {{ $errors->has('start_at') ? ' has-error' : '' }}"
                                                   id="start_date1" autocomplete="off" name="start_at"
                                                   value="{{ old('start_at', $autoDate) }}" readonly="readonly">
                                        </div>
                                        <!-- Default input -->
                                        <div class="form-group col-sm-6 m-0 mt-1">
                                            <label class="text-w-400" for="inputZip">Ngày kết thúc<span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control select-item {{ $errors->has('end_at') ? ' has-error' : '' }}"
                                                   id="end_date1" autocomplete="off" name="end_at"
                                                   value="{{  old('end_at',$autoDateEnd) }}"
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
                                    {{ Form::select('approver_id', $userManager, null, ['class' => 'form-control my-1 mr-1 browser-default custom-select select-item mannager_id check-value mt-0' ]) }}
                                    @if ($errors->has('approver_id'))
                                        <div class="mt-1 ml-3">
                                            <span class="help-block text-danger">{{ $errors->first('approver_id') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="pb-2 pb-sm-3 d-flex justify-content-center border-top-0 rounded mb-0"
                                 id="create_day_off">
                                <button class="btn btn-primary" id="btn-send-day-off">GỬI ĐƠN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-open custom-modal" id="modal-form-detail" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-center" role="document">
            <div class="modal-content modal-center-display" id="bg-img"
                 style="background-image: url({{ asset('img/font/xin_nghi.png') }})">
                <div class="modal-header text-center border-bottom-0 p-3">
                    <h4 class="modal-title w-100 font-weight-bold pt-2">NỘI DUNG ĐƠN</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="btn-close-icon" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-0 mt-0 pb-0">
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
                        <strong id="number_off"></strong>
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
                    <div class="mb-3" id="remove-app-comment">
                        <label class="text-d-bold ml-3" for="exampleFormControlTextarea5">Ý kiến người
                            duyệt</label>
                        <div class="ml-3" id="app-comment"></div>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <div>
                            <span id="btn-show-modal-edit"></span>
                        </div>
                        <div>
                            <span id="btn-show-modal"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <form action="{{ route('delete_day_off') }}" method="post">
        @csrf
        <div class="modal fade custom-modal" id="basicExampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
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

    @if(session()->has('day_off_edit_success'))
        <script>
            swal({
                title: "Thông báo!",
                text: "Bạn đã sửa đơn thành công!",
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
            $('.calendar-search').on('click', function () {
                $(this).prev().datepicker('show');
            })

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
                $('#toggle-show').attr('style', 'display: flex !important');
                $('#home').addClass('active show');
                $('#profile').removeClass('active show');
                $('#defaultUnchecked').prop('checked',true);
                $('#value-rs').click();
                $('#value-rs1').click();
                $('.id_hide').val(' ');
                $(".reason_id").html(null);
                $('#btn-send , #btn-send-day-off').text('Gửi Đơn');
                checkUsable();

            });

            var date = $("#start_date").val();

            @if($autoShowModal)
            $('#modal-form').modal('show');
            @endif

            $("#start_date").on("change", function () {
                // Get the selected date
                var startDt = $("#start_date").datepicker("getDate");
                var startDt1 = $("#start_date1").datepicker("getDate");
                // Set the 'start date' for the second datepicker
                $("#end_date").datepicker("setStartDate", startDt);
                $("#end_date1").datepicker("setStartDate", startDt1);
            });


            $('#search_start_at , #search_end_at').datepicker({format: 'yyyy/mm/dd', orientation: 'bottom'});
            $('#start_date , #start_date1').datepicker({
                format: 'yyyy/mm/dd',
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
            });

            $('#end_date,#end_date1').datepicker({
                format: 'yyyy/mm/dd',
                hoursDisabled: '0,1,2,3,4,5,6,7,18,19,20,21,22,23',
                daysOfWeekDisabled: [0, 6],
                startDate: date
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
                        if (data.time){
                            $('#strat_end').html(data.time);
                        } else{
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
                        if (data.data.approve_comment) {
                            $('#remove-app-comment').show();
                            $('#app-comment').html(data.data.approve_comment);
                        } else {
                            $('#remove-app-comment').hide();
                        }
                        if (data.data.numoff || data.data.absent) {
                            $('#remove-numoff').show();
                        } else {
                            $('#remove-numoff').hide();
                        }
                        if (data.data.numoff || data.data.absent) {
                            (data.data.status == 2 || data.data.status == 0) ? $('#number_off').html(' ') : $('#number_off').html(data.absent + ' ngày');
                            $('#remove-numoff').show();
                        } else {
                            $('#remove-numoff').hide();
                        }
                        if (data.data.status == 0) {
                            $('#btn-show-modal').html('<span class="btn btn-danger" data-toggle="modal" data-target="#basicExampleModal">HỦY ĐƠN</span>');
                            $('#btn-show-modal-edit').html('<span class="btn btn-info" attr=' + data.data.id + '>SỬA ĐƠN</span>');
                        } else {
                            $('#btn-show-modal').html('')
                            $('#btn-show-modal-edit').html('')
                        }
                        $('#modal-form-detail').modal('show');
                    }
                });
            })

            $(document).on('click', '#btn-show-modal-edit', function () {
                var id = $(this).children().attr('attr');
                $.ajax
                ({
                    'url': '{{ route('day_off_detail') }}' + '/' + id,
                    'type': 'get',
                    success: function (data) {
                        $('#modal-form').modal('show');
                        $('#modal-form-detail').modal('hide');
                        $('#toggle-show').attr('style', 'display: none !important');
                        $('.id_hide').val(data.data.id);
                        if (data.data.title == 1) {
                            if (data.totalAbsent !=0){
                                $('#usable-check').text('Bạn sẽ bị tính ' + data.totalAbsent + ' ngày nghỉ không phép vì ngày phép không đủ.')
                                $('#usable-check').show();
                            }
                            $('#profile').removeClass('active show');
                            $('#home').addClass('active show');
                            $('#start_date').val(data.timeStartEdit)

                            $('#end_date').val(data.timeEndEdit)

                            if (data.data.start_date.slice(12,17) == '08:00') {
                                $('.time-start').val(0)
                            } else {
                                $('.time-start').val(1)
                            }
                            if (data.data.end_date.slice(12,17) == '12:00') {
                                $('.time-end').val(0)
                            } else {
                                $('.time-end').val(1)
                            }
                            $('.mannager_id').val(data.approver_id)
                            $('#exampleFormControlTextarea2').html(data.data.reason);
                            $('#btn-send').text('SỬA ĐƠN');

                        }else{
                            $('#usable-check').hide();
                            $('#home').removeClass('active show');
                            $('#profile').addClass('active show');
                            $('.edit-regime').val(data.data.title );
                            $('#exampleFormControl').html(data.data.reason);
                            $('#start_date1').val(data.timeStartEdit)
                            $('#end_date1').val(data.timeEndEdit)
                            $('.mannager_id').val(data.approver_id)
                            $('#btn-send-day-off').text('SỬA ĐƠN');
                        }
                    }
                })
            })

            $('.detail-dayoff').on('click', function () {
                $(this).addClass('text-primary');
            })

            $('.option-dayoff').on('click', function () {
                var check = $(this).val();
                if (check == 1) {
                    $('#usable-check').hide();
                    $('#home').removeClass('active show');
                    $('#profile').addClass('active show');
                } else {
                    $('#usable-check').show();
                    $('#home').addClass('active show');
                    $('#profile').removeClass('active show');
                }
            })
        });

        function checkUsable() {
            checkDate('#start_date', '#end_date', '#errors_date', true, '#btn-send');
            var dateStart = $('#start_date').val();
            var dateEnd = $('#end_date').val();
            var timeStart = $('.time-start').val();
            var timeEnd = $('.time-end').val();
            $.ajax
            ({
                'url': '{{ route('check-usable-day-offf') }}',
                'type': 'get',
                'data': {'start_date': dateStart, 'end_date': dateEnd, 'start_time': timeStart, 'end_time': timeEnd,},
                success: function (data) {
                    $('#usable-check').show();
                    if (data.check && data.absent != 0) {
                        $('#usable-check').text('Bạn sẽ bị tính ' + data.absent + ' ngày nghỉ không phép vì ngày phép không đủ.')
                    } else {
                        $('#usable-check').text(' ')
                    }
                    ;
                    if (data.flag) {
                        $('.ds-end option[value="0"]').attr('disabled', true);
                        $('.ds-end').val(1);
                    } else {
                        $('.ds-end option[value="0"]').attr('disabled', false);
                    }
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
                var checkTimeStart = $('.time-start').val() == 0 ? ' 8:00:00' : ' 18:00:00';
                var checkTimeEnd = $('.time-end').val() == 0 ? ' 8:00:00' : ' 18:00:00';
                var timeStrat = new Date("November 13, 2013 " + checkTimeStart).getTime();
                var timeEnd = new Date("November 13, 2013 " + checkTimeEnd).getTime();
                // alert(timeEnd)
                if (timeStrat > timeEnd) {
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
