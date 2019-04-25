<div class="text-right">
    <form action="{{ route('admin::over_times.export') }}" method="post">
        @csrf
        @foreach ($records as $record)
            <input type="hidden" name="creator_id" value="{{ $record['creator_id'] }}">
        @endforeach
        <button class="btn btn-primary" id="exportExcel">Xuất file excel</button>
    </form>
</div>
<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>STT</th>
        <th>Người xin</th>
        <th>Ngày xin</th>
        <th>Ghi chú</th>
        <th>Trạng thái</th>
        <th>Người duyệt</th>
        <th>Ngày duyệt</th>
        <th style="width: 120px;">Chức năng</th>
        </thead>
        <tbody>
        @php
            $i = 1;

        @endphp
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
                    {{ $i++ }}
                </td>
                <td class="table-text">
                    <a href="{{ $showLink }}">{{ $record->creator->name ?? '' }}</a>
                </td>
                <td>{{ $record->work_day }}</td>
                <td>{{ $record->reason }}</td>
                <td>{{ $record->status == 0 ? 'Chưa duyệt' : 'Đã duyệt' }}</td>
                <td>{{ $record->approver->name ?? '' }}</td>
                <td>{{ date(DATE_FORMAT, strtotime($record->approver_at)) }}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ $showLink }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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
