<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Thiết lập chung</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Thời gian làm việc</a></li>
        <li><a href="#tab_3" data-toggle="tab">Ngày nghỉ lễ</a></li>
        <li><a href="#tab_4" data-toggle="tab">Biểu mẫu</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-7">
                    @include('admin.config.general')
                </div>
            </div>
        </div>

        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <div class="row">
                <div class="col-md-7">
                    @include('admin.config.work_time')
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_3">
            @include('admin.config.holidays')
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_4">
            <div class="row">
                <div class="col-md-7">
                    @include('admin.config.template')
                </div>

            </div>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
