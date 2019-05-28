<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 30px">
            <col style="width: 70px">
            <col style="">
            <col style="width: 150px">
            <col style="width: 150px">
            <col style="width: 150px">
            <col style="width: 70px">
        </colgroup>
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o "></i>
            </button>
        </th>
        <th>Thứ tự
            {!! __admin_sortable('order') !!}
        </th>
        <th>Tên
            {!! __admin_sortable('name') !!}
        </th>
        <th>Ngày hiệu lực
            {!! __admin_sortable('approve_date') !!}
        </th>
        <th>Ngày tạo
            {!! __admin_sortable('created_at') !!}
        </th>
        <th>Ngày cập nhật
            {!! __admin_sortable('updated_at') !!}
        </th>
        <th style="width: 100px;">Actions</th>
        </thead>
        <tbody>
        @foreach ($records as $record)
            <?php
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);

            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}" class="square-blue chkDelete"></td>
                <td class="text-right">{{ $record->order }}</td>
                <td class="table-text">
                    <a href="{{ $editLink }}">{{ $record->name }}</a>
                </td>
                <td class="text-right">{{ $record->approve_date }}</td>
                <td class="text-right">{{ $record->created_at->format(DATE_FORMAT) }}</td>
                <td class="text-right">{{ $record->updated_at->format(DATE_FORMAT) }}</td>
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
