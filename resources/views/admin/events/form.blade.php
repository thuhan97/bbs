<div class="col-md-6">
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
    </div>


    <div class="row">
        <div class="col-md-12">
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <img id="thumbnail" style="margin-top:15px;max-height:100px;" src="{{$record->image_url}}">
        </div>
    </div>
    <!-- /.form-group -->


</div>
<div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <div class="row">


                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('event_date') ? ' has-error' : '' }}">
                        <label for="event_date">Ngày bắt đầu *</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker" autocomplete="off"
                                   name="event_date"
                                   value="{{ old('event_date', $record->event_date) }}" id="event_date">
                        </div>
                        @if ($errors->has('event_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('event_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('event_end_date') ? ' has-error' : '' }}">
                        <label for="event_end_date">Ngày kết thúc</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker"
                                   name="event_end_date" autocomplete="off"
                                   value="{{ old('event_end_date', $record->event_end_date) }}" id="event_end_date">
                        </div>
                        @if ($errors->has('event_end_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('event_end_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('deadline_at') ? ' has-error' : '' }}">
                        <label for="deadline_at">Ngày hết hạn đăng kí *</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker" autocomplete="off"
                                   name="deadline_at"
                                   value="{{ old('deadline_at', $record->deadline_at) }}" id="deadline_at">
                        </div>
                        @if ($errors->has('deadline_at'))
                            <span class="help-block">
                                <strong>{{ $errors->first('deadline_at') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('notify_date') ? ' has-error' : '' }}">
                        <label for="notify_date">Ngày gửi thông báo *</label>
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
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('place') ? ' has-error' : '' }}">
                <label for="place">Địa chỉ</label>
                <input type="text" class="form-control" name="place" placeholder="Địa chỉ"
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
    </div>
</div>

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

    <div class="form-group margin-b-5 margin-t-5">
        <label for="status">
            <input type="checkbox" class="square-blue" name="status" id="status"
                   value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 1) == 1 ? 'checked' : '' }}>
            Kích hoạt
        </label>
    </div>

    <div class="form-group margin-b-5 margin-t-5">
        <label for="has_notify">
            <input type="checkbox" class="square-blue" name="has_notify" id="has_notify"
                   value="{{ACTIVE_NOTIFY}}" {{ old('has_notify', $record->has_notify ?? 1) == 1 ? 'checked' : '' }}>
            Gửi thông báo
        </label>
    </div>

    <!-- /.form-group -->

</div>

<!-- /.col-md-7 -->
@push('footer-scripts')
    <script>

        $(function () {
            myFilemanager($('#lfm'), 'image');
            myEditor($("#content"));
            myDatePicker($("#event_date, #event_end_date"));
            myDateTimePicker($("#notify_date, #deadline_at"));
        })
    </script>
@endpush
