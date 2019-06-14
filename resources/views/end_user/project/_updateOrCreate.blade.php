<div class="row">
    <div class="col-md-6">
        <div class="md-form margin-b-5 {{ $errors->has('name') ? ' has-error' : '' }}">
            <input type="text" class="form-control" name="name" id="name-project"
                   value="{{ old('name', $record->name) }}" required>
            <label for="name">Tên dự án *</label>
            @if ($errors->has('name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
            <span class="text-danger">
                    <strong id="error-name"></strong>
                </span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="md-form {{ $errors->has('customer') ? ' has-error' : '' }}">
            <label for="customer">Tên khách hàng *</label>
            <input type="text" class="form-control" name="customer"
                   value="{{ old('customer', $record->customer) }}" required>

            @if ($errors->has('customer'))
                <span class="text-danger">
                                <strong>{{ $errors->first('customer') }}</strong>
                            </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="md-form{{ $errors->has('start_date') ? ' has-error' : '' }}">
            <i class="fa fa-calendar prefix"></i>
            <input type="text" class="form-control"
                   name="start_date" value="{{ old('start_date', $record->start_date) }}"
                   id="start_date">
            <label for="start_date">Ngày bắt đầu *</label>
            @if ($errors->has('start_date'))
                <span class="text-danger">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
            @endif
        </div>
        <!-- /.form-group -->
    </div>
    <div class="col-md-3">
        <div class="md-form{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <i class="fa fa-calendar prefix"></i>
            <input type="text" class="form-control pull-right" id="end_date"
                   name="end_date"
                   value="{{ old('end_date', $record->end_date) }}" id="end_date">
            <label for="end_date">Ngày kết thúc </label>
            @if ($errors->has('end_date'))
                <span class="text-danger">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="md-form{{ $errors->has('scale') ? ' has-error' : '' }}">
            <label for="scale">Quy mô dự án (người/tháng)</label>
            <input id="scale" type="number" class="form-control" name="scale"
                   value="{{ old('scale', $record->scale) }}" step=0.1>

            @if ($errors->has('scale'))
                <span class="text-danger">
                                <strong>{{ $errors->first('scale') }}</strong>
                            </span>
            @endif
        </div>

    </div>
    <div class="col-md-3">

        <div class="md-form {{ $errors->has('amount_of_time') ? ' has-error' : '' }}">
            <label for="amount_of_time">Thời gian (tháng)</label>
            <input id="amount_of_time" class="form-control" name="amount_of_time"
                   type="number"
                   value="{{ old('amount_of_time', $record->amount_of_time) }}">

            @if ($errors->has('amount_of_time'))
                <span class="text-danger">
                                <strong>{{ $errors->first('amount_of_time') }}</strong>
                            </span>
            @endif
        </div>
    </div>
</div>


<div class="row">
    <!-- /.form-group -->
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('image_url') ? ' has-error' : '' }}">
            <div class="input-group">
                <input id="image_url" class="form-control" type="text" name="image_url"
                       value="{{ old('image_url', $record->image_url) }}">
                <span class="input-group-btn">
                     <a href="#" for="image_url" class="btn btn-primary" id="btnChoose">
                       <i class="fa fa-picture-o"></i> Chọn ảnh
                     </a>
                              <input type="file" accept="image/*" name="image_upload" class="hidden">
                   </span>
            </div>
            @if ($errors->has('image_url'))
                <span class="text-danger">
                    <strong>{{ $errors->first('image_url') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('status') ? ' has-error' : '' }}">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="status-0" name="status"
                       @if(old('stattus', $record->status ?? 0) == 0) checked @endif
                       value="0">
                <label class="form-check-label" for="status-0">Chưa bắt đầu</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="status-1" name="status"
                       @if(old('stattus', $record->status) == 1) checked @endif
                       value="1">
                <label class="form-check-label" for="status-1">Đang phát triển</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="status-2" name="status"
                       @if(old('stattus', $record->status) == 2) checked @endif
                       value="2">
                <label class="form-check-label" for="status-2">Đã kết thúc</label>
            </div>
            @if ($errors->has('status'))
                <span class="text-danger">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
            @endif

        </div>

    </div>
