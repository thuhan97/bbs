<div class="col-md-12">
    <div class="row">
        <div class="col-md-4">
            <p><b>Tên nhóm: </b>{{ old('name', $record->name) }}</p>
            <br>
            <p><b>Người quản lý :</b> {{  $record->user->name ?? ''  }}</p>
            <br>
            <p><b>Chức vụ :</b> {{ array_key_exists($record->user->jobtitle_id ?? '' ,JOB_TITLES) ? JOB_TITLES[$record->user->jobtitle_id] : '' }}</p>
        </div>
        <div class="col-md-6">
            <p><b>Mô tả: </b> </p>{!! $record->description !!}
             <textarea class="form-control" name="description" id="approve_comment" rows="4">{{ $record->description }}</textarea>
        </div>
    </div>
</div>

<div class="col-md-7">
    <br/>
    <hr/>
</div>

