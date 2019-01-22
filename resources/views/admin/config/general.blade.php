<div class="form-group margin-b-5 margin-t-5{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name">Tên hệ thống *</label>
    <input type="text" class="form-control" name="name" placeholder="BBS System"
           value="{{ old('name', $record->name) }}" required>

    @if ($errors->has('name'))
        <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
    @endif
</div>
<div class="tab-pane active" id="tab_1">
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('acronym_name') ? ' has-error' : '' }}">
        <label for="acronym_name">Tên viết tắt *</label>
        <input type="text" class="form-control" name="acronym_name" placeholder="BBS"
               value="{{ old('acronym_name', $record->acronym_name) }}" required>

        @if ($errors->has('acronym_name'))
            <span class="help-block">
                    <strong>{{ $errors->first('acronym_name') }}</strong>
                </span>
        @endif
    </div>
</div>