<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th>STT</th>
        <th>Tên dự án
            {!! __admin_sortable('name') !!}
        </th>
        <th>Khách hàng</th>
        <th>Loại dự án ODC/Trọn gói</th>
        <th>Quy mô dự án man/monh</th>
        <th>Thời gian</th>
        <th>Kỹ thuật</th>
        <th>Công cụ sử dụng</th>
        <th>Leader dự án</th>
        <th>Ngày bắt đầu</th>
        <th>Ngày kết thúc</th>
        <th style="width: 120px;">Chức năng</th>
        </thead>
        <tbody>
        @php
            $i = 1;
        @endphp
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
                    {{ $i++ }}
                </td>
                <td class="table-text">
                    <a href="{{ $showLink }}">{{ $record->name }}</a>
                </td>
                <td>{{ $record->customer}}</td>
                <td>{{ $record->project_type}}</td>
                <td>{{ $record->scale}}</td>
                <td>{{ $record->amount_of_time}}</td>
                <td>{{ $record->technicala}}</td>
                <td>{{ $record->tools}}</td>
                <td>{{ $record->leader_id}}</td>
                <td>{{ $record->start_date}}</td>
                <td>{{ $record->end_date }}</td>

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
