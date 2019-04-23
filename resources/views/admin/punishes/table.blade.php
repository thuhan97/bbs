<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <colgroup>
            <col style="width: 30px">
            <col style="width: 200px">
            <col style="">
            <col style="width: 180px">
            <col style="width: 150px">
            <col style="width: 150px">
            <col style="width: 100px">
            <col style="width: 70px">
        </colgroup>
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>Tên vi phạm
            {{__admin_sortable('rule_id')}}
        </th>
        <th>Nhân viên
            {{__admin_sortable('user_id')}}
        </th>
        <th>Ngày vi phạm</th>
        <th>Tiền phạt</th>
        <th>Ngày tạo</th>
        <th>Đã thu tiền</th>
        <th style="width: 100px;">Chức năng</th>
        </thead>
        <tbody>
        @foreach ($records as $record)
            <?php
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);
            $ruleLink = route($resourceRoutesAlias . '.index', ['rule_id' => $record->rule_id]);
            $userLink = route($resourceRoutesAlias . '.index', ['user_id' => $record->user_id]);

            $statusLink = route($resourceRoutesAlias . '.status', $record->id);
            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}" class="square-blue chkDelete"></td>
                <td class="table-text">
                    <a href="{{ $userLink }}">{{ $record->rule->name ?? '' }}</a>
                </td>
                <td class="table-text">
                    <a href="{{ $userLink }}">{{ $record->user->name ?? '' }}</a>
                </td>
                <td class="text-right">{{ $record->infringe_date }}</td>
                <td class="text-right">{{ number_format($record->total_money) }}</td>
                <td class="text-right">{{ $record->created_at }}</td>
                <td class="text-center">
                    <a href="{{ $statusLink }}">
                        @if($record->is_submit != PUNISH_SUBMIT['new'])
                            <span class="label label-info">Yes</span>
                        @else
                            <span class="label label-warning">No</span>
                        @endif
                    </a>
                </td>
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
