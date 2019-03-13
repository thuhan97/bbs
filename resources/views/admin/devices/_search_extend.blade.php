<div class="input-group input-group-sm margin-r-5 pull-left" style="width: 300px; display: flex;">
    <input type="text" name="search" class="mr-1 w-search-manager form-control" value="{{ $search }}"
           placeholder="Search...">
    {{ Form::select('type', ['' => 'Loại'] + TYPES_DEVICE, request('type'), ['class'=>'mr-1 w-search-manager form-control']) }}

    <div class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
    </div>
</div>
<a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right" style="margin-left:20px;">
    <i class="fa fa-plus"></i> <span>Thêm mới</span>
</a>
