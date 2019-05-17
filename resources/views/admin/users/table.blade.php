<div class="table-responsive list-records">
    <table class="table table-hover table-bordered dataTable">
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th class="no-wap">
            Mã nhân viên
            {!! __admin_sortable('staff_code') !!}
        </th>
        <th>
            Họ và tên
            {!! __admin_sortable('name') !!}
        </th>
        <th>Ngày sinh
            {!! __admin_sortable('birthday') !!}
        </th>

        <th>Email
            {!! __admin_sortable('email') !!}
        </th>
        <th>Số điện thoại
            {!! __admin_sortable('phone') !!}
        </th>
        <th>Chức danh
            {!! __admin_sortable('jobtitle_id') !!}
        </th>
        <th>Loại hợp đồng
            {!! __admin_sortable('contract_type') !!}
        </th>
        <th>Ngày tạo
            {!! __admin_sortable('created_at') !!}
        </th>
        <th style="width: 120px;">Chức năng</th>
        </thead>
        <tbody>
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
                    @can('update', $record)
                        <a href="{{ $editLink }}">{{ $record->staff_code }}</a>
                    @else
                        {{ $record->staff_code }}
                    @endcan
                </td>
                <td class="table-text">
                    <a href="{{ $showLink }}">{{ $record->name }}</a>
                </td>
                <td>{{ $record->birthday }}</td>
                <td>{{ $record->email }}</td>
                <td>{{ $record->phone }}</td>
                <td>{{ JOB_TITLES[$record->jobtitle_id] ?? '' }}</td>
                <td>{{ CONTRACT_TYPES_NAME[$record->contract_type] ?? '' }}</td>
                <td class="">{{ $record->created_at }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <div class="btn-group">
                        <a href="{{ $showLink }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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
@push('footer-scripts')
    <script>
        $(function () {
        })
    </script>
@endpush