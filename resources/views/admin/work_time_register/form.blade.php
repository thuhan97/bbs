<?php
$currentId = intval(session('currentId'));
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
                    {{ Form::select('quick_part', WORK_TIME_QUICK_SELECT, $oldValue['type_1'], ['class'=>'form-control']) }}
                </div>
            </div>
        </div>
        <div class="col-md-12 select_type_1">
            <div class="row">
                @foreach(PART_OF_THE_DAY as $key => $value)
                    <div class="col-md-2 margin-t-5{{ $errors->has($value . '_part') ? ' has-error' : '' }}">
                        <label for="staff_code">Thứ {{$key + 2}}</label>
                        {{ Form::select($value . '_part', WORK_TIME_SELECT, $oldValue['type_2'][$value], ['class'=>'form-control']) }}
                        @if ($errors->has($value . '_part'))
                            <span class="help-block">
                            <strong>{{ $errors->first($value . '_part') }}</strong>
                        </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12 select_type_2">
            <div class="row">
                <div class="bfh-timepicker">
                </div>
                @foreach(PART_OF_THE_DAY as $key => $item)
                    <div class="col-md-2 margin-t-5{{ $errors->has($item . '_start') || $errors->has($item .'_end') ? ' has-error' : '' }}">
                        <label for="staff_code">Thứ {{ $key+2 }}</label>
                        <div class="bootstrap-timepicker">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker" name="{{$item}}_start"
                                       placeholder="Thời gian bắt đầu"
                                       value="{{ $oldValue['type_3'][$item]['start_at'] }}">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="{{$item}}_end" name="{{$item}}_end"
                               placeholder="Thời gian kết thúc"
                               value="{{ $oldValue['type_3'][$item]['end_at'] }}" readonly="">
                        @if ($errors->has($item . '_start') || $errors->has($item . '_end'))
                            <span class="help-block">
                            <strong>{{ $errors->first($item . '_start') ? $errors->first($item . '_start') : $errors->first($item . '_end') }}</strong>
                        </span>
                        @endif
                    </div>
                @endforeach
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

        var timeEndCalculate = (e) => {
            let hour = e.time.hours
            let minute = e.time.minutes

            hour += 5
            minute += 30
            if (minute >= 60) {
                minute = minute - 60
                hour += 1
            }
            if (hour >= 12 && hour <= 13) {
                return '{{ WORK_PATH[0]['end_at'] }}'
            }

                minute = minute == 0 ? '00' : minute
            return hour + ':' + minute + ':00'
        }

        $('#radio_select_type_{{ $currentId }}').attr('checked', 'checked')
        toggleClass({{ $currentId }})
        $(document).ready(function () {
            $('.select_type').click(function () {
                let selectTypeVal = $(this).find('input').val()
                toggleClass(selectTypeVal)
            })
        })

        $(function () {
            $('.timepicker').timepicker({
                showInputs: true,
                showMeridian: false,
                defaultTime: null,
                showSeconds: true,
            })

            $('.timepicker').timepicker().on('changeTime.timepicker', function (e) {
                let str = $(this).attr('name')
                let selector = str.replace('start', 'end')
                let endTimeSelector = $('#' + selector)

                if (e.time.hours < 8) {
                    $(this).val('{{ $config['morning_start_work_at'] }}')
                    endTimeSelector.val('{{ WORK_PATH[0]['end_at'] }}')
                    return
                } else if (e.time.hours >= 13) {
                    $(this).val('{{ $config['afternoon_start_work_at'] }}');
                    endTimeSelector.val('{{ $config['afternoon_end_work_at'] }}')
                    return
                } else if (e.time.hours <= 13 && e.time.hours >= 12) {
                    $(this).val('{{ $config['afternoon_start_work_at'] }}');
                    endTimeSelector.val('{{ $config['afternoon_end_work_at'] }}')
                    return
                }

                endTimeSelector.val(timeEndCalculate(e));
            });
        })
    </script>
@endpush