<div class="col-md-7">
    <input type="hidden" name="id" value="{{$record->id}}">
    <!-- /.form-group -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('rule_id') ? ' has-error' : '' }}">
                <label for="rule_id">Vi phạm *</label>
                {{ Form::select('rule_id', ['' => 'Chọn vi phạm'] +  $rules, $record->rule_id, $record->rule_id ? ['disabled'=>'disabled','class'=>'select2 form-control'] : ['class'=>'select2 form-control']) }}
                @if ($errors->has('rule_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('rule_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('user_id') ? ' has-error' : '' }}">
                <label for="user_id">Chọn nhân viên *</label>
                {{ Form::select('user_id', ['' => 'Chọn nhân viên'] +  $users, $record->user_id, $record->user_id ? ['disabled'=>'disabled','class'=>'select2 form-control'] : ['class'=>'select2 form-control']) }}
                @if ($errors->has('user_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('infringe_date') ? ' has-error' : '' }}">
                <label for="infringe_date">Ngày vi phạm *</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" autocomplete="off"
                           name="infringe_date"
                           value="{{ old('infringe_date', $record->infringe_date ?? date('Y/m/d')) }}"
                           id="infringe_date">
                </div>
                @if ($errors->has('infringe_date'))
                    <span class="help-block">
                    <strong>{{ $errors->first('infringe_date') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('detail') ? ' has-error' : '' }}">
        <label for="detail">Chứng cớ</label>
        <textarea class="form-control" name="detail" id="detail" rows="5"
                  placeholder="Nhập chứng cớ">{{ old('detail', $record->detail) }}</textarea>

        @if ($errors->has('detail'))
            <span class="help-block">
                    <strong>{{ $errors->first('detail') }}</strong>
                </span>
        @endif
    </div>
    <!-- /.form-group -->
</div>
<!-- /.col-md-7 -->
@push('footer-scripts')
    <script>
        $(function () {
            myDatePicker($("#infringe_date"));
        })
    </script>
@endpush