<div class="col-md-7">
    <h3>Dành cho nhân viên xin nghỉ phép</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('user_id') ? ' has-error' : '' }}">
                <label for="user_id">Chọn nhân viên *</label>
                {{ Form::select('user_id', ['' => 'Chọn nhân viên'] +  $request_users, $record->user_id ?? $user_id, ['class'=>'select2 form-control']) }}
                @if ($errors->has('user_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Tiêu đề</label>
                {{ Form::select('title', VACATION, $record->title, ['class' => 'form-control my-1 mr-1 browser-default custom-select md-form select-item']) }}
                @if ($errors->has('title'))
                    <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_at') ? ' has-error' : '' }}">
                        <label for="start_at">Từ ngày *</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" autocomplete="off"
                                   name="start_at"
                                   value="{{ old('start_at', $record->start_at) }}" id="start_at">
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
                        <label for="end_at">Đến ngày *</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right"
                                   name="end_at" autocomplete="off"
                                   value="{{ old('end_at', $record->end_at) }}" id="end_at">
                        </div>
                        @if ($errors->has('end_at'))
                            <span class="help-block">
                    <strong>{{ $errors->first('end_at') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('reason') ? ' has-error' : '' }}">
                <label for="reason">Nhập lý do nghỉ phép *</label>
                <textarea class="form-control" name="reason" id="reason" rows="5"
                          placeholder="Nhập lý do">{{ old('reason', $record->reason) }}</textarea>

                @if ($errors->has('reason'))
                    <span class="help-block">
                    <strong>{{ $errors->first('reason') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>

    </div>
</div>
<div class="col-md-5">
    <h3>Dành cho người duyệt</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('approver_id') ? ' has-error' : '' }}">
                <label for="approver_id">Người duyệt</label>
                {{ Form::select('approver_id', ['' => 'Chọn người duyệt'] + $approver_users, $record->approver_id, ['class'=>'select2 form-control']) }}
                @if ($errors->has('approver_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('approver_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('number_off') ? ' has-error' : '' }}">
                <label for="number_off">Số ngày nghỉ được tính (1 ngày hoặc nửa ngày) *</label>
                <input type="text" class="form-control" name="number_off" placeholder="Số ngày phép bị trừ"
                       value="{{ old('number_off', $record->number_off) }}" required>

                @if ($errors->has('number_off'))
                    <span class="help-block">
                    <strong>{{ $errors->first('number_off') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('approve_comment') ? ' has-error' : '' }}">
                <label for="approve_comment">Ý kiến phê duyệt</label>
                <textarea class="form-control" name="approve_comment" id="approve_comment" rows="3"
                          placeholder="Nhập ý kiến phê duyệt">{{ old('approve_comment', $record->approve_comment) }}</textarea>

                @if ($errors->has('approve_comment'))
                    <span class="help-block">
                    <strong>{{ $errors->first('approve_comment') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-xs-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="status">
                    <input type="checkbox" class="square-blue" name="status" id="status"
                           value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 1) == 1 ? 'checked' : '' }}>
                    Đã duyệt
                </label>
            </div>
            <!-- /.form-group -->
        </div>
    </div>
</div>

<!-- /.col-md-7 -->
@push('footer-scripts')
    <script>

        $(function () {
            myDateTimePicker($("#start_at, #end_at"));
        })
    </script>
@endpush