<div class="table-responsive list-records">
    <table class="table table-hover table-bordered dataTable">
        <thead>
            <th style="width: 10px;">
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
            </th>
            <th style="width: 8%;" class="no-wap">
                Chủng loại
                {!! __admin_sortable('types_device_id') !!}
            </th>
            <th style="width: 12%;">
                Tên thiết bị
                {!! __admin_sortable('name') !!}
            </th>
            <th style="width: 7%;">Số lượng tồn T01/2019
                {!! __admin_sortable('quantity_inventory') !!}
            </th>

            <th style="width: 7%;">Số lượng đang sử dụng
                {!! __admin_sortable('quantity_used') !!}
            </th>
            <th style="width: 7%;">Sử dụng trong tháng
                {!! __admin_sortable('month_of_use') !!}
            </th>
            <th style="width: 7%;">Số lượng chưa sử dụng
                {!! __admin_sortable('quantity_unused') !!}
            </th>
            <th style="width: 7%;">Tồn cuối
                {!! __admin_sortable('final') !!}
            </th style="width: 25%;">
            <th>Ghi chú
                {!! __admin_sortable('note') !!}
            </th>
            <th style="width: 120px;">Chức năng</th>
        </thead>
        <tbody>
        @foreach ($records as $tmpRecord)
            <?php
            $listShowRec = \App\Models\Device::where('types_device_id', $tmpRecord->types_device_id)->where('name', 'like', '%' . $search . '%')->get();
            ?>
            @foreach($listShowRec as $key => $record)
            <?php
            $tableCounter++;
            $editLink = route($resourceRoutesAlias . '.edit', $record->id);
            $showLink = route($resourceRoutesAlias . '.show', $record->id);
            $deleteLink = route($resourceRoutesAlias . '.destroy', $record->id);
            $formId = 'formDeleteModel_' . $record->id;
            ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $record->id }}" class="square-blue chkDelete"></td>
                @if($key == 0)
                <td rowspan="{{$tmpRecord->total}}">{{ TYPES_DEVICE[$record->types_device_id] ?? '' }}</td>
                @endif
                <td>{{ $record->name }}</td>
                <td>{{ $record->quantity_inventory }}</td>
                <td>{{ $record->quantity_used }}</td>
                <td>{{ $record->month_of_use }}</td>
                <td>{{ $record->quantity_unused }}</td>
                <td>{{ $record->final }}</td>
                <td>{{ $record->note }}</td><td>
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
        @endforeach
        </tbody>
    </table>
</div>