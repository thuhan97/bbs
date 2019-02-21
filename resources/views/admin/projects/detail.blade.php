
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="name">Tên dự án:</label> {{ old('name', $record->name) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="customer">Khách hàng:</label> {{ $record->customer }}
                    </div>
                </div>

            </div>
            <!-- /.form-group -->
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="image_url">Thumbnail:</label>
                        <div id="slideshow_full">
                         @if ($record->image_url != '')

                            <img src="{{ URL::asset(URL_IMAGE_PROJECT.$record->image_url) }}" style="height: 300px;width: 100%;">

                         @endif

                        </div>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-6">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="project_type">Loại dự án:</label> {{ old('project_type', PROJECT_TYPE[$record->project_type])}}
                    </div>
                    <br>
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="scale">Quy mô dự án:</label> {{ old('scale', $record->scale)}} (người/tháng)
                    </div>
                    <br>
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="amount_of_time">Thời gian:</label> {{ old('amount_of_time', $record->amount_of_time) }} (tháng)
                    </div>
                    <br>
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="leader_id">Leader dự án:</label> {{ old('leader_id', $record->leader->name) }}
                    </div>
                    <br>
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="status">Trạng thái:</label> {{ old('status', STATUS_PROJECT[$record->status]) }}
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group margin-b-5 margin-t-5">
                                <label for="start_date">Ngày bắt đầu:</label> {{ old('start_date', $record->start_date) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group margin-b-5 margin-t-5">
                                <label for="end_date">Ngày kết thúc:</label> {{ old('end_date', $record->end_date) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="technicala">Kỹ thuật:</label> {!! $record->technicala !!}
                        {{--                        <label for="description">Miêu tả:</label> {!! $record->description !!}--}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="tools">Công cụ sử dụng:</label> {!! $record->tools !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="description">Miêu tả:</label> {!! $record->description !!}
{{--                        <label for="description">Miêu tả:</label> {!! $record->description !!}--}}
                    </div>
                </div>
            </div>
        </div>

        <!-- /.col-md-12 -->

    </div>


</div>


