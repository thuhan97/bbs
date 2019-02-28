<?php
$defaultStaffCode = "J" . str_pad((\App\Models\User::max('id') + 1), 3, '0', STR_PAD_LEFT);
$userId = $record->id;
$record = \App\Models\User::whereId($record->id)->first();
$workTimePayload = \App\Models\WorkTimeRegister::where('user_id', $record->id)->get();
?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="status" class="select_type">
                    <input type="radio" class="square-blue" name="select_type" id="radio_select_type_0"
                           value="0">
                    Chọn nhanh
                </label>
                <label for="status" class="select_type">
                    <input type="radio" class="square-blue" name="select_type" id="radio_select_type_1"
                           value="1">
                    Thiết lập theo thứ
                </label>
                <label for="status" class="select_type">
                    <input type="radio" class="square-blue" name="select_type" id="radio_select_type_2"
                           value="2">
                    Thiết lập theo giờ
                </label>
            </div>
        </div>
        <div class="col-md-12 select_type_0">
            <div class="row">
                <div class="col-md-3">
                    <label for="staff_code">Chọn nhanh</label>
                    {{ Form::select('quick_part', WORK_TIME_QUICK_SELECT, ['class'=>'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-md-12 select_type_1">
            <div class="row">
                <div class="col-md-2">
                    <label for="staff_code">Thứ 2</label>
                    {{ Form::select('mon_part', WORK_TIME_SELECT, ['class'=>'form-control']) }}
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 3</label>
                    {{ Form::select('tue_part', WORK_TIME_SELECT, ['class'=>'form-control']) }}
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 4</label>
                    {{ Form::select('wed_part', WORK_TIME_SELECT, ['class'=>'form-control']) }}
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 5</label>
                    {{ Form::select('thu_part', WORK_TIME_SELECT, ['class'=>'form-control']) }}
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 6</label>
                    {{ Form::select('fri_part', WORK_TIME_SELECT, ['class'=>'form-control']) }}
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 7</label>
                    {{ Form::select('sat_part', WORK_TIME_SELECT, ['class'=>'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-md-12 select_type_2">
            <div class="row">
                <div class="bfh-timepicker">
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 2</label>
                    <div class="bootstrap-timepicker">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="mon_start"
                                   placeholder="Thời gian bắt đầu"
                                   value="">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="mon_end" placeholder="Thời gian kết thúc"
                           value="" readonly="">
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 3</label>
                    <div class="bootstrap-timepicker">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="tue_start"
                                   placeholder="Thời gian bắt đầu"
                                   value="">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="tue_end" placeholder="Thời gian kết thúc"
                           value="" readonly="">
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 4</label>
                    <div class="bootstrap-timepicker">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="wed_start"
                                   placeholder="Thời gian bắt đầu"
                                   value="">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="wed_end" placeholder="Thời gian kết thúc"
                           value="" readonly="">
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 5</label>
                    <div class="bootstrap-timepicker">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="thu_start"
                                   placeholder="Thời gian bắt đầu"
                                   value="">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="thu_end" placeholder="Thời gian kết thúc"
                           value="" readonly="">
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 6</label>
                    <div class="bootstrap-timepicker">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="fri_start"
                                   placeholder="Thời gian bắt đầu"
                                   value="">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="fri_end" placeholder="Thời gian kết thúc"
                           value="" readonly="">
                </div>
                <div class="col-md-2">
                    <label for="staff_code">Thứ 7</label>
                    <div class="bootstrap-timepicker">
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="sat_start"
                                   placeholder="Thời gian bắt đầu"
                                   value="">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="sat_end" placeholder="Thời gian kết thúc"
                           value="" readonly="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.col-md-5 -->
@push('footer-scripts')
    <script>
        var toggleClass = (num) => {
            let arr = [0, 1, 2]
            $('.select_type_' + num).removeClass('hidden').addClass('show')
            let index = arr.indexOf(parseInt(num))
            if (index > -1) {
                arr.splice(index, 1);
            }
            $.each(arr, function (index, value) {
                $('.select_type_' + value).removeClass('show').addClass('hidden')
            })
        }

        $('#radio_select_type_0').attr('checked', 'checked')
        toggleClass(0)
        $(document).ready(function () {
            $('.select_type').click(function () {
                let selectTypeVal = $(this).find('input').val()
                toggleClass(selectTypeVal)
            })
        })

        $(function () {
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: true,
                showMeridian: false,
            })
        })
    </script>
@endpush