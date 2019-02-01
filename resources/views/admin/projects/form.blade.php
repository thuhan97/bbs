<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
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
                <div class="col-md-6"></div>

            </div>

            <!-- /.form-group -->
        </div>
        <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-default btn-file">
                    <div class="input file"><label for="imgInp">Thumbnail</label><input type="file" name="thumbnail" id="imgInp" class="col-xs-offset-2"></div>                                </span>
            </span>
            <input type="text" class="form-control" readonly="" style="height: 39px;">
        </div>
        <span id="errorThumbnail" style="color: red"></span>
        <img id='img-upload' src="{{ URL::asset('/adminlte/img/projects_img/'.$record->image_url) }}"/>
        <div class="col-md-12">
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
                <div class="col-md-6"></div>

            </div>

            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('customer') ? ' has-error' : '' }}">
                        <label for="customer">Khách hàng *</label>
                        <input type="text" class="form-control" name="customer" placeholder="Tên dự án"
                               value="{{ old('customer', $record->customer) }}" required>

                    @if ($errors->has('customer'))
                            <span class="help-block">
                    <strong>{{ $errors->first('customer') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('project_type') ? ' has-error' : '' }}">
                        <label for="project_type">Loại dự án</label>
                        {{ Form::select('project_type', PROJECT_TYPE, $record->project_type ?? 0, ['class'=>'form-control']) }}

                        @if ($errors->has('project_type'))
                            <span class="help-block">
                    <strong>{{ $errors->first('project_type') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('scale') ? ' has-error' : '' }}">
                        <label for="scale">Quy mô dự án</label>
                        <input type="text" class="form-control" name="scale" placeholder="Quy mô dự án"
                               value="{{ old('scale', $record->scale) }}">

                        @if ($errors->has('scale'))
                            <span class="help-block">
                    <strong>{{ $errors->first('scale') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('amount_of_time') ? ' has-error' : '' }}">
                        <label for="amount_of_time">Thời gian</label>
                        <input id="amount_of_time" class="form-control" name="amount_of_time" rows="5"
                                  placeholder="Thời gian" value="{{ old('amount_of_time', $record->amount_of_time) }}">

                        @if ($errors->has('amount_of_time'))
                            <span class="help-block">
                    <strong>{{ $errors->first('amount_of_time') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('technicala') ? ' has-error' : '' }}">
                        <label for="technicala">Kỹ thuật</label>
                        <input id="technicala" class="form-control" name="amount_of_time" rows="5"
                               placeholder="Kỹ thuật" value="{{ old('technicala', $record->technicala) }}">

                        @if ($errors->has('technicala'))
                            <span class="help-block">
                    <strong>{{ $errors->first('technicala') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('tools') ? ' has-error' : '' }}">
                        <label for="tools">Công cụ sử dụng</label>
                        <input id="tools" class="form-control" name="tools" rows="5"
                               placeholder="Công cụ sử dụng" value="{{ old('tools', $record->tools) }}">

                        @if ($errors->has('tools'))
                            <span class="help-block">
                    <strong>{{ $errors->first('tools') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('leader_id') ? ' has-error' : '' }}">
                        <label for="leader_id">Leader dự án</label>
                        <input id="leader_id" class="form-control" name="leader_id" rows="5"
                               placeholder="Leader dự án" value="{{ old('leader_id', $record->leader_id) }}">

                        @if ($errors->has('leader_id'))
                            <span class="help-block">
                    <strong>{{ $errors->first('leader_id') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="start_date">Ngày bắt đầu *</label>
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
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label for="end_date">Ngày kết thúc *</label>
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
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>
        $(function () {
            myEditor($("#description"));
            myDateTimePicker($("#start_date"));
            myDateTimePicker($("#end_date"));
        })
    </script>
@endpush
