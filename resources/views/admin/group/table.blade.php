<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th style="width: 40px;">
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
            </th>
            <th style="width: 200px">Tên group</th>
            <th style="width: 200px">Số team</th>
            <th style="width: 200px">Người quản lý</th>
            <th>Mô tả</th>
            <th class="text-center" style="width: 120px;">Chức năng</th>
        </tr>
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

                <td>{{ $record->name }}</td>
                <td>{{ $record->teams->count() }}</td>
                <td>
                    {{ $record->user->name ?? '' }}
                </td>
                <td>{!! $record->description !!}</td>
                <!-- we will also add show, edit, and delete buttons -->
                <td class="text-center">
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
