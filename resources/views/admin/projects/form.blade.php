<div class="col-md-10">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Tên dự án *</label>
                        <input type="text" class="form-control" name="name" placeholder="Tên dự án"
                               value="{{ old('name', $record->name) }}" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('customer') ? ' has-error' : '' }}">
                        <label for="customer">Khách hàng *</label>
                        <input type="text" class="form-control" name="customer" placeholder="Tên khách hàng"
                               value="{{ old('customer', $record->customer) }}" required>

                        @if ($errors->has('customer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customer') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('project_type') ? ' has-error' : '' }}">
                        <label for="project_type">Loại dự án</label>
                        {{ Form::select('project_type', PROJECT_TYPE, $record->project_type ?? 0, ['class'=>'form-control']) }}

                        @if ($errors->has('project_type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('project_type') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="status">Trạng thái</label>
                        {{ Form::select('status', STATUS_PROJECT, $record->status ?? 0, ['class'=>'form-control']) }}

                        @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('scale') ? ' has-error' : '' }}">
                        <label for="scale">Quy mô dự án (người/tháng)</label>
                        <input type="number" class="form-control" name="scale" placeholder="Quy mô dự án"
                               value="{{ old('scale', $record->scale) }}">

                        @if ($errors->has('scale'))
                            <span class="help-block">
                                <strong>{{ $errors->first('scale') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>
                <div class="col-md-3">

                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('amount_of_time') ? ' has-error' : '' }}">
                        <label for="amount_of_time">Thời gian (tháng)</label>
                        <input id="amount_of_time" class="form-control" name="amount_of_time" type="number"
                               placeholder="Thời gian" value="{{ old('amount_of_time', $record->amount_of_time) }}">

                        @if ($errors->has('amount_of_time'))
                            <span class="help-block">
                                <strong>{{ $errors->first('amount_of_time') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('leader_id') ? ' has-error' : '' }}">
                        <label for="leader_id">Leader dự án</label>
                        {{ Form::select('leader_id', $record->getLeadersProject()->pluck('name','id') , $record->leader_id ?? '', ['class' => 'form-control']) }}

                        @if ($errors->has('leader_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('leader_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="start_date">Ngày bắt đầu</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" autocomplete="off"
                                   name="start_date"
                                   value="{{ old('start_date', $record->start_date) }}" id="start_date">
                        </div>
                        @if ($errors->has('start_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label for="end_date">Ngày kết thúc </label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" autocomplete="off"
                                   name="end_date"
                                   value="{{ old('end_date', $record->end_date) }}" id="end_date">
                        </div>
                        @if ($errors->has('end_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <!-- /.form-group -->
        <div class="col-md-8">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('image_url') ? ' has-error' : '' }}">
                <label for="image_url">Ảnh dự án</label>
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
        <div class="col-md-4">
            <img id="thumbnail" style="margin-top:15px;max-height:100px;" src="{{$record->image_url}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('technical') ? ' has-error' : '' }}">
                <label for="technical">Kỹ thuật</label>
                <textarea id="technical" class="form-control" name="technical" rows="5"
                          placeholder="Kỹ thuật">{{--{{ old('technical', $record->technical) }}--}}{!! $record->technical !!}</textarea>

                @if ($errors->has('technical'))
                    <span class="help-block">
                                <strong>{{ $errors->first('technical') }}</strong>
                            </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('tools') ? ' has-error' : '' }}">
                <label for="tools">Công cụ sử dụng</label>
                <textarea id="tools" class="form-control" name="tools" rows="5"
                          placeholder="Công cụ sử dụng">{{ old('tools', $record->tools) }}</textarea>

                @if ($errors->has('tools'))
                    <span class="help-block">
                                <strong>{{ $errors->first('tools') }}</strong>
                            </span>
                @endif
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description">Mô tả</label>
                <textarea id="description" class="form-control" name="description" rows="5"
                          placeholder="Miêu tả">{{ old('description', $record->description) }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                @endif
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>
        $(function () {
            myFilemanager($('#lfm'), 'image');
            myEditor($("#description"));
            myDatePicker($("#start_date, #end_date"));
        });
        $('.option-with').addClass('col-xs-6');
    </script>
@endpush
