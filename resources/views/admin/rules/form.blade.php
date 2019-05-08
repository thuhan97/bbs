<div class="col-md-7">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Tên *</label>
                <input type="text" class="form-control" name="name" placeholder="Nhập tên"
                       value="{{ old('name', $record->name) }}" required>

                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('penalize') ? ' has-error' : '' }}">
                <label for="penalize">Tiền phạt *</label>
                <input type="number" class="form-control" name="penalize" id="penalize"
                       placeholder="Nhập tiền phạt" value="{{ old('penalize', $record->penalize) }}" required/>

                @if ($errors->has('penalize'))
                    <span class="help-block">
                    <strong>{{ $errors->first('penalize') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('detail') ? ' has-error' : '' }}">
        <label for="detail">Nội dung chi tiết</label>
        <textarea class="form-control" name="detail" id="detail" rows="10"
                  placeholder="Nhập nội dung chi tiết">{{ old('detail', $record->detail) }}</textarea>

        @if ($errors->has('detail'))
            <span class="help-block">
                    <strong>{{ $errors->first('detail') }}</strong>
                </span>
        @endif
    </div>
</div>
