<h4>Báo cáo tuần</h4>
<div class="form-group margin-b-5 margin-t-5{{ $errors->has('weekly_report_title') ? ' has-error' : '' }}">
    <label for="weekly_report_title">Tiêu đề báo cáo tuần</label>
    <input type="text" class="form-control" name="weekly_report_title" placeholder="Nhập tiêu đề báo cáo tuần"
           value="{{ old('weekly_report_title', $record->weekly_report_title) }}">

    @if ($errors->has('weekly_report_title'))
        <div class="help-block">
            <strong>{{ $errors->first('weekly_report_title') }}</strong>
        </div>
    @endif
    <br/>
    <div class="mt-5">
        <p class="text-yellow mb-0"><i class="fa fa-quote-left"></i> <strong>Lưu ý: Tiêu đề báo cáo là chữ thường hoặc
                các ký
                tự đặc biệt được quy định bên dưới</strong></p>
        <ol>
            <li><i class="code">${staff_name}</i>: Tên nhân viên</li>
            <li><i class="code">${week_number}</i>: Số tuần hiện tại</li>
            <li><i class="code">${d}</i>: Ngày hiện tại</li>
            <li><i class="code">${m}</i>: Tháng hiện tại</li>
            <li><i class="code">${Y}</i>: Năm hiện tại</li>
            <li><i class="code">${first_day}</i>: Ngày đầu tuần d/m => 21/01</li>
            <li><i class="code">${last_day}</i>: Ngày cuối tuần d/m => 26/01</li>
        </ol>
    </div>
</div>
<div class="tab-pane active" id="tab_1">
    <div class="form-group margin-b-5 margin-t-5{{ $errors->has('html_weekly_report_template') ? ' has-error' : '' }}">
        <label for="html_weekly_report_template">Biểu mẫu báo cáo tuần</label>
        <textarea class="form-control" name="html_weekly_report_template" id="html_weekly_report_template"
                  placeholder="content">{{ old('html_weekly_report_template', $record->html_weekly_report_template) }}</textarea>

        @if ($errors->has('html_weekly_report_template'))
            <div class="help-block">
                <strong>{{ $errors->first('html_weekly_report_template') }}</strong>
            </div>
        @endif
    </div>
</div>

@push('footer-scripts')
    <style>
        .code {
            color: #004ec7;
        }
    </style>
    <script>
        $(function () {
            myEditor($("#html_weekly_report_template"));
        })
    </script>

@endpush