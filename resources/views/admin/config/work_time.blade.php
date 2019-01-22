<h4>Giờ làm việc</h4>
<div class="row">
    <div class="col-md-6">
        <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_work_at') ? ' has-error' : '' }}">
            <label for="start_work_at">Từ</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="time" class="form-control pull-right" autocomplete="off"
                       name="start_work_at"
                       value="{{ old('start_work_at', $record->start_work_at) }}" id="start_work_at">
            </div>
            @if ($errors->has('start_work_at'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_work_at') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group margin-b-5 margin-t-5{{ $errors->has('end_work_at') ? ' has-error' : '' }}">
            <label for="end_work_at">Đến</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="time" class="form-control pull-right"
                       name="end_work_at" autocomplete="off"
                       value="{{ old('end_work_at', $record->end_work_at) }}" id="end_work_at">
            </div>
            @if ($errors->has('end_work_at'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_work_at') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

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
                           name="day_works[]"
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