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
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('introduction') ? ' has-error' : '' }}">
                <label for="introduction">Tóm tắt *</label>
                <textarea class="form-control" name="introduction" id="introduction"
                          placeholder="Nhập tóm tắt">{{ old('introduction', $record->introduction) }}</textarea>

                @if ($errors->has('introduction'))
                    <span class="help-block">
                    <strong>{{ $errors->first('introduction') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
    </div>
</div>
<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('author_name') ? ' has-error' : '' }}">
                <label for="author_name">Người đăng</label>
                <input type="text" class="form-control" name="author_name" placeholder="Nhập tên"
                       value="{{ old('author_name', $record->author_name ?? \App\Facades\AuthAdmin::user()->name) }}">

                @if ($errors->has('author_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('author_name') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="notify_date">Hẹn gửi thông báo</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" autocomplete="off"
                           name="notify_date"
                           value="{{ old('notify_date', $record->notify_date) }}" id="notify_date">
                </div>
                @if ($errors->has('notify_date'))
                    <span class="help-block">
                    <strong>{{ $errors->first('notify_date') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="row">
        <!-- /.col-md-12 -->
        <div class="col-xs-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="status">
                    <input type="checkbox" class="square-blue" name="status" id="status"
                           value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 1) == 1 ? 'checked' : '' }}>
                    Kích hoạt
                </label>
            </div>
            <!-- /.form-group -->
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-7">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('image_url') ? ' has-error' : '' }}">
                <label for="image_url">Ảnh *</label>
                <div class="input-group">
                    <input id="image_url" class="form-control" type="text" name="image_url"
                           value="{{ old('image_url', $record->image_url) }}">
                    <span class="input-group-btn">
                     <a id="lfm" data-input="image_url" data-preview="thumbnail" class="btn btn-primary">
                       <i class="fa fa-picture-o"></i> Choose
                     </a>
                   </span>
                </div>

                @if ($errors->has('image_url'))
                    <span class="help-block">
                    <strong>{{ $errors->first('image_url') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-5">
            <img id="thumbnail" style="margin-top:15px;max-height:100px;" src="{{$record->image_url}}">
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

<div class="col-md-12">
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('tags') ? ' has-error' : '' }}">
        <label for="tags">Tags</label>
        <input type="text" class="form-control" name="tags" placeholder="Tags" id="txtTag"
               value="{{ old('tags', $record->tags) }}">

        @if ($errors->has('tags'))
            <span class="help-block">
                    <strong>{{ $errors->first('tags') }}</strong>
                </span>
        @endif
    </div>
    <!-- /.form-group -->
</div>
<!-- /.form-group -->

<!-- /.col-md-7 -->
@push('footer-scripts')
    <link rel="stylesheet" href="{{ cdn_asset('/css/bootstrap-tagsinput.css') }}"/>
    <script src="{{cdn_asset('/js/admin/bootstrap-tagsinput.js')}}"></script>

    <script>
        $(function () {
            $("#txtTag").tagsinput('items');
            myFilemanager($('#lfm'), 'image');
            myDateTimePicker($("#notify_date"));
            myEditor($("#content"));
        })
    </script>
@endpush