<h4>Giờ làm việc</h4>
<div class="row">
    <div class="col-md-6">
        <h5>Sáng</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('morning_start_work_at') ? ' has-error' : '' }}">
                    <span for="morning_start_work_at">Từ</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right" autocomplete="off"
                               name="morning_start_work_at"
                               value="{{ old('morning_start_work_at', $record->morning_start_work_at) }}"
                               id="morning_start_work_at">
                    </div>
                    @if ($errors->has('morning_start_work_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('morning_start_work_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('morning_end_work_at') ? ' has-error' : '' }}">
                    <span for="morning_end_work_at">Đến</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right"
                               name="morning_end_work_at" autocomplete="off"
                               value="{{ old('morning_end_work_at', $record->morning_end_work_at) }}"
                               id="morning_end_work_at">
                    </div>
                    @if ($errors->has('morning_end_work_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('morning_end_work_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <h5>Chiều</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('afternoon_start_work_at') ? ' has-error' : '' }}">
                    <span for="afternoon_start_work_at">Từ</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right" autocomplete="off"
                               name="afternoon_start_work_at"
                               value="{{ old('afternoon_start_work_at', $record->afternoon_start_work_at) }}"
                               id="afternoon_start_work_at">
                    </div>
                    @if ($errors->has('afternoon_start_work_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('afternoon_start_work_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('afternoon_end_work_at') ? ' has-error' : '' }}">
                    <span for="afternoon_end_work_at">Đến</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right"
                               name="afternoon_end_work_at" autocomplete="off"
                               value="{{ old('afternoon_end_work_at', $record->afternoon_end_work_at) }}"
                               id="afternoon_end_work_at">
                    </div>
                    @if ($errors->has('afternoon_end_work_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('afternoon_end_work_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
<hr/>
<h4>Giờ tính đi muộn</h4>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('time_morning_go_late_at') ? ' has-error' : '' }}">
                    <span for="time_morning_go_late_at">Sáng</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right" autocomplete="off"
                               name="time_morning_go_late_at"
                               value="{{ old('time_morning_go_late_at', $record->time_morning_go_late_at) }}"
                               id="time_morning_go_late_at">
                    </div>
                    @if ($errors->has('time_morning_go_late_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('time_morning_go_late_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('time_afternoon_go_late_at') ? ' has-error' : '' }}">
                    <span for="time_afternoon_go_late_at">Chiều</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right"
                               name="time_afternoon_go_late_at" autocomplete="off"
                               value="{{ old('time_afternoon_go_late_at', $record->time_afternoon_go_late_at) }}"
                               id="time_afternoon_go_late_at">
                    </div>
                    @if ($errors->has('time_afternoon_go_late_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('time_afternoon_go_late_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
<hr/>
<h4>Giờ tính Overtime</h4>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('time_ot_early_at') ? ' has-error' : '' }}">
                    <span for="time_ot_early_at">Sáng</span>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="time" class="form-control pull-right" autocomplete="off"
                               name="time_ot_early_at"
                               value="{{ old('time_ot_early_at', $record->time_ot_early_at) }}"
                               id="time_ot_early_at">
                    </div>
                    @if ($errors->has('time_ot_early_at'))
                        <span class="help-block">
                    <strong>{{ $errors->first('time_ot_early_at') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<hr/>
<h4>Ngày làm việc</h4>
<div class="form-group margin-b-5 margin-t-5{{ $errors->has('work_days') ? ' has-error' : '' }}">
    <label for="work_days">Đến</label>
    <div class="input-group date">
        <ul class="list-group list-inline">
            <?php $days = get_day_of_week();?>
            @foreach($days as $dayOff => $day)
                <?php
                $inputId = 'day_work_' . $dayOff;
                ?>
                <li class="">
                    <input type="checkbox" id="{{$inputId}}"
                           @if(in_array($dayOff, $record->work_days))
                           checked
                           @endif
                           name="work_days[]"
                           value="{{$dayOff}}">
                    <label
                            for="{{$inputId}}">{{$day}}</label>
                </li>
            @endforeach
        </ul>
    </div>
    @if ($errors->has('work_days'))
        <span class="help-block">
                    <strong>{{ $errors->first('work_days') }}</strong>
                </span>
    @endif
</div>