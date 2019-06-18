<div class="col-md-2"></div>
<div class="col-md-4">
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12" style="padding: 0">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
                    <label for="types_device_id">Nhân viên yêu cầu:</label>
                    <p>{{ $record->user->name }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
                    <label for="types_device_id">Manager phê duyệt :</label>
                    <p>{{ $record->manager->name ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
                <label for="note">Tiêu đề</label>
                <p>{!! $record->title !!}</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
                        <label for="note">Nội dung :</label>
                        <p>{!! $record->content !!}</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
                                <label for="note">Ý kiến Manager phê duyệt :</label>
                                <p>{!! $record->approval_manager !!}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="col-md-12">
        <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
            <label for="note">Ý kiến phê duyệt của HCNS :</label>
            <textarea class="form-control" name="approval_hcnv" placeholder="Ghi chú"
                      rows="4"
                      id="note"> {{ old('approval_hcnv', $record->approval_hcnv) }}</textarea>

            @if ($errors->has('note'))
                <span class="help-block">
                            <strong>{{ $errors->first('note') }}</strong>
                        </span>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
            <label for="devices_id">Ngày hẹn trả</label>
            <input name="return_date" value="{{ old('return_date',$record->return_date) }}" type="text" readonly class="form-control" id="date-return">
        </div>
    </div>

    <div class="col-md-12 mt-3">

        <div class="form-group margin-b-5 margin-t-5">
            <label for="status_active" class="">
                <span>
                    <div class="iradio_square-blue " aria-checked="false" aria-disabled="false" style="position: relative;"><input type="radio" class="square-blue" {{ $record->status !=0 ? "checked" : '' }} name="status" id="status_active" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 2px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>Duyệt đơn
                </span>
            </label>
            <label for="status_no_active">
                <span style="padding: 15px">
                    <div class="iradio_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="radio" class="square-blue" {{ $record->status ==0 ? "checked" : '' }} name="status" value="0" id="status_no_active" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 2px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>Hủy đơn
                </span>
            </label>
        </div>
        <!-- /.form-group -->
    </div>
</div>

<script>
    $(function () {
        $("#date-return").datepicker({
            format:"yyyy-mm-dd"
        });
        $('.toggle-create').remove();
    })
</script>
