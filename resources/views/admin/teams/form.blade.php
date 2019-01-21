
<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Tên nhóm *</label>
                        <input type="text" class="form-control" name="name" placeholder="Tên nhóm"
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
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('leader_id') ? ' has-error' : '' }}">
                        <label for="leader_id">Trưởng nhóm *</label>
{{--                        {{ Form::select('leader_id',$record->getUsersAttribute(), $record->leader_id ?? 0, ['class'=>'form-control']) }}--}}

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
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('id_card') ? ' has-error' : '' }}">
                        <label for="id_card">Khẩu hiệu</label>
                        <input type="text" class="form-control" name="id_card" placeholder="Khẩu hiệu"
                               value="{{ old('banner', $record->banner) }}">

                        @if ($errors->has('banner'))
                            <span class="help-block">
                    <strong>{{ $errors->first('banner') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>

    </div>
</div>
