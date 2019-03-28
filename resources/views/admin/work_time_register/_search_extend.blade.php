<div class="input-group input-group-sm margin-r-5 pull-left" style="width: 600px;">
    <input type="text" name="search" class="mr-1 w-22 form-control" value="{{ $search }}"
           placeholder="Search...">
    {{ Form::select('jobtitle', ['' => 'Chức vụ'] + JOB_TITLES, request('jobtitle'), ['class'=>'mr-1 w-22 form-control']) }}
    {{ Form::select('position', ['' => 'Chức danh'] + POSITIONS, request('position'), ['class'=>'mr-1 w-22 form-control']) }}
    {{ Form::select('contract_type', ['' => 'Loại hợp đồng'] + CONTRACT_TYPES_NAME, request('contract_type'), ['class'=>'mr-1 w-22 form-control']) }}

    <div class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
    </div>
</div>
{{--<a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right">--}}
    {{--<i class="fa fa-plus"></i> <span>Thêm mới</span>--}}
{{--</a>--}}
