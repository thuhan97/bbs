<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <thead>
        <th>
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>Thứ</th>
        <th>Ngày</th>
        <th>Nhân viên</th>
        <th>Checkin</th>
        <th>Checkout</th>
        <th>Chú thích</th>
        <th>Giải trình</th>
        <th>Chức năng</th>
        </thead>
        <tbody>
        @foreach ($records as $record)
            <?php
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);
            $userLink = route($resourceRoutesAlias . '.index', ['user_id' => $record->user_id]);

            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $record->id }}"
                                               class="square-blue chkDelete"></td>
                <td class="w-10">
                    @php($day = date_format(date_create($record->work_day) , 'N') + 1)
                    {{ $day == 8 ? 'Chủ nhật' : $day }}

                </td>
                <td class="w-10">{{ $record->work_day }}</td>
                <td class="table-text">
                    <a href="{{ $userLink }}">{{ $record->user->name ?? '' }}</a>
                </td>
                <td class="text-right w-10">{{ $record->start_at }}</td>
                <td class="text-right w-10">{{ $record->end_at }}</td>
                <td>
                    <?php
                    switch ($record->type) {
                        case 5:
                        case 4:
                            $typeClass = 'success';
                            break;
                        case 2:
                            $typeClass = 'warning';
                            break;
                        case 1:
                            $typeClass = 'danger';
                            break;
                        case -1:
                            $typeClass = 'disable';
                            break;
                    }
                    ?>
                    @if(isset($typeClass))
                        <span class="label label-{{$typeClass}}">{{ $record->note }}</span>
                    @endif
                </td>
                <td class="w-20">{{ $record->explanation($record->work_day)->note ?? '' }}</td>
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
