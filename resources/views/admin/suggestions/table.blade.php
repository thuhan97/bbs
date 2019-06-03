<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 30px">
            <col style="width: 150px">
            <col style="">
            <col style="width: 190px">
            <col style="width: 150px">
            <col style="width: 100px">
            <col style="width: 40px">
            <col style="width: 90px">
        </colgroup>
        <thead class="eventTable">
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>Người góp ý
        </th>
        <th>Nội dung</th>
        <th>Phản hồi cho người duyệt
        </th>
        <th>Người duyệt
        </th>
        <th>Ngày tạo
        </th>
        <th>Trạng thái</th>
        <th>Chức năng</th>
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
                <td class="table-text">
                    <a href="{{ $editLink }}">{{ $record->user->name ?? '' }}</a>
                </td>
                <td>{{ $record->content }}</td>
                <td>{{ $record->comment }}</td>
                <td>{{ $record->suggestions_isseus->name ?? '' }}</td>
                <td class="text-right">{{ $record->created_at->format('d-m-Y') }}</td>
                @if ($record->status == 1)
                    <td><span class="label label-info">Yes</span></td>
                @else
                    <td><span class="label label-warning">No</span></td>
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
