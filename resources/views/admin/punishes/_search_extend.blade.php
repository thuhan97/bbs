<div class="input-group input-group-sm margin-r-5 pull-left" style="width: 500px;">
    <input type="text" name="search" class="mr-1 w-22 form-control" value="{{ $search }}"
           placeholder="Search...">
    {{ Form::select('year', get_years(), request('year'), ['class'=>'mr-1 w-22 form-control']) }}
    {{ Form::select('month', get_months(), request('month'), ['class'=>'mr-1 w-22 form-control']) }}
    {{ Form::select('is_submit', ['' => 'Trạng thái'] + PUNISH_SUBMIT_NAME, request('is_submit'), ['class'=>'w-22 form-control']) }}

    <div class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
    </div>
</div>
<a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right">
    <i class="fa fa-plus"></i> <span>Thêm mới</span>
</a>