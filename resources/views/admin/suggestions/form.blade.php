<?php
$users = \App\Models\User::all()->pluck('name', 'id');
$manager = \App\Models\User::where('jobtitle_id', '>', TEAMLEADER_ROLE)->pluck('name', 'id');
?>
<div class="col-md-12">
<div class="row">
<div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('creator_id') ? ' has-error' : '' }}">
                <label for="creator_id">Người góp ý *</label>
                {{ Form::select('creator_id', $users, old('creator_id',$record->creator_id), ['class' => 'form-control my-1 mr-1 browser-default custom-select select-item  check-value mt-0 creator_id','placeholder'=>'Chọn người đề xuất - góp ý' ]) }}
                @if ($errors->has('creator_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('creator_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.col-md-12 -->
    </div>

</div>
<div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5{{ $errors->has('isseus_id') ? ' has-error' : '' }}">
                <label for="isseus_id">Người duyệt *</label>
                {{ Form::select('isseus_id', $manager, old('isseus_id',$record->isseus_id), ['class' => 'form-control my-1 mr-1 browser-default custom-select select-item mannager_id check-value mt-0' ,'placeholder'=>'Chọn người thực hiện']) }}
                @if ($errors->has('isseus_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('isseus_id') }}</strong>
                </span>
                @endif
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.col-md-12 -->
    </div>
</div>
</div>
</div>

<div class="col-md-12">
    <div class="row">
<div class="col-md-6">
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('content') ? ' has-error' : '' }}">
        <label for="content">Nội dung đề xuất - góp ý *</label>
        <textarea class="form-control" name="content" id="introduction" rows="3"
                  placeholder="Nhập tóm tắt">{{ old('content', $record->content) }}</textarea>

        @if ($errors->has('content'))
            <span class="help-block">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
        @endif
    </div>
    <!-- /.form-group -->
</div>
<div class="col-md-6">
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('comment') ? ' has-error' : '' }}">
        <label for="comment">Gửi ý kiến phản hồi cho người duyệt </label>
        <textarea class="form-control" name="comment" id="introduction" rows="3"
                  placeholder="Nhập tóm tắt">{{ old('comment', $record->comment) }}</textarea>
        @if ($errors->has('comment'))
            <span class="help-block">
                    <strong>{{ $errors->first('comment') }}</strong>
                </span>
        @endif
    </div>
    <!-- /.form-group -->
</div>
    </div>
</div>
<!-- /.form-group -->
<div class="col-md-6">
    <div class="form-group margin-b-5 margin-t-5">
        <label for="status">
            <input type="checkbox" class="square-blue" name="status" id="status"
                   value="{{ACTIVE_STATUS}}" {{ old('status', $record->status ?? 0) == 1 ? 'checked' : '' }}>
            Đã thực hiện
        </label>
    </div>
</div>
@if($record->creator_id)
    <script>
        $('.creator_id').attr('disabled', true)
    </script>
@endif
<!-- /.col-md-7 -->
