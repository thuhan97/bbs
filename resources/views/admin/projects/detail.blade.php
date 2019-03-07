<div class="col-md-12">
    <div class="row">
        <div class="col-md-7">
            <p>Tên dự án: <b>{{ old('name', $record->name) }} (
                    <span style="{{COLOR_STATUS_PROJECT[$record->status] ?? ''}}">
                    {{ STATUS_PROJECT[$record->status] ?? 'Vừa tạo'}}
                </span>
                    )</b>
            </p>
            <p>Khách hàng: <b>{{$record->customer}}</b></p>
            <p>Loại dự án: <b>{{ PROJECT_TYPE[$record->project_type] }}</b></p>
            <p>Quy mô dự án: <b>{{$record->scale}} (người/tháng) - {{$record->amount_of_time}} (tháng)</b></p>
            <p>Leader dự án: <b>{{$record->leader->name}}</b></p>
            <p>Thời gian dự án: <b>{{$record->start_date}} ~ {{$record->end_date}}</b></p>
            <hr/>
            <div class="form-group mb-3 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Kỹ thuật:
                            </div>
                            <div class="panel-body">
                                {!! nl2br($record->technical) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Công cụ:
                            </div>
                            <div class="panel-body">
                                {!! nl2br($record->tools) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Mô tả dự án:
                </div>
                <div class="panel-body">
                    {!! $record->description !!}
                </div>
            </div>
        </div>
        <div class="col-md-5">
            @if ($record->image_url != '')
                <img src="{{ $record->image_url }}" style="max-width: 100%">
            @endif

        </div>
    </div>
</div>


