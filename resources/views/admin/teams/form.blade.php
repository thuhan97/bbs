<div class="col-md-9">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Tên nhóm *</label>
                <input type="text" class="form-control" name="name" placeholder="Tên nhóm"
                       value="{!! old('name', $record->name) !!} " required>

                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>

        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('group_id') ? ' has-error' : '' }}">
                <label for="group_id">Group</label>
                {{ Form::select('group_id', ['' => 'Chọn group'] + GROUPS, $record->group_id ?? '', ['class' => 'form-control']) }}

                @if ($errors->has('group_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('group_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('leader_id') ? ' has-error' : '' }}">
                <label for="leader_id">Trưởng nhóm *</label>
                {{ Form::select('leader_id', $record->getMemberNotInTeam($record->leader_id ?? '')->pluck('name','id') , $record->leader_id ?? '', ['class' => 'form-control']) }}

                @if ($errors->has('leader_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('leader_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <!-- /.col-md-12 -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('banner') ? ' has-error' : '' }}">
                <label for="banner">Ảnh đại diện</label>
                <div class="input-group">
                    <input id="banner" class="form-control" type="text" name="banner"
                           value="{{ old('banner', $record->banner) }}">
                    <span class="input-group-btn">
                     <a id="lfm" data-input="banner" data-preview="thumbnail" class="btn btn-primary">
                       <i class="fa fa-picture-o"></i> Choose
                     </a>
                   </span>
                </div>

                @if ($errors->has('banner'))
                    <span class="help-block">
                    <strong>{{ $errors->first('banner') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-5">
            <img id="thumbnail" style="margin-top:15px;max-height:100px;" src="{{$record->banner}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('slogan') ? ' has-error' : '' }}">
                <label for="slogan">Khẩu hiệu</label>
                <input type="text" class="form-control" name="slogan" placeholder="Khẩu hiệu"
                       value="{{ old('slogan', $record->slogan) }}">

                @if ($errors->has('slogan'))
                    <span class="help-block">

                    <strong>{{ $errors->first('slogan') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-2">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('color') ? ' has-error' : '' }}">
                <label for="color">Màu truyền thống</label>
                <input type="color" class="form-control w-50" name="color" placeholder="Chọn màu"
                       value="{{ old('color', $record->color) }}">

                @if ($errors->has('color'))
                    <span class="help-block">

                    <strong>{{ $errors->first('color') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>

    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description">Miêu tả</label>
                <textarea id="description" class="form-control" name="description" rows="5"
                          placeholder="Mô tả">{{ old('description', $record->description) }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->

        </div>
        <!-- /.form-group -->
    </div>
</div>

@push('footer-scripts')
    <script>
        $(function () {
            myFilemanager($('#lfm'), 'image');
            myEditor($("#description"));
        })
        $('.option-with').addClass('col-xs-6');
    </script>
@endpush
