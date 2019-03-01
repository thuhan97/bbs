<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 30px">
            <col style="">
            <col style="">
            <col style="">
            <col style="width: 120px">
            <col style="width: 100px">
            <col style="width: 70px">
            <col style="width: 70px">
        </colgroup>
        <thead class="eventTable">
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>Tên sự kiện
            {!! __admin_sortable('name') !!}
        </th>
        <th>Tóm tắt</th>
        <th>Ngày diễn ra
            {!! __admin_sortable('event_date') !!}
        </th>
        <th>Địa điểm
            {!! __admin_sortable('place') !!}
        </th>
        <th>Ngày tạo
            {!! __admin_sortable('created_at') !!}
        </th>
        <th>Trạng thái</th>
        <th style="width: 100px;">Chức năng</th>
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
                    <a href="{{ $editLink }}">{{ $record->name }}</a>
                </td>
                <td>{{ $record->introduction }}</td>
                <td>{{ $record->event_date }}</td>
                <td>{{ $record->place }}</td>
                <td class="text-right">{{ $record->created_at->format(DATE_FORMAT) }}</td>
                @if ($record->status == 1)
                    <td><span class="label label-info">Yes</span></td>
                @else
                    <td><span class="label label-warning">No</span></td>
            @endif

            <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <div class="btn-group">
                        <a href="" class="btn btn-info btn-sm"><i class="fa fa-info"></i></a>
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
