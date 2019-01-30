
<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
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
        <div class="col-md-6"></div>


            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('leader_id') ? ' has-error' : '' }}">
                        <label for="leader_id">Trưởng nhóm *</label>
                        @if(isset($record->leader_id))
                            {{ Form::select('leader_id',$record->user->where('jobtitle_id',2)->pluck('name','id') , $record->leader_id ?? '', ['class' => 'form-control']) }}

                        @else
                            {{ Form::select('leader_id',$record->getMemberNotInTeam()->pluck('name','id'),$record->leader_id ?? '', ['class' => 'form-control']) }}

                        @endif

                        @if ($errors->has('leader_id'))
                            <span class="help-block">
                    <strong>{{ $errors->first('leader_id') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->


        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
                    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('banner') ? ' has-error' : '' }}">
                        <label for="banner">Biểu ngữ</label>
                        <input type="text" class="form-control" name="banner" placeholder="Biểu ngữ" value="{{ old('banner', $record->banner) }}"
                                  >

                        @if ($errors->has('banner'))
                            <span class="help-block">
                    <strong>{{ $errors->first('banner') }}</strong>
                </span>
                        @endif
                    </div>
                    <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('slogan') ? ' has-error' : '' }}">
                <label for="slogan">Khẩu hiệu</label>
                <input type="text" class="form-control" name="slogan" placeholder="Khẩu hiệu" value="{{ old('slogan', $record->slogan) }}"
                >

                @if ($errors->has('slogan'))
                    <span class="help-block">
                    <strong>{{ $errors->first('slogan') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description">Miêu tả</label>
                    <textarea type="text" class="form-control" name="description" placeholder="Miêu tả"
                              >{{ old('description', $record->description) }}</textarea>

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