</div>
@if($record->id)
<div class="card my-3">
    <div class="card-body">
        <div id="table" class="table-editable">
            <span><h5 class="text-center mb-0">Thành viên trong dự án</h5></span>
            <div class="float-right">
                <a href="#" onclick=""
                   class="mt-0 btn-floating btn-lg aqua waves-effect waves-light text-white"
                   title="Tạo dự án">
                    <i id="btn-add" class="fas fa-plus"></i>
                </a>
            </div>
            <table class="table table-bordered table-responsive-md table-striped text-center">
                <tr>
                    <th class="text-center center-td" rowspan="2">Tên</th>
                    <th class="text-center center-td" rowspan="2">Vai trò</th>
                    <th class="text-center" colspan="2">Công số</th>
                    <th class="text-center" colspan="2">Thời gian</th>
                    <th class="text-center center-td" rowspan="2">Thao tác</th>
                </tr>
                <tr>
                    <th class="text-center">Hợp đồng</th>
                    <th class="text-center">Thực tế</th>
                    <th class="text-center">Bắt đầu</th>
                    <th class="text-center">Kết thúc</th>
                </tr>
                <tbody id="append">
                @foreach($record->projectMembers as $projectMember)
                <tr>
                    <td class="pt-3-half pb-0"  >
                        {{ Form::select('user_id[]', $results, $projectMember->user_id , ['class'=>'select-user custom-select-table browser-default custom-select custom-select-lg mb-3','required']) }}
                        </td>
                    <td class="pt-3-half pb-0"  >
                        {{ Form::select('mission[]', MISSION_PROJECT, $projectMember->mission , ['class'=>'custom-select-table browser-default custom-select custom-select-lg mb-3','required']) }}
                    </td>
                    <td class="pt-3-half pb-0"  ><input name="contract[]" class="form-control fix-with-table" type="text" value="{{ $projectMember->contract }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" ></td>
                    <td class="pt-3-half pb-0"  ><input name="reality[]" class="form-control fix-with-table" type="text" value="{{ $projectMember->reality }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
                    <td class="pt-3-half pb-0"  ><input readonly="readonly" name="time_start[]" class="form-control fix-with-table time-start" value="{{ $projectMember->time_start }}"type="text"></td>
                    <td class="pt-3-half pb-0"  ><input readonly="readonly" name="time_end[]" class="form-control fix-with-table time-end"  value="{{ $projectMember->time_end }}"type="text"></td>
                    <td>
                        <span class="table-remove"><button type="button" class="fix-with-remove btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                    </td>
                </tr>
                @endforeach
                <!-- This is our clonable table line -->
                </tbody>

            </table>
        </div>
    </div>
</div>
@else
    <div class="card my-3">
        <div class="card-body">
            <div id="table" class="table-editable">
                <span><h4 class="mb-0 text-center">Thành viên trong dự án</h4></span>
                <div class="float-right">
                    <a href="#" onclick=""
                       class="mt-0 btn-floating btn-lg aqua waves-effect waves-light text-white"
                       title="Tạo dự án">
                        <i id="btn-add" class="fas fa-plus"></i>
                    </a>
                </div>
                <table class="table table-bordered table-responsive-md table-striped text-center">
                    <tr>
                        <th class="text-center center-td" rowspan="2">Tên</th>
                        <th class="text-center center-td" rowspan="2">Vai trò</th>
                        <th class="text-center" colspan="2">Công số</th>
                        <th class="text-center" colspan="2">Thời gian</th>
                        <th class="text-center center-td" rowspan="2">Thao tác</th>
                    </tr>
                    <tr>
                        <th class="text-center">Hợp đồng</th>
                        <th class="text-center">Thực tế</th>
                        <th class="text-center">Bắt đầu</th>
                        <th class="text-center">Kết thúc</th>
                    </tr>
                    <tbody id="append">
                    <tr>
                        <td class="pt-3-half pb-0"  >
                            {{ Form::select('user_id[]', $results, auth()->id() , ['class'=>'select-user custom-select-table browser-default custom-select custom-select-lg mb-3', 'placeholder'=>'Vui lòng chọn','required']) }}
                        </td>
                        <td class="pt-3-half pb-0"  >
                            {{ Form::select('mission[]', MISSION_PROJECT, null , ['class'=>'custom-select-table browser-default custom-select custom-select-lg mb-3', 'placeholder'=>'Vui lòng chọn','required']) }}
                        </td>
                        <td class="pt-3-half pb-0"  ><input name="contract[]" class="form-control fix-with-table" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" ></td>
                        <td class="pt-3-half pb-0"  ><input name="reality[]" class="form-control fix-with-table" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" ></td>
                        <td class="pt-3-half pb-0"  ><input readonly="readonly" name="time_start[]" class="form-control fix-with-table time-start" type="text"></td>
                        <td class="pt-3-half pb-0"  ><input readonly="readonly" name="time_end[]" class="form-control fix-with-table time-end" type="text"></td>
                        <td>
                            <span class="table-remove"><button type="button" class="fix-with-remove btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>
                        </td>
                    </tr>
                        <!-- This is our clonable table line -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

<div class="row">
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('technical') ? ' has-error' : '' }}">
            <label for="technical">Kỹ thuật</label>
            <textarea id="technical" class="md-textarea form-control" name="technical"
                      rows="5"
            >{{ old('technical', $record->technical) }}</textarea>

            @if ($errors->has('technical'))
                <span class="text-danger">
                                <strong>{{ $errors->first('technical') }}</strong>
                            </span>
            @endif
        </div>
        <!-- /.form-group -->
    </div>
    <div class="col-md-6">
        <div class="md-form{{ $errors->has('tools') ? ' has-error' : '' }}">
            <label for="tools">Công cụ sử dụng</label>
            <textarea id="tools" class="md-textarea form-control" name="tools"
                      rows="5">{{ old('tools', $record->tools) }}</textarea>

            @if ($errors->has('tools'))
                <span class="text-danger">
                                <strong>{{ $errors->first('tools') }}</strong>
                            </span>
            @endif
        </div>
    </div>

</div>
<div class="md-form{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description">Mô tả</label>
    <textarea required id="description" class="md-textarea form-control" name="description"
              rows="5">{{ old('description', $record->description) }}</textarea>

    @if ($errors->has('description'))
        <span class="text-danger">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
    @endif
</div>

@push('extend-css')
    <link href="{{ asset_ver('bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('extend-js')
    <script src="{{ asset_ver('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush
@push('footer-scripts')
    <script>
        $(function () {
            $('#start_date , .time-end, .time-start, #end_date').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
            $("#btnChoose").click(function () {
                $(this).next().click();
            });
        });
    </script>
@endpush
@push('extend-css')
    <link href="{{asset_ver('bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset_ver('css/meeting.css')}}">
@endpush
@push('extend-js')
    <script type="text/javascript" src="{{asset_ver('mdb/js/bootstrap.js')}}"></script>
    <script src="{{asset_ver('bootstrap-select/js/bootstrap-select.js')}}" type="text/javascript"></script>
    <script src="{{ asset_ver('js/jquery.validate.min.js') }}"></script>
@endpush
<script>
    $(document).ready(function () {
        var html = '';
        <!-- This is our clonable table line -->
        html += '<tr>';
        html += '<td class="pt-3-half pb-0"  >'
        html += '{{ Form::select('user_id[]', $results, null , ['class'=>'select-user custom-select-table browser-default custom-select custom-select-lg mb-3', 'placeholder'=>'Vui lòng chọn','required']) }}'
        html += '</td>'
        html += '<td class="pt-3-half pb-0"  >'
        html += '{{ Form::select('mission[]', MISSION_PROJECT, null , ['class'=>'custom-select-table browser-default custom-select custom-select-lg mb-3', 'placeholder'=>'Vui lòng chọn','required']) }}'
        html += '</td>'
        html += '<td class="pt-3-half pb-0"  ><input name="contract[]" class="fix-with-table form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\'); this.value = this.value.replace(/(\\..*)\\./g, \'$1\');" ></td>'
        html += '<td class="pt-3-half pb-0"  ><input name="reality[]" class="fix-with-table form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\'); this.value = this.value.replace(/(\\..*)\\./g, \'$1\');" ></td>'
        html += '<td class="pt-3-half pb-0"  ><input readonly="readonly" name="time_start[]" class="fix-with-table form-control time-start" type="text"></td>'
        html += '<td class="pt-3-half pb-0"  ><input readonly="readonly" name="time_end[]" class="fix-with-table form-control time-end" type="text"></td>'
        html += '<td>'
        html += '<span class="table-remove"><button type="button" class="fix-with-remove btn btn-danger btn-rounded btn-sm my-0">Remove</button></span>'
        html += '</td>'

        $('#btn-add').on('click', function () {
            $('#append').append(html)
            $('.time-end, .time-start').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true
            });
        })
        const $tableID = $('#table');
        $tableID.on('click', '.table-remove', function () {
            $(this).parents('tr').detach();
        });
$('#name-project').on('change',function () {
    var id ='{{ $record->id }}';
    var name=$(this).val();
    $.ajax
    ({
        'url': '{{ route('project_unique') }}' + '/' + name+ '/' + id,
        'type': 'get',
        success: function (data) {
            if (data.success){
                $('#error-name').text('Tên dự án phải là duy nhất');
                $('.btn-send').attr('disabled',true);
            }else {
                $('#error-name').text(' ');
                $('.btn-send').removeAttr('disabled');
            }
        }
    });
})

    })
</script>