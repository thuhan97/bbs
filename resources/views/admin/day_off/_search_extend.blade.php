<div class="input-group input-group-sm margin-r-5 pull-left" style="width: 500px;">
    <input type="text" name="search" class="mr-1 w-30 form-control" value="{{ $search }}"
           placeholder="Search...">
    {{ Form::select('year', get_years(), request('year'), ['class'=>'mr-1 w-30 form-control']) }}
    {{ Form::select('month', get_months(), request('month'), ['class'=>'w-30 form-control']) }}

    <div class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
    </div>
</div>
<div  class="btn btn-sm btn-primary pull-right" id="btn-submit-excel">
    <span>Xuất danh sách</span>
</div>
<a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right mr-1">
    <i class="fa fa-plus"></i> <span>Thêm mới</span>
</a>
