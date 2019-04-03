<?php
$defaultStaffCode = "J" . str_pad((\App\Models\User::max('id') + 1), 3, '0', STR_PAD_LEFT);
?>

<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="staff_code">Mã nhân
                            viên:</label> {{ old('staff_code', $record->staff_code ?? $defaultStaffCode ) }}
                    </div>
                </div>
                <div class="col-md-6"></div>

            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="name">Họ và tên:</label> {{ old('name', $record->name) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="birthday">Ngày sinh:</label> {{ old('birthday', $record->birthday) }}
                    <!-- /.input group -->
                    </div>
                </div>
            </div>


        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="id_card">Số chứng minh nhân dân:</label> {{ old('id_card', $record->id_card) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="id_addr">Nơi cấp:</label> {{ old('id_addr', $record->id_addr) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="email">Email:</label> {{ old('email', $record->email) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="phone">Số điện thoại:</label> {{ old('phone', $record->phone) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="address">Địa chỉ thường trú:</label> {{ old('address', $record->address) }}
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="school">Đại học/cao đẳng:</label> {{ old('school', $record->school) }}
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
            <div class="form-group margin-b-5 margin-t-5">
                <label for="start_date">Ngày vào công ty:</label> {{ old('start_date', $record->start_date) }}
            <!-- /.input group -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="end_date">Ngày nghỉ việc:</label> {{ old('end_date', $record->end_date) }}
            <!-- /.input group -->
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="current_address">Loại hợp
                    đồng:</label> {{ isset(CONTRACT_TYPES_NAME[$record->contract_type]) ? CONTRACT_TYPES_NAME[$record->contract_type] : '' }}
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="status">
                    <input type="checkbox" class="square-blue" name="status" id="status" disabled
                           value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 1) == 1 ? 'checked' : '' }}>
                    Kích hoạt
                </label>
            </div>
        </div>
    </div>

    <hr/>
    <a href="{{route('admin::day_offs.user', $record->id)}}" class="btn btn-info">Xem ngày nghỉ phép nhân viên</a>
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