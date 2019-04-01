<div class="table-responsive list-records">
    <table class="table table-hover table-bordered dataTable">
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th style="width: 10%;" class="no-wap">
            Tên
            {!! __admin_sortable('name') !!}
        </th>
        <th style="width: 12%;">
            Diện tích (m2)
            {!! __admin_sortable('area') !!}
        </th>
        <th style="width: 10%;">
        	Số ghế
            {!! __admin_sortable('seats') !!}
        </th>

        <th style="width: 20%;">
        	Trang thiết bị
            {!! __admin_sortable('equipment') !!}
        </th>
        <th >
        	Khác
<!--             {!! __admin_sortable('other') !!} -->
        </th>
        <th style="width: 120px;">Chức năng</th>
        </thead>
        <tbody>
        <?php
        $tableCounter = 0;
        ?>
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
                <td>{{ $record->name }}</td>
                <td>{{ $record->area }}</td>
                <td>{{ $record->seats }}</td>
                <td>{{ $record->equipment}}</td>
                <td>{{ $record->other}}</td>
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