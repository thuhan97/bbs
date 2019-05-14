<div class="table-responsive list-records">
    <table class="table table-hover table-bordered">
        <thead>
        <th style="width: 10px;">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
        </th>
        <th style="width: 15px">Màu</th>
        <th style="width: 120px">Tên group
            {!! __admin_sortable('group_id') !!}
        </th>
        <th style="width: 120px">Ảnh đại diện</th>
        <th>Tên nhóm
            {!! __admin_sortable('name') !!}
        </th>
        <th>Trưởng nhóm</th>
        <th>Số thành viên</th>
        <th>Khẩu hiệu</th>
        <th style="width: 120px;">Ngày tạo</th>
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
                <td style="background: {{$record->color}}">
                </td>
                <td>{{ $record->group_name }}</td>
                <td>
                    @if($record->banner)
                        <img src="{{lfm_thumbnail($record->banner)}}" width="100">
                    @endif
                </td>
                <td class="table-text">
                    <a href="{{ $showLink }}">{!! $record->name !!} </a>
                </td>
                <td>{{ $record->leader->name}}</td>
                <td class="text-center">{{ $record->members->count() + 1 }}</td>
                <td>{{ $record->slogan }}</td>
                <td class="">{{ $record->created_at->format(DATE_FORMAT) }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <div class="btn-group">
                        <a href="{{ $showLink }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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
