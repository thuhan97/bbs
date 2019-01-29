<?php
$defaultStaffCode = "J" . str_pad((\App\Models\User::max('id') + 1), 3, '0', STR_PAD_LEFT);
?>

<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('staff_code') ? ' has-error' : '' }}">
                        <label for="staff_code">Mã nhân viên *</label>
                        <input type="text" class="form-control" name="staff_code" placeholder="Nhập mã nhân viên"
                               value="{{ old('staff_code', $record->staff_code ?? $defaultStaffCode ) }}" required>

                        @if ($errors->has('staff_code'))
                            <span class="help-block">
                    <strong>{{ $errors->first('staff_code') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="staff_code">Giới tinh</label>
                    {{ Form::select('sex', SEXS, $record->sex, ['class'=>'form-control']) }}
                </div>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Họ và tên *</label>
                        <input type="text" class="form-control" name="name" placeholder="Họ và tên"
                               value="{{ old('name', $record->name) }}" required>

                        @if ($errors->has('name'))
                            <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label for="birthday">Ngày sinh</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker"
                                   name="birthday"
                                   value="{{ old('birthday', $record->birthday) }}" id="birthday">
                        </div>
                        @if ($errors->has('birthday'))
                            <span class="help-block">
                    <strong>{{ $errors->first('birthday') }}</strong>
                </span>
                    @endif
                    <!-- /.input group -->
                    </div>
                </div>
            </div>


        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('id_card') ? ' has-error' : '' }}">
                        <label for="id_card">Số chứng minh nhân dân</label>
                        <input type="text" class="form-control" name="id_card" placeholder="CMND"
                               value="{{ old('id_card', $record->id_card) }}">

                        @if ($errors->has('id_card'))
                            <span class="help-block">
                    <strong>{{ $errors->first('id_card') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('id_addr') ? ' has-error' : '' }}">
                        <label for="id_addr">Nơi cấp</label>
                        <input type="text" class="form-control" name="id_addr" placeholder="Nơi cấp"
                               value="{{ old('id_addr', $record->id_addr) }}">

                        @if ($errors->has('id_addr'))
                            <span class="help-block">
                    <strong>{{ $errors->first('id_addr') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email"
                               value="{{ old('email', $record->email) }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" placeholder="Số điện thoại"
                               value="{{ old('phone', $record->phone) }}">

                        @if ($errors->has('phone'))
                            <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address">Địa chỉ thường trú</label>
                <input type="text" class="form-control" name="address" placeholder="Địa chỉ thường trú"
                       value="{{ old('address', $record->address) }}">

                @if ($errors->has('address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('school') ? ' has-error' : '' }}">
                <label for="school">Đại học/cao đẳng</label>
                <input type="text" class="form-control" name="school" placeholder="Đại học/cao đẳng"
                       value="{{ old('school', $record->school) }}">

                @if ($errors->has('school'))
                    <span class="help-block">
                    <strong>{{ $errors->first('school') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">

        </div>
        <!-- /.col-md-12 -->

    </div>
</div>
<div class="col-md-7">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_date') ? ' has-error' : '' }}">
                <label for="start_date">Ngày vào công ty</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker"
                           name="start_date"
                           value="{{ old('start_date', $record->start_date) }}" id="start_date">
                </div>
                @if ($errors->has('start_date'))
                    <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
            <!-- /.input group -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('end_date') ? ' has-error' : '' }}">
                <label for="end_date">Ngày nghỉ việc</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker"
                           name="end_date"
                           value="{{ old('end_date', $record->end_date) }}" id="end_date">
                </div>
                @if ($errors->has('end_date'))
                    <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
            <!-- /.input group -->
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('jobtitle_id') ? ' has-error' : '' }}">
                <label for="jobtitle_id">Chức danh</label>
                {{ Form::select('jobtitle_id', JOB_TITLES, $record->jobtitle_id ?? 0, ['class'=>'form-control']) }}

                @if ($errors->has('jobtitle_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('jobtitle_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('position_id') ? ' has-error' : '' }}">
                <label for="position_id">Chức vụ</label>
                {{ Form::select('position_id', JOB_TITLES, $record->position_id ?? 0, ['class'=>'form-control']) }}

                @if ($errors->has('position_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('position_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('current_address') ? ' has-error' : '' }}">
                <label for="current_address">Loại hợp đồng</label>
                {{ Form::select('contract_type', CONTRACT_TYPES_NAME, $record->contract_type ?? 0, ['class'=>'form-control']) }}

                @if ($errors->has('current_address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('current_address') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="status">
                    <input type="checkbox" class="square-blue" name="status" id="status"
                           value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 1) == 1 ? 'checked' : '' }}>
                    Đang làm việc
                </label>
            </div>
        </div>
    </div>

    <hr/>
    <h3>Đổi mật khẩu</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">

                @if ($errors->has('password'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" name="password_confirmation"
                       placeholder="Xác nhận mật khẩu">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>

    </div>

    <!-- /.form-group -->
</div>
<!-- /.col-md-5 -->
@push('footer-scripts')
    <script>

        $(function () {
            myDatePicker($("#birthday, #start_date, #end_date"));
        })
    </script>
@endpush