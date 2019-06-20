<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 50px">
            <col style="width: 120px">
            <col style="width: 150px">
            <col style="">
            <col style="width: 120px">
            <col style="width: 120px">
            <col style="width: 120px">
        </colgroup>
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>Nhân viên</th>
        <th>Thiết bị yêu cầu</th>
        <th>Tiêu đề</th>
        <th>Ngày tạo</th>
        <th>Ngày hẹn trả</th>
        <th>Trạng thái</th>
        <th style="width: 100px;">Chức năng</th>
        </thead>
        <tbody>
        @foreach ($records as $record)
            <?php
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);
            $userLink = route('admin::day_offs.user', $record->user_id);

            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}" class="square-blue chkDelete"></td>
                <td class="text-right">{{ $record->created_at->format('Y-m-d') }}</td>
                <td class="table-text">
                    <a href="{{ $userLink }}">{{ $record->user->name ?? '' }}</a>
                </td>
                <td>
                    {{ array_key_exists($record->type_device,TYPES_DEVICE) ? TYPES_DEVICE[$record->type_device] : '' }}
                </td>
                <td class="text-right">{{ $record->title }}</td>
                <td class="text-right">{{ $record->return_date }}</td>
                <td class="text-center">
                    @if($record->status == STATUS_DAY_OFF['abide'])
                        <span class="label label-danger">close</span>
                    @elseif($record->status == STATUS_DAY_OFF['active'])
                        <span class="label label-info">Yes</span>
                    @else
                        <span class="label label-warning">no</span>
                    @endif
                </td>
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
<script>
    $(document).ready(function () {
        $('#btn-submit-excel').on('click', function () {
            $('#export').removeAttrs('disabled');
        })
        $('#btn-search').on('click', function () {
            $('#export').attr('disabled', true);
        })
        $('.toggle-create').remove();
    })
</script>
