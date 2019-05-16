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
        <div class="col-md-4">

                <div class="form-group margin-b-5 margin-t-5{{ $errors->has('manager_id') ? ' has-error' : '' }}">
                    <label for="group_id">Người quản lý *</label>
                    {{ Form::select('manager_id', ['' => 'Chọn người quản lí'] + users(true), $record->manager_id ?? '', ['class' => 'form-control']) }}

                    @if ($errors->has('manager_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('manager_id') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-md-8">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="approve_comment">Mô tả</label>
                <textarea class="form-control" name="description" id="approve_comment" rows="3"
                          placeholder="Mô tả">{{ old('description',$record->description) }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
</div>

