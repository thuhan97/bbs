<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Tên phòng *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $record->name) }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('area') ? ' has-error' : '' }}">
                        <label for="area">Diện tích</label>
                        <input type="text" name="area" class="form-control" value="{{ old('area', $record->area) }}"> ( đơn vị: m2)
                    </div>
                </div>
            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('seats') ? ' has-error' : '' }}">
                        <label for="seats">Số ghế</label>
                        <input type="text" name="seats" class="form-control" value="{{ old('seats', $record->seats) }}">
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <!-- /.col-md-12 -->
         <div class="col-md-12">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('equipment') ? ' has-error' : '' }}">
                    <label for="equipment">Trang thiết bị</label>
                    <textarea  name="equipment" class="form-control">{{ old('equipment', $record->equipment) }}</textarea>
                <!-- /.form-group -->
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('other') ? ' has-error' : '' }}">
                <label for="other">Ghi chú khác</label>
                <textarea class="form-control" name="other" placeholder="Ghi chú"  >{{ old('other', $record->other) }}</textarea>
            </div>
            <!-- /.form-group -->
        </div>

    </div>
</div>
<!-- /.col-md-5 -->