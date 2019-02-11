
<div class="col-md-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="name">Tên dự án:</label> {{ old('name', $record->name) }}
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
                        <div class="col-md-5" id="slideshow_full">
                         @if ($record->image_url != '')

                            <img src="{{ URL::asset('/adminlte/img/projects_img/'.$record->image_url) }}" style="width: 358px;height: 240px;">

                         @endif

                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="customer">Khách hàng:</label> {{ $record->customer }}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="project_type">Biểu ngữ:</label> {{ old('project_type', PROJECT_TYPE[$record->project_type])}}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>


        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="scale">Quy mô dự án:</label> {{ old('scale', $record->scale)}}
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
                        <label for="amount_of_time">Thời gian:</label> {{ old('amount_of_time', $record->amount_of_time) }}
                    </div>
                    <!-- /.form-group -->
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="technicala">Kỹ thuật:</label> {{ old('technicala', strip_tags($record->technicala)) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="tools">Công cụ sử dụng:</label> {{ old('tools', strip_tags($record->tools)) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="leader_id">Leader dự án:</label> {{ old('leader_id', $record->leader->name) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="start_date">Ngày bắt đầu:</label> {{ old('start_date', $record->start_date) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="end_date">Ngày kết thúc:</label> {{ old('end_date', $record->end_date) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="status">Trạng thái:</label> {{ old('status', STATUS_PROJECT[$record->status]) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->

    </div>


</div>

