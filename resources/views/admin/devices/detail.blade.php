<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="staff_code">Chủng loại: </label> {{ old('types_device_id', TYPES_DEVICE[$record->types_device_id] ) }}
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
                        <label for="email">Tồn cuối:</label> {{ old('final', $record->final) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="birthday">Số lương tồn:</label> {{ old('quantity_inventory', $record->quantity_inventory) }}
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
                        <label for="id_card">Số lương đang sử dụng:</label> {{ old('quantity_used', $record->quantity_used) }}
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="id_addr">Sử dụng trong tháng:</label> {{ old('month_of_use', $record->month_of_use) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="phone">Ghi chú:</label> {{ old('note', $record->note) }}
            </div>
        </div>
    </div>
</div>
<!-- /.col-md-5 -->
@if($allocateUsers)
    <div class="col-md-12">
        <h3 style="float:left;">Danh sách cấp thiết bị</h3>
        <a href="{{ route('admin::deviceusers.allocate', $record->id) }}"><button type="button" class="btn btn-primary" style="float:right; margin: 10px;">Cấp phát</button></a>
    </div>
    <div class="col-md-12">
        <div class="table-responsive list-records">
            <table class="table table-hover table-bordered dataTable">
                <thead>
                <th style="width: 10px;">
                    #
                </th>
                <th style="width: 10%;" class="no-wap">
                    Nhân viên
                </th>
                <th style="width: 12%;">
                    Tên thiết bị
                </th>
                <th style="width: 9%;">Mã thiết bị
                </th>

                <th style="width: 9%;">Ngày cấp
                </th>
                <th style="width: 9%;">Ngày trả
                </th>
                <th>Ghi chú
                </th>
                <th style="width: 120px;">Chức năng</th>
                </thead>
                <tbody>
                <?php
                $tableCounter = 0;
                ?>
                @foreach ($allocateUsers as $record)
                    <?php
                    $tableCounter++;
                    $editLink = route('admin::deviceusers.edit', $record->id);
                    $showLink = route('admin::deviceusers.show', $record->id);
                    $deleteLink = route('admin::deviceusers.destroy', $record->id);
                    $formId = 'formDeleteModelDU_' . $record->id;
                    ?>
                    <tr>
                        <td>{{ $tableCounter }}</td>
                        <td>{{ $record->userName }}</td>
                        <td>{{ $record->devicesName }}</td>
                        <td>{{ $record->code }}</td>
                        <td>{{ $record->allocate_date | date(DATE_FORMAT) }}</td>
                        <td>{{ $record->return_date ?  $record->return_date | date(DATE_FORMAT) : ''}}</td>

                        <td>{{ $record->note }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ $editLink }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm btnOpenerModalConfirmModelDelete"
                                   data-form-id="{{ $formId }}"><i class="fa fa-trash-o"></i></a>
                            </div>

                            <!-- Delete Record DU Form -->
                            <form id="{{ $formId }}" action="{{ $deleteLink }}" method="POST"
                                  style="display: none;" class="hidden form-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger" style="display: none;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endif
@push('footer-scripts')
    <script>

        $(function () {
            myDatePicker($("#birthday, #start_date, #end_date"));
        })
    </script>
@endpush