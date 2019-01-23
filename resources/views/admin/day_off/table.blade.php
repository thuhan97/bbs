<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 30px">
            <col style="width: 200px">
            <col style="">
            <col style="width: 180px">
            <col style="width: 180px">
            <col style="width: 180px">
            <col style="width: 100px">
            <col style="width: 70px">
        </colgroup>
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>Nhân viên</th>
        <th>Lý do xin nghỉ</th>
        <th>Nghỉ từ</th>
        <th>Đến ngày</th>
        <th>Ngày tạo</th>
        <th>Đã duyệt</th>
        <th style="width: 100px;">Chức năng</th>
        </thead>
        <tbody>
        @foreach ($records as $record)
            <?php
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);
            $userLink = route('admin::users.show', $record->user_id);

            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}" class="square-blue chkDelete"></td>
                <td class="table-text">
                    <a href="{{ $userLink }}">{{ $record->user->name }}</a>
                </td>
                <td>{{ $record->title }}</td>
                <td class="text-right">{{ $record->start_at }}</td>
                <td class="text-right">{{ $record->end_at }}</td>
                <td class="text-right">{{ $record->created_at }}</td>
                @if ($record->status == 1)
                    <td class="text-center"><span class="label label-info">Yes</span></td>
                @else
                    <td class="text-center"><span class="label label-warning">No</span></td>
            @endif

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
