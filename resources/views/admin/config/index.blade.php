<div class="col-md-7">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Thiết lập chung</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Thời gian làm việc</a></li>
            <li><a href="#tab_3" data-toggle="tab">Ngày nghỉ</a></li>
            <li><a href="#tab_4" data-toggle="tab">Biểu mẫu</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                @include('admin.config.general')
            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                @include('admin.config.work_time')
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                @include('admin.config.calendar_off')
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_4">
                @include('admin.config.template')
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
</div>