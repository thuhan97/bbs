<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('types_device_id') ? ' has-error' : '' }}">
                        <label for="types_device_id">Chủng loại *</label>
                        {{ Form::select('types_device_id', TYPES_DEVICE, $record->types_device_id ?? 0, ['class'=>'form-control']) }}
                        {{--<input type="text" class="form-control" name="types_device_id" placeholder="Nhập chủng loại"--}}
                               {{--value="{{ old('types_device_id', $record->types_device_id ) }}" required>--}}

                        @if ($errors->has('types_device_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('types_device_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Tên thiết bị *</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập Tên"
                               value="{{ old('name', $record->name ) }}" required>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
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
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('quantity_inventory') ? ' has-error' : '' }}">
                        <label for="quantity_inventory">Số lượng tồn</label>
                        <input type="number" class="form-control" name="quantity_inventory" id="quantity_inventory" placeholder="Số lượng tồn"
                               value="{{ old('quantity_inventory', $record->quantity_inventory) }}" min="0">

                        @if ($errors->has('quantity_inventory'))
                            <span class="help-block">
                    <strong>{{ $errors->first('quantity_inventory') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('quantity_used') ? ' has-error' : '' }}">
                        <label for="quantity_used">Số lượng đang sử dụng</label>
                        <input type="number" class="form-control pull-right datepicker"
                               name="quantity_used"
                               value="{{ old('quantity_used', $record->quantity_used) }}" id="quantity_used" placeholder="Số lượng đang sử dụng" min="0">

                        @if ($errors->has('quantity_used'))
                            <span class="help-block">
                    <strong>{{ $errors->first('quantity_used') }}</strong>
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
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('month_of_use') ? ' has-error' : '' }}">
                        <label for="month_of_use">Sử dụng trong tháng</label>
                        <input type="number" class="form-control" name="month_of_use" id="month_of_use" placeholder="Sử dụng trong tháng"
                               value="{{ old('month_of_use', $record->month_of_use) }}" min="0">

                        @if ($errors->has('month_of_use'))
                            <span class="help-block">
                    <strong>{{ $errors->first('month_of_use') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('id_addr') ? ' has-error' : '' }}">
                        <label for="quantity_unused">Số lượng chưa sử dụng</label>
                        <input type="number" class="form-control" name="quantity_unused" id="quantity_unused" placeholder="Số lượng chưa sử dụng"
                               value="{{ old('quantity_unused', $record->quantity_unused) }}" min="0">

                        @if ($errors->has('quantity_unused'))
                            <span class="help-block">
                    <strong>{{ $errors->first('quantity_unused') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('final') ? ' has-error' : '' }}">
                        <label for="final">Tồn cuối</label>
                        <input type="number" class="form-control" name="final" placeholder="Tồn cuối" id="final" readonly
                               value="{{ old('email', $record->final) }}">

                        @if ($errors->has('final'))
                            <span class="help-block">
                    <strong>{{ $errors->first('final') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('note') ? ' has-error' : '' }}">
                <label for="note">Ghi chú</label>
                <textarea class="form-control" name="note" placeholder="Ghi chú" id="note" > {{ old('note', $record->note) }}</textarea>

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
            $('#quantity_inventory, #quantity_used, #month_of_use, #quantity_unused').change(function () {
                if ($(this).val() < 0) {
                    $(this).val(0);
                }
                let final = parseInt($('#quantity_inventory').val(), 10) + parseInt($('#quantity_used').val(), 10) + parseInt($('#quantity_unused').val(), 10) - parseInt($('#month_of_use').val(), 10);
                console.log(final);
                if (final) {
                    $('#final').val(final)
                } else {
                    $('#final').val(0)
                }
            })
        })
    </script>
@endpush