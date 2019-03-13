<div class="table-responsive list-records">
    <table class="table table-hover table-bordered dataTable">
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th style="width: 10%;" class="no-wap">
            Nhân viên
            {!! __admin_sortable('userName') !!}
        </th>
        <th style="width: 12%;">
            Tên thiết bị
            {!! __admin_sortable('devicesName') !!}
        </th>
        <th style="width: 9%;">Mã thiết bị
            {!! __admin_sortable('code') !!}
        </th>

        <th style="width: 9%;">Ngày cấp
            {!! __admin_sortable('allocate_date') !!}
        </th>
        <th style="width: 9%;">Ngày trả
            {!! __admin_sortable('return_date') !!}
        </th>
        <th>Ghi chú
            {!! __admin_sortable('note') !!}
        </th>
        <th style="width: 120px;">Chức năng</th>
        </thead>
        <tbody>
        <?php
        $tableCounter = 0;
        ?>
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
                <td>{{ $record->userName }}</td>
                <td>{{ $record->devicesName }}</td>
                <td>{{ $record->code }}</td>
                <td>{{ $record->allocate_date | date(DATE_FORMAT) }}</td>
                <td>{{ $record->return_date ?  $record->return_date | date(DATE_FORMAT) : ''}}</td>

                <td>{{ $record->note }}</td>
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