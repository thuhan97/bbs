<div class="col-md-7">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Tên sự kiện *</label>
                <input type="text" class="form-control" name="name" placeholder="Nhập tên sự kiện"
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
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('event_date') ? ' has-error' : '' }}">
                <label for="event_date">Ngày diễn ra</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right datepicker"
                           name="event_date"
                           value="{{ old('event_date', $record->event_date) }}" id="event_date">
                </div>
                @if ($errors->has('event_date'))
                    <span class="help-block">
                    <strong>{{ $errors->first('event_date') }}</strong>
                </span>
            @endif
            <!-- /.input group -->
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('place') ? ' has-error' : '' }}">
                <label for="place">Địa chỉ</label>
                <input type="text" class="form-control" name="place" placeholder="Place"
                       value="{{ old('place', $record->place) }}">

                @if ($errors->has('place'))
                    <span class="help-block">
                    <strong>{{ $errors->first('place') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
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
                <label for="image_url">Ảnh sự kiện *</label>
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
    <!-- /.form-group -->
</div>

<!-- /.col-md-7 -->
@push('footer-scripts')
    <script>

        $(function () {
            myFilemanager($('#lfm'), 'image');
            myEditor($("#content"));
            myDatePicker($("#event_date"));
        })
    </script>
@endpush