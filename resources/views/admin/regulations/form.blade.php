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
    <div class="row">
        <div class="col-md-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('approve_date') ? ' has-error' : '' }}">
                <label for="approve_date">Ngày hiệu lực</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" autocomplete="off"
                           name="approve_date"
                           value="{{ old('approve_date', $record->approve_date) }}" id="approve_date">
                </div>
                @if ($errors->has('approve_date'))
                    <span class="help-block">
                                <strong>{{ $errors->first('approve_date') }}</strong>
                            </span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('order') ? ' has-error' : '' }}">
                <label for="approve_date">Thứ tự ưu tiên</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-sort"></i>
                    </div>
                    <input type="number" class="form-control pull-right" autocomplete="off"
                           name="order"
                           value="{{ old('order', $record->order) }}" id="order">
                </div>
                @if ($errors->has('order'))
                    <span class="help-block">
                                <strong>{{ $errors->first('order') }}</strong>
                            </span>
                @endif
            </div>
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
    <div class="row">
        <div class="col-md-5">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="image_url">Tải file lên</label>
                <div class="input-group">
                    <input id="file_path" class="form-control" type="text" name="file_path"
                           value="{{ old('file_path', $record->file_path) }}">
                    <span class="input-group-btn">

       <a id="lfm" data-input="file_path" class="btn btn-primary">
         <i class="fa fa-file-o"></i> Choose
       </a>
     </span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.form-group -->
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
            myFilemanager($('#lfm'));
            myEditor($("#content"));
            myDatePicker($("#approve_date"));
            $(document).on("click", ".removeFile", function () {
                $(this).closest('tr').remove();
            });
        })
    </script>
@endpush
