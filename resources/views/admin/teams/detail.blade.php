<div class="col-md-5">
    <div class="row">
        <div class="col-md-4">
            <img class="w-100" src="{{lfm_thumbnail($record->banner)}}">
        </div>

        <div class="col-md-8">
            <br/>
            <div title="Màu truyền thống" class="m-3 d-sm-block"
                 style="width: 100%; height: 10px; background: {{$record->color}}">
            </div>
            <br/>
            <p>Tên nhóm: <b>{{ old('name', $record->name) }}</b></p>
            <p>Trưởng nhóm: <b>{{ $record->leader->name }}</b></p>
            <p>Ngày tạo: <b>{{ $record->created_at }}</b></p>
            <p>Khẩu hiệu: <b>{{ $record->slogan }}</b></p>
            <br/>
            <p>Mô tả: </p>
            {!! $record->description !!}
        </div>
    </div>
</div>

<div class="col-md-8">
    <br/>
    <br/>
    <hr/>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label>Danh sách thành viên</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <a href="{{ URL::asset('/admin/teams/manage-member/'.$record->id) }}"
                           class="btn btn-sm btn-primary pull-right">
                            <i class="fa fa-plus"></i> <span>Quản lý thành viên</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="table-responsive list-records">
        <table class="table table-hover table-bordered">
            <thead>
            <th style="width: 20px" class="text-center">STT</th>
            <th style="width: 200px">Tên thành viên</th>
            <th style="width: 120px">Loại hợp đồng</th>
            <th style="width: 120px">Chức vụ</th>
            <th>Kỹ năng</th>
            </thead>
            <tbody>
            @php
                $i = 1;
                $members = $record->members;
            @endphp
            @foreach ($members as $member)

                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="table-text">
                        {{ $member->name }}
                    </td>
                    <td class="table-text">
                        {{ CONTRACT_TYPES_NAME[$member->contract_type] }}
                    </td>
                    <td class="table-text">
                        {{ POSITIONS[$member->position_id] ?? POSITIONS[0] }}
                    </td>

                    <td class="table-text">
                        {{ $member->skills }}
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

