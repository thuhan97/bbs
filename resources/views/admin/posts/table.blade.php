<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 30px">
            <col style="width: 50px">
            <col style="width: 150px">
            <col style="width: 200px">
            <col style="">
            <col style="width: 120px">
            <col style="width: 100px">
            <col style="width: 100px">
            <col style="width: 90px">
            <col style="width: 100px">
        </colgroup>
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o "></i>
            </button>
        </th>
        <th>Ảnh thông báo</th>
        <th>Tên thông báo
            {!! __admin_sortable('name') !!}
        </th>
        <th>Tóm tắt</th>
        <th>Người đăng</th>
        <th>Ngày tạo
            {!! __admin_sortable('created_at') !!}
        </th>
        <th>Thông báo
            {!! __admin_sortable('has_notify') !!}
        </th>
        <th>Kích hoạt</th>
        <th>Actions</th>
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
                <td class="text-center">
                    <img src="{{lfm_thumbnail($record->image_url)}}" width="100">
                </td>
                <td class="table-text">
                    <a href="{{ $editLink }}">{{ $record->name }}</a>
                </td>
                <td>{{ $record->introduction }}</td>
                <td>{{ $record->author_name }}</td>
                <td class="text-right">{{ $record->created_at->format(DATE_FORMAT) }}</td>
                <td><span class="label label-success">{{$record->notify_date}}</span></td>
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
