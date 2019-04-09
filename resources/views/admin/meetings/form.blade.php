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
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('seats') ? ' has-error' : '' }}">
                        <label for="seats">Số ghế</label>
                        <input type="text" name="seats" class="form-control" value="{{ old('seats', $record->seats) }}">
                        @if ($errors->has('seats'))
                            <span class="help-block">
                                <strong>{{ $errors->first('seats') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-12">
                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Mô tả</label>
                    <textarea  name="description" class="form-control">{{ old('description', $record->description) }}</textarea>
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