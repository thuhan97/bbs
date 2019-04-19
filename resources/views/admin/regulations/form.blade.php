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
    <div class="row">
        <div class="col-md-5">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="image_url">Tải file lên</label>
                <div class="input-group">
                    <input id="file_upload" class="form-control" type="text">
                    <span class="input-group-btn">
       <a id="lfm" data-input="file_upload" data-preview="thumbnail" class="btn btn-primary">
         <i class="fa fa-picture-o"></i> Choose
       </a>
     </span>
                </div>
            </div>
        </div>
        <div class="col-md-7" style="margin-top: 36px">
            <label for="image_url">Danh sách file đính kèm</label>

            <table id="attachTable" class="table table-bordered">
                <tbody>
                @foreach($record->regulation_files as $file)
                    <tr>
                        <td><a href="{{$file->file_path}}">{{$file->file_path}}</a></td>
                        <td class="text-center">
                            <input type="hidden" name="file_path[]" value="{{$file->file_path}}">
                            <a href="#" class="removeFile">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
            $(document).on("click", ".removeFile", function () {
                $(this).closest('tr').remove();
            });
            $("#file_upload").change(function () {
                var $row = '<tr>' +
                    '          <td><a href="' + this.value + '">' + this.value + '</a></td>' +
                    '          <td>' +
                    '               <input type="hidden" name="file_path[]" value="' + this.value + '">' +
                    '               <a href="#" class="removeFile">Xóa</a>' +
                    '          </td>' +
                    '      </tr>';

                $("#attachTable tbody").append($row);
                this.value = null;
            });
        })
    </script>
@endpush