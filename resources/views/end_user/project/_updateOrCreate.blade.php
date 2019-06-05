<div class="row">
    <div class="col-md-6">
        <div class="md-form margin-b-5 {{ $errors->has('name') ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="name"
                   value="{{ old('name', $record->name) }}" required>
            <label for="name">Tên dự án *</label>
            @if ($errors->has('name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="md-form {{ $errors->has('customer') ? ' has-error' : '' }}">
            <label for="customer">Tên khách hàng *</label>
            <input type="text" class="form-control" name="customer"
                   value="{{ old('customer', $record->customer) }}" required>

            @if ($errors->has('customer'))
                <span class="text-danger">
                                <strong>{{ $errors->first('customer') }}</strong>
                            </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="md-form{{ $errors->has('start_date') ? ' has-error' : '' }}">
            <i class="fa fa-calendar prefix"></i>
            <input type="text" class="form-control"
                   name="start_date" value="{{ old('start_date', $record->start_date) }}"
                   id="start_date">
            <label for="start_date">Ngày bắt đầu *</label>
            @if ($errors->has('start_date'))
                <span class="text-danger">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
            @endif
        </div>
        <!-- /.form-group -->
    </div>
    <div class="col-md-3">
        <div class="md-form{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <i class="fa fa-calendar prefix"></i>
            <input type="text" class="form-control pull-right" id="end_date"
                   name="end_date"
                   value="{{ old('end_date', $record->end_date) }}" id="end_date">
            <label for="end_date">Ngày kết thúc </label>
            @if ($errors->has('end_date'))
                <span class="text-danger">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="md-form{{ $errors->has('scale') ? ' has-error' : '' }}">
            <label for="scale">Quy mô dự án (người/tháng)</label>
            <input id="scale" type="number" class="form-control" name="scale"
                   value="{{ old('scale', $record->scale) }}">

            @if ($errors->has('scale'))
                <span class="text-danger">
                                <strong>{{ $errors->first('scale') }}</strong>
                            </span>
            @endif
        </div>

    </div>
    <div class="col-md-3">

        <div class="md-form {{ $errors->has('amount_of_time') ? ' has-error' : '' }}">
            <label for="amount_of_time">Thời gian (tháng)</label>
            <input id="amount_of_time" class="form-control" name="amount_of_time"
                   type="number"
                   value="{{ old('amount_of_time', $record->amount_of_time) }}">

            @if ($errors->has('amount_of_time'))
                <span class="text-danger">
                                <strong>{{ $errors->first('amount_of_time') }}</strong>
                            </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('status') ? ' has-error' : '' }}">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="status-0" name="status"
                       @if(old('stattus', $record->status ?? 0) == 0) checked @endif
                       value="0">
                <label class="form-check-label" for="status-0">Chưa bắt đầu</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="status-1" name="status"
                       @if(old('stattus', $record->status) == 1) checked @endif
                       value="1">
                <label class="form-check-label" for="status-1">Đang phát triển</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="status-2" name="status"
                       @if(old('stattus', $record->status) == 2) checked @endif
                       value="2">
                <label class="form-check-label" for="status-2">Đã kết thúc</label>
            </div>
            @if ($errors->has('status'))
                <span class="text-danger">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
            @endif

        </div>

    </div>
</div>
<div class="row">
    <!-- /.form-group -->
    <div class="col-md-8">
        <div class="md-form{{ $errors->has('image_url') ? ' has-error' : '' }}">
            <div class="input-group">
                <input id="image_url" class="form-control" type="text" name="image_url"
                       value="{{ old('image_url', $record->image_url) }}">
                <span class="input-group-btn">
                     <a href="#" for="image_url" class="btn btn-primary" id="btnChoose">
                       <i class="fa fa-picture-o"></i> Chọn ảnh
                     </a>
                              <input type="file" accept="image/*" name="image_upload" class="hidden">
                   </span>
            </div>
            @if ($errors->has('image_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('image_url') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <img id="thumbnail" style="margin-top:15px;max-height:100px;"
             src="{{$record->image_url}}">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('technical') ? ' has-error' : '' }}">
            <label for="technical">Kỹ thuật</label>
            <textarea id="technical" class="md-textarea form-control" name="technical"
                      rows="5"
            >{{ old('technical', $record->technical) }}</textarea>

            @if ($errors->has('technical'))
                <span class="text-danger">
                                <strong>{{ $errors->first('technical') }}</strong>
                            </span>
            @endif
        </div>
        <!-- /.form-group -->
    </div>
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('tools') ? ' has-error' : '' }}">
            <label for="tools">Công cụ sử dụng</label>
            <textarea id="tools" class="md-textarea form-control" name="tools"
                      rows="5">{{ old('tools', $record->tools) }}</textarea>

            @if ($errors->has('tools'))
                <span class="text-danger">
                                <strong>{{ $errors->first('tools') }}</strong>
                            </span>
            @endif
        </div>
    </div>

</div>
<div class="md-form{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description">Mô tả</label>
    <textarea id="description" class="md-textarea form-control" name="description"
              rows="5">{{ old('description', $record->description) }}</textarea>

    @if ($errors->has('description'))
        <span class="text-danger">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
    @endif
</div>


@push('extend-css')
    <link href="{{ asset_ver('/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('extend-js')
    <script src="{{ asset_ver('/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush
@push('footer-scripts')
    <script>
        $(function () {
            $('#start_date , #end_date').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
            $("#btnChoose").click(function () {
                $(this).next().click();
            });
        });
    </script>
@endpush
