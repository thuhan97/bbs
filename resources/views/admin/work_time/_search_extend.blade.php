<div class="input-group input-group-sm margin-r-5 pull-left" style="width: 600px;">
    <input type="text" name="search" class="mr-1 w-22 form-control" value="{{ $search }}"
           placeholder="Search...">
    {{ Form::select('type', ['' => 'Phân loại'] + \App\Models\WorkTime::TYPE_NAMES, request('type'), ['class'=>'mr-1 w-22 form-control']) }}
    {{ Form::select('year', get_years(), request('year'), ['class'=>'mr-1 w-22 form-control']) }}
    {{ Form::select('month', get_months(), request('month'), ['class'=>'w-22 form-control']) }}

    <input type="hidden" name="user_id" value="{{request('user_id')}}">
    <input type="hidden" name="work_day" value="{{request('work_day')}}">

    <div class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
    </div>
</div>
<a href="{{ $_createLink }}" class="btn btn-sm btn-primary pull-right">
    <i class="fa fa-plus"></i> <span>Thêm mới</span>
</a>
<a href="{{ route('admin::work_times.import') }}" class="btn btn-sm btn-warning pull-right mr-1">
    <i class="fa fa-upload"></i> <span>Nhập dữ liệu từ máy chấm công</span>
</a>