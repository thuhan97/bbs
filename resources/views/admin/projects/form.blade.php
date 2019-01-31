<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-3">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('leader_id') ? ' has-error' : '' }}">
                        <label for="leader_id">Trưởng nhóm *</label>

                        {{ Form::select('leader_id', $record->getMemberNotInTeam($record->leader_id ?? null)->pluck('name','id'), $record->leader_id ?? '', ['class' => 'form-control']) }}

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
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('banner') ? ' has-error' : '' }}">
                        <label for="banner">Biểu ngữ</label>
                        <input type="text" class="form-control" name="banner" placeholder="Biểu ngữ"
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

        <div class="col-md-12">
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
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
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
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>
        $(function () {
            myEditor($("#description"));
        })
    </script>
@endpush
