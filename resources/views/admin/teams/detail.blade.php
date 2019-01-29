
<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="name">Tên nhóm:</label> {{ old('name', $record->name) }}
                    </div>
                </div>
                <div class="col-md-6"></div>

            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="leader_id">Trưởng nhóm:</label> {{ $record->leader_name }}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="leader_id">Biểu ngữ:</label> {{ old('banner', $record->banner)}}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="leader_id">Miêu tả:</label> {{ old('description', $record->description)}}
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
                        <label for="banner">Khẩu hiệu:</label> {{ old('slogan', $record->slogan) }}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="created_at">Ngày tạo:</label> {{ old('created_at', $record->created_at) }}
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
                        <label >Danh sách thành viên</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <a href="#" class="btn btn-sm btn-primary pull-right">
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

            @endphp
            @foreach ($members as $member)

                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="table-text">
                        {{ $member->name }}
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

