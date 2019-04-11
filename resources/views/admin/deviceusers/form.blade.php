<div class="col-md-7">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
                        <label for="types_device_id">Chủng loại *</label>
                        <select class="form-control" id="types_device_id" name="types_device_id">
                            <option value="">Chọn chủng loại</option>
                            @foreach(TYPES_DEVICE as $key => $device)
                                @if (Input::old('types_device_id') == $key)
                                    <option value="{{ $key }}" selected>{{ $device }}</option>
                                @else
                                    @if ($record && $record->types_device_id == $key)
                                        <option value="{{ $key }}" selected>{{ $device }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $device }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                        @if ($errors->has('types_device_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('types_device_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('devices_id') ? ' has-error' : '' }}">
                        <label for="devices_id">Thiết bị *</label>
                        <select class="form-control" id="devices_id" name="devices_id">
                            <option value="" selected>Chọn thiết bị</option>
                            @foreach($devices as $device)
                                @if (Input::old('devices_id') == $device->id)
                                    <option value="{{ $device->id }}" selected>{{ $device->name }}</option>
                                @else
                                    @if ($record && $record->devices_id == $device->id)
                                        <option value="{{ $device->id }}" selected>{{ $device->name }}</option>
                                    @else
                                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                        @if ($errors->has('devices_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('devices_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('users_id') ? ' has-error' : '' }}">
                        <label for="users_id">Nhân viên *</label>
                        <select class="select2 form-control" id="users_id" name="users_id">
                            <option value="">Chọn nhân viên</option>
                            @foreach($users as $user)
                                @if (Input::old('users_id') == $user->id)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                @else
                                    @if ($record && $record->users_id == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                        @if ($errors->has('users_id'))
                            <span class="help-block">
                    <strong>{{ $errors->first('users_id') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code">Code</label>
                        <input type="text" class="form-control pull-right datepicker"
                               name="code" disabled="disabled"
                               value="{{ old('code', $record->code) }}" id="code" placeholder="Code" min="0">
                        @if ($errors->has('code'))
                            <span class="help-block">
                    <strong>{{ $errors->first('code') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="allocate_date">Ngày cấp</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="false" class="form-control pull-right datepicker"
                                   name="allocate_date"
                                   value="{{ old('allocate_date', $record->allocate_date) }}" id="allocate_date">
                        </div>
                        @if ($errors->has('allocate_date'))
                            <span class="help-block">
                    <strong>{{ $errors->first('allocate_date') }}</strong>
                </span>
                    @endif
                    <!-- /.input group -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="return_date">Ngày trả</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="false" class="form-control pull-right datepicker"
                                   name="return_date"
                                   value="{{ old('return_date', $record->return_date) }}" id="return_date">
                        </div>
                        @if ($errors->has('return_date'))
                            <span class="help-block">
                    <strong>{{ $errors->first('return_date') }}</strong>
                </span>
                    @endif
                    <!-- /.input group -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
                <label for="note">Ghi chú</label>
                <textarea class="form-control" name="note" placeholder="Ghi chú"
                          rows="5"
                          id="note"> {{ old('note', $record->note) }}</textarea>

                @if ($errors->has('note'))
                    <span class="help-block">
                        <strong>{{ $errors->first('note') }}</strong>
                    </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>

    </div>
</div>
<!-- /.col-md-5 -->
@push('footer-scripts')
    <script>
        $(function () {
            myDatePicker($("#allocate_date, #return_date"));

            let allocateDate = $('#allocate_date').val();
            if (allocateDate) {
                $('#return_date').datepicker('setStartDate', allocateDate);
            }

            let returnDate = $('#return_date').val();
            if (returnDate) {
                $('#allocate_date').datepicker('setEndDate', returnDate);
            }

            $('#allocate_date').change(function () {
                $('#return_date').datepicker('setStartDate', $(this).val());
            });

            $('#return_date').change(function () {
                $('#allocate_date').datepicker('setEndDate', $(this).val());
            });

            $(document).on('change', '#types_device_id', function () {
                let urlReq = '/api/v1/deviceusers/get-devices';
                let data = {
                    'types_device_id': $(this).val()
                };
                $.ajax({
                    url: urlReq,
                    type: "POST",
                    dataType: "JSON",
                    data: data,
                    success: function (res) {
                        console.log(res);
                        let result = res['data']['devices'];
                        let htmlRender = '<option value="" selected>Chọn thiết bị</option>';
                        if (result && Array.isArray(result)) {
                            result.forEach(el => {
                                htmlRender += '<option value="' + el['id'] + '">' + el['name'] + '</option>';
                            });
                        }
                        $('#devices_id').html(htmlRender);
                    },
                    error: function (err) {
                    },
                })
            })

        })
    </script>
@endpush