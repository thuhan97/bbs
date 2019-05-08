<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header">
                <div class="box-title">
                    Tạo ngày nghỉ lễ
                </div>
            </div>
            <div class="box-body" id="dayoff-zone">
                <div class="box-text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group margin-b-5 margin-t-5">
                                <label for="date_off_from">Nghỉ từ *</label>
                                <input id="date_off_from" type="text" class="form-control"
                                       placeholder="{{date('Y/01/01')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group margin-b-5 margin-t-5">
                                <label for="date_off_to">Ngày đến *</label>
                                <input id="date_off_to" type="text" class="form-control"
                                       placeholder="{{date('Y/01/01')}}">
                            </div>
                        </div>

                    </div>
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="date_name">Tên ngày nghỉ *</label>
                        <input id="date_name" type="text" class="form-control"
                               placeholder="Nghỉ tết dương, quốc khánh, ...">
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="has_notify">
                                <input id="chkRepeat" type="checkbox" class="square-blue"
                                       value="{{ACTIVE_NOTIFY}}">
                                Định kỳ hàng năm
                            </label>
                        </div>
                        <div class="col-md-6 text-right">
                            <button id="btnAddDayOff" class="btn btn-success" type="button">Thêm >></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">
                    Danh sách ngày nghỉ lễ
                </div>
            </div>
            <div class="box-body">
                <div class="box-text">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th class="text-center" style="width: 150px">Nghỉ từ</th>
                            <th class="text-center" style="width: 150px">Nghỉ đến</th>
                            <th class="text-center" style="width: 150px">Lặp lại theo năm</th>
                            <th class="text-center" style="width: 50px">Xóa</th>
                        </tr>
                        </thead>
                        <tbody id="dayoff-list">
                        @foreach($dayOffs as $dayOff)
                            <tr data-id="{{$dayOff->id}}">
                                <td>{{$dayOff->date_name}}</td>
                                <td class="text-center">{{$dayOff->date_off_from}}</td>
                                <td class="text-center">{{$dayOff->date_off_to}}</td>
                                <td class="text-center">{{$dayOff->is_repeat ? 'Có' : 'Không'}}</td>
                                <td class="text-center"><span class="btnDateOffDelete text-danger">
                                        <i class="fa fa-close"></i>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header">
                <div class="box-title">
                    Tạo ngày làm bù
                </div>
            </div>
            <div class="box-body" id="dayoff-zone">
                <div class="box-text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group margin-b-5 margin-t-5">
                                <label for="date_add">Ngày</label>
                                <input id="date_add" type="text" class="form-control"
                                       placeholder="{{date('Y/01/01')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group margin-b-5 margin-t-5">
                        <label for="date_add_name">Lý do *</label>
                        <input id="date_add_name" type="text" class="form-control"
                               placeholder="Lý do làm bù">
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6 text-right">
                            <button id="btnAddDay" class="btn btn-warning" type="button">Thêm >></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">
                    Danh sách ngày làm bù
                </div>
            </div>
            <div class="box-body">
                <div class="box-text">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 150px">Ngày làm bù</th>
                            <th>Lý do</th>
                            <th class="text-center" style="width: 50px">Xóa</th>
                        </tr>
                        </thead>
                        <tbody id="dayadd-list">
                        @foreach($additionalDates as $date)
                            <tr data-id="{{$date->id}}">
                                <td class="text-center">{{$date->date_add}}</td>
                                <td>{{$date->date_name}}</td>
                                <td class="text-center"><span class="btnDateAddDelete text-danger">
                                        <i class="fa fa-close"></i>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
    <script>

        $(function () {
            $("#btnAddDayOff").click(function () {
                var dateName = $('#date_name').val();
                if (!dateName) {
                    return $('#date_name').focus();
                }
                var date_off_from = $('#date_off_from').val();
                if (!date_off_from) {
                    return $('#date_off_from').focus();
                }
                var date_off_to = $('#date_off_to').val();
                if (!date_off_to) {
                    return $('#date_off_to').focus();
                }
                var isRepeat = $('#chkRepeat').is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{route('admin::configs.dayoff')}}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'date_name': dateName,
                        'date_off_from': date_off_from,
                        'date_off_to': date_off_to,
                        'is_repeat': isRepeat,
                    },
                    success: function (dayoff) {
                        $("#dayoff-list").prepend('<tr data-id="' + dayoff.id + '">' +
                            '<td>' + dateName + '</td>' +
                            '<td class="text-center">' + date_off_from + '</td>' +
                            '<td class="text-center">' + date_off_to + '</td>' +
                            '<td class="text-center">' + (isRepeat ? 'Có' : 'Không') + '</td>' +
                            '<td class="text-center"><span class="btnDateOffDelete text-danger"><i class="fa fa-close"></i> </span></td>' +
                            '</tr>');

                        $('#dayoff-zone').find('input').val('');
                    },
                    error: function () {
                        $('#date_off_from').focus();
                    }
                })
            });
            $(document).on('click', '.btnDateOffDelete', function () {
                var that = $(this).closest('tr');
                var id = that.data('id');
                that.remove();

                $.ajax({
                    url: '{{route('admin::configs.delete_dayoff')}}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'id': id,
                    },
                    success: function () {
                    }
                });
            });
            $("#btnAddDay").click(function () {
                var dateName = $('#date_add_name').val();
                if (!dateName) {
                    return $('#date_add_name').focus();
                }
                var date_add = $('#date_add').val();
                if (!date_add) {
                    return $('#date_add').focus();
                }

                $.ajax({
                    url: '{{route('admin::configs.dayadd')}}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'date_name': dateName,
                        'date_add': date_add,
                    },
                    success: function (dayoff) {
                        $("#dayadd-list").prepend('<tr data-id="' + dayoff.id + '">' +
                            '<td class="text-center">' + date_add + '</td>' +
                            '<td>' + dateName + '</td>' +
                            '<td class="text-center"><span class="btnDateAddDelete text-danger"><i class="fa fa-close"></i> </span></td>' +
                            '</tr>');

                        $('#dayoff-zone').find('input').val('');
                    },
                    error: function () {
                        $('#date_off_from').focus();
                    }
                })
            });
            $(document).on('click', '.btnDateAddDelete', function () {
                var that = $(this).closest('tr');
                var id = that.data('id');
                that.remove();

                $.ajax({
                    url: '{{route('admin::configs.delete_dayadd')}}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        'id': id,
                    },
                    success: function () {
                    }
                });
            });
            myDatePicker($("#date_off_from, #date_off_to, #date_add"));
        })
    </script>
@endpush