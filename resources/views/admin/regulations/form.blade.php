<div class="col-md-7">
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
</div>
<div class="col-md-7">
    <div class="form-group margin-b-5 margin-t-5">
        <label for="status">
            <input type="checkbox" class="square-blue" name="status" id="status"
                   value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 1) == 1 ? 'checked' : '' }}>
            Kích hoạt
        </label>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('content') ? ' has-error' : '' }}">
        <label for="content">Nội dung chi tiết *</label>
        <textarea class="form-control" name="content" id="content"
                  placeholder="content">{{ old('content', $record->content) }}</textarea>

        @if ($errors->has('content'))
            <span class="help-block">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
        @endif
    </div>
</div>

<!-- /.form-group -->

<!-- /.col-md-7 -->
@push('footer-scripts')
    <script>
        $(function () {
            myEditor($("#content"));
        })
    </script>
@endpush