@section('_pageSubtitle')
    DS
@endsection
<div class="table-responsive list-records">
    <table id="worktime-table" class="table table-hover table-bordered dataTable">
        <thead>
        <tr>
            <th rowspan="2" style="width: 10px;">
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
            </th>
            <th rowspan="2" class="no-wap" style="width: 130px;">
                Mã nhân viên
                {!! __admin_sortable('staff_code') !!}
            </th>
            <th rowspan="2" style="width: 180px;">
                Họ và tên
                {!! __admin_sortable('name') !!}
            </th>
            <th rowspan="2" style="width: 130px;">Chức vụ
                {!! __admin_sortable('jobtitle_id') !!}
            </th>
            <th rowspan="2" style="width: 130px;">Loại hợp đồng
                {!! __admin_sortable('contract_type') !!}
            </th>
            <th colspan="5" class="text-center">
                Lịch đăng ký
            </th>
            <th rowspan="2" style="width: 150px;">Ngày tạo
                {!! __admin_sortable('created_at') !!}
            </th>
            <th rowspan="2" style="width: 100px;">Chức năng</th>
        </tr>
        <tr>
            <th class="text-center" style="width: 100px">
                Thứ 2
            </th>
            <th class="text-center" style="width: 100px">
                Thứ 3
            </th>
            <th class="text-center" style="width: 100px">
                Thứ 4
            </th>
            <th class="text-center" style="width: 100px">
                Thứ 5
            </th>
            <th class="text-center" style="width: 100px">
                Thứ 6
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($records as $record)
            <?php
            $tableCounter++;
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);
            $showLink = route($resourceRoutesAlias . '.show', $record->id);
            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}" class="square-blue chkDelete"></td>
                <td>
                    @can('update', $record)
                        <a href="{{ $editLink }}">{{ $record->staff_code }}</a>
                    @else
                        {{ $record->staff_code }}
                    @endcan
                </td>
                <td class="table-text">
                    <a href="{{ $showLink }}">{{ $record->name }}</a>
                </td>
                <td>{{ JOB_TITLES[$record->jobtitle_id] ?? '' }}</td>
                <td>{{ CONTRACT_TYPES_NAME[$record->contract_type] ?? '' }}</td>
                @if($record->workTimeRegisters->isNotEmpty())
                    @foreach($record->workTimeRegisters as $time)
                        <?php
                        $text = to_work_time_name($time->start_at, $time->end_at, $type);
                        ?>
                        <td class="text-center bg-type-{{$type}}">{{$text}}</td>
                    @endforeach
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                <td class="text-right">{{ $record->created_at->format('Y-m-d') }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <div class="btn-group">
                        <a href="{{ $editLink }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" class="btn btn-danger btn-sm btnOpenerModalConfirmModelDelete"
                           data-form-id="{{ $formId }}"><i class="fa fa-trash-o"></i></a>
                    </div>

                    <!-- Delete Record Form -->
                    <form id="{{ $formId }}" action="{{ $deleteLink }}" method="POST"
                          style="display: none;" class="hidden form-inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
