
<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="name">Tên nhóm:</label> {{ old('name', $team->name) }}
                    </div>
                </div>
                <div class="col-md-6"></div>

            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="form-group margin-b-5 margin-t-5">
                <label for="leader_id">Trưởng nhóm:</label> {{ $team->leader->name }}
            </div>
            <!-- /.form-group -->


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="leader_id">Ảnh đại diện:</label> <img src="{{lfm_thumbnail($team->banner)}}"
                                                                          width="100">
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="banner">Khẩu hiệu:</label> {{ old('slogan', $team->slogan) }}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="description">Miêu
                            tả:</label> {{ old('description', strip_tags($team->description))}}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="created_at">Ngày tạo:</label> {{ old('created_at', $team->created_at) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->

    </div>
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
                        <a href="{{ asset_ver('admin/teams/manage-member/'.$team->id) }}"
                           class="btn btn-sm btn-primary pull-right">
                            <i class="fa fa-plus"></i> <span>Quản lý thành viên</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6"></div>

            </div>
            <br>
            <!-- /.form-group -->
        </div>
    </div>
    <div class="table-responsive list-records">
        <table class="table table-hover table-bordered">
            <thead>
            <th class="text-center">STT</th>
            <th>Tên thành viên</th>
            <th>Ngày tham gia nhóm</th>
            </thead>
            <tbody>
            @php
                $i = 1;
                $members = $team->users;
            @endphp
            @foreach ($members as $member)

                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="table-text">
                        {{ $member->user->name }}
                    </td>
                    <td class="table-text">
                        {{ $member->created_at }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

