<div class="col-md-3"></div>
<div class="col-md-9">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Tên group *</label>
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

        <div class="col-md-4">


                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('group_id') ? ' has-error' : '' }}">
                    <label for="group_id">Manager *</label>
                    {{ Form::select('group_id', ['' => 'Chọn group'] + GROUPS, $record->group_id ?? '', ['class' => 'form-control']) }}

                    @if ($errors->has('group_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>

        </div>
        <div class="col-md-6"></div>
    </div>
</div>

