<?php $search_type = isset($request_input['statistics']) ? $request_input['statistics'] : 1;?>
<div class="row">
    <div class="col-xs-2 pd-r-0">
        <div class="input-group">
            <div class="input-group-btn statistic_year">
                {{ Form::select('year', get_years($num = 5, $prefix = '', $isDesc = true, $istatic = true), request('year'), ['class'=>'form-control title_year']) }}
            </div>
                {{ Form::select('month', get_months(), request('month'), ['class'=>'form-control', 'id' => 'month']) }}
        </div>
    </div>
    <div class="col-xs-2 pd-r-0 weeks">
        <div class="input-group">
            <div class="input-group-btn ">
                <div class="input-group-btn statistic_year">
                    <span class="btn statistic_week">Tuần</span>
                </div>
            </div>
            {{Form::text('week', isset($request_input['week']) ? $request_input['week']:'', ['class' => 'form-control pull-right', 'id' => 'reservation'])}}
        </div>
    </div>
    <div class="col-xs-2 pd-r-0 date">
        <div class="input-group">
            <div class="input-group-btn ">
                <div class="input-group-btn statistic_year">
                    <span class="btn statistic_week"> Ngày</span>
                </div>
            </div>
            {{Form::text('date', isset($request_input['date']) ? $request_input['date']:'', ['class' => 'form-control pull-right', 'id' => 'datepicker'])}}
        </div>
    </div>
    <div class="col-xs-2 pd-r-0 teams">
        {{ Form::select('team_id', team(), request('team_id'), ['class'=>'form-control', 'id' => 'team']) }}
    </div>
    <div class="col-xs-2 pd-r-0 users">
        {{ Form::select('user_id', users(), request('user_id'), ['class'=>'form-control', 'id' => 'user_id']) }}
    </div>
    <div class="col-xs-4 pd-r-0">
        <div class="input-group pull-left">
            {{ Form::select('statistics', statistics(), request('statistics'), ['class' => 'form-control mr-1', 'id' => 'search_type']) }}
        </div>
        <button type="submit" class="btn btn-primary margin-l-15"><i class="fa fa-search"></i> Tìm kiếm</button>
    </div>
    <div class="col-xs-1">
    </div>
</div>
<script type="application/javascript">
    $('#search_type').change(function () {
        $('select#month').val('');
        $('select#team').val('');
        $('input[name="week"]').val('');
        $('#datepicker').val('');
        var type = $(this).val();
        displaySearchType(type);
    });
    function displaySearchType(type) {
        if (type == 2) {
            $('.users').hide();
            $('.date').hide();
            $('.weeks').show();
            $('.teams').show();

        } else if (type == 3) {
            $('.teams').hide();
            $('.weeks').hide();
            $('.date').hide();
            $('.users').show();

        } else {
            $('.weeks').show();
            $('.teams').hide();
            $('.users').hide();
            $('.date').show();
        }
    }
    $(document).ready(function () {
        var type = $('#search_type').val();
        displaySearchType(type);
        var month = $('select#month').val();
        var year = $('select[name="year"]').val();
        setDate(month, year);
        var now = moment();
        var date = '<?= isset($request_input['date']) ? $request_input['date'] : ''?>';
        if (date == '') {
            $('input[name="date"]').val(now.format('DD/MM/YYYY'));
        }
    });
    $('select#month').on('change', function () {
        // $('#reservation').val('');
        // $('#datepicker').val('');
        var month = $(this).val();
        var year = $('select[name="year"]').val();
        setDate(month, year);
    });
    $('select[name="year"]').on('change', function () {
        // $('#reservation').val('');
        // $('#datepicker').val('');
        var year = $(this).val();
        var month = $('select#month').val();
        setDate(month, year);
    });

    function setDate(month, year) {
        var getDaysInMonth = function (month, year) {
            return new Date(year, month, 0).getDate();
        };
        if (month < 10) {
            month = '0' + month;
        }
        var now = moment();
        var last_date_of_month = getDaysInMonth(month, year);
        var start_date = '01/' + month + '/' + year;
        var end_date = last_date_of_month + '/' + month + '/' + year;
        $('input[name="week"]').daterangepicker({
            autoUpdateInput: false,
            minDate: start_date,
            //maxDate: end_date,
            //maxYear: year,
            //startDate: start_date,
            //endDate: end_date,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD/MM/YYYY',
            }
        });
        $('input[name="week"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
        $('input[name="week"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
        $('input[name="date"]').daterangepicker({
            autoUpdateInput: false,
            autoApply: true,
            singleDatePicker: true,
            showDropdowns: true,
            //minDate: start_date,
            //maxDate: end_date,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD/MM/YYYY',
            }
        }, function (chosen_date) {
            $('input[name="date"]').val(chosen_date.format('DD/MM/YYYY'));
        });
    }
</script>