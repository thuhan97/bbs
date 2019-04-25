<div class="col-md-10">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="creator_id">Người xin :</label>
                        {{ Form::select('creator_id', ['' => 'Chọn nhân viên'] +  $request_users, $record->creator_id ?? $user_id, $record->creator_id ? ['disabled'=>'disabled','class'=>'select2 form-control'] : ['class'=>'select2 form-control']) }}
                    </div>
                </div>
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="">Trạng thái: </label>
                <label for="status">
                    <span>
                        <input type="radio" class="square-blue" name="status" value="1"{{ old('status', $record->status ) == array_search("Đã duyệt",OT_STATUS) ? 'checked' : '' }} >
                    Duyệt
                    </span>
                    <span style="padding: 15px">
                        <input type="radio" class="square-blue" name="status" value="0" {{ old('status', $record->status ) == array_search("Chưa duyệt",OT_STATUS) ? 'checked' : '' }}>
                    Chờ duyệt
                    </span>
                </label>
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group col-md-4" style="padding-left: 0;">
                <label for="approver_id">Người duyệt</label>
                {{ Form::select('approver_id', ['' => 'Chọn nhân viên'] +  $approver_users, $record->approver_id, ['class'=>'select2 form-control']) }}
            </div>
        </div>
        <div class="col-md-4">
            <label for="work_day">Ngày xin *</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" autocomplete="off"
                       name="work_day"
                       value="{{ old('work_day', $record->work_day) }}" id="work_day">
            </div>
        </div>
        <div class="col-md-4">
            <label for="work_day">Ngày duyệt *</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" autocomplete="off"
                       name="approver_at"
                       value="{{ old('approver_at', $record->approver_at) }}" id="approver_at">
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="reason">Mô tả</label>
                <textarea id="reason" class="form-control" name="reason" rows="5"
                          placeholder="Miêu tả">{{ old('reason', $record->reason) }}</textarea>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>
        $(function () {
            myDatePicker($("#work_day,#approver_at"));
        })
    </script>
@endpush
