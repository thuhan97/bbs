<div class="col-md-7">
    <div class="row">
        <div class="col-md-6">
            @if($record->id)
                <input type="hidden" class="form-control pull-right"
                       name="id" autocomplete="off"
                       value="{{ $record->id }}">
                <input type="hidden"
                       class="form-control pull-right"
                       name="user_id"
                       autocomplete="off"
                       value="{{ old('user_id', $record->user_id ?? '') }}">
                Nhân viên: <strong>{{$record->user->staff_code ?? ''}} - {{$record->user->name ?? ''}}</strong>
                <br/>
            @else
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    <label for="user_id">Chọn nhân viên *</label>
                    {{ Form::select('user_id', ['' => 'Chọn nhân viên'] +  $request_users, $record->user_id, ['class'=>'select2 form-control']) }}
                    @if ($errors->has('user_id'))
                        <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('work_day') ? ' has-error' : '' }}">
                <label for="work_day">Ngày làm việc *</label>
                <input type="text" class="form-control" name="work_day" placeholder="Ngày làm việc" id="work_day"
                       value="{{ old('work_day', $record->work_day ?? date(DATE_FORMAT)) }}"
                       @if($record->id)
                       readonly
                       @else
                       required
                        @endif
                >


                @if ($errors->has('work_day'))
                    <span class="help-block">
                    <strong>{{ $errors->first('work_day') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('type') ? ' has-error' : '' }}">
                <label for="type">Phân loại</label>
                {{ Form::select('type', ['' => ''] + \App\Models\WorkTime::WORK_TIME_CALENDAR_TYPE, $record->type, ['class'=>'form-control', 'disabled']) }}
                @if ($errors->has('type'))
                    <span class="help-block">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="work_day">Tính công</label>
                <input type="text" class="form-control"
                       value="{{ $record->cost }}" disabled>
            </div>
        </div>
    </div>
    <!-- /.form-group -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_at') ? ' has-error' : '' }}">
                <label for="start_at">Giờ đến công ty *</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" autocomplete="off"
                           name="start_at"
                           value="{{ old('start_at', $record->start_at ?? ($config->morning_start_work_at ?? '8:00')) }}"
                           id="start_at">
                </div>
                @if ($errors->has('start_at'))
                    <span class="help-block">
                    <strong>{{ $errors->first('start_at') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('end_at') ? ' has-error' : '' }}">
                <label for="end_at">Giờ rời công ty *</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right"
                           name="end_at" autocomplete="off"
                           value="{{ old('end_at', $record->end_at ?? ($config->afternoon_end_work_at ?? '17:30')) }}"
                           id="end_at">

                </div>
                @if ($errors->has('end_at'))
                    <span class="help-block">
                    <strong>{{ $errors->first('end_at') }}</strong>
                </span>
                @endif
            </div>
        </div>

    </div>
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
        <label for="note">Ghi chú</label>
        <textarea type="text" class="form-control" name="note">{{ old('note', $record->note) }}</textarea>

        @if ($errors->has('note'))
            <span class="help-block">
                    <strong>{{ $errors->first('note') }}</strong>
                </span>
        @endif
    </div>
    <!-- /.form-group -->
</div>
<div class="col-md-5">
    <div class="explanation-note">
        <label for="explanation_note">Giải trình *</label>
        <input type="hidden" value="{{ $record->explanation($record->work_day)->id ?? '' }}" name="explanation_id">
        <input type="hidden" value="{{ $record->explanation($record->work_day)->work_day ?? '' }}"
               name="explanation_work_day">
        <textarea id="explanation_note" type="text" class="form-control mt-2" rows="10"
                  name="explanation_note">{{ old('explanation_note', $record->explanation($record->work_day)->note ?? '') }}</textarea>
    </div>
</div>

<!-- /.col-md-7 -->
@push('footer-scripts')
    <script>
        $(function () {
            myDatePicker($("#work_day"));
            $("#start_at, #end_at").timepicker({
                format: 'LT',
                showMeridian: false
            });
        })

    </script>
@endpush