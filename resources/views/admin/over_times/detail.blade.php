<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Người xin: {{ $record->creator->name }}
                </div>
                <div class="panel-body">
                    <div>
                        <label for="">Trạng thái:</label>  {{ $record->status == 0 ? 'Chưa duyệt' : 'Đã duyệt' }}
                    </div>
                    <br>
                    <div class="mt-5">
                        <label for="">Ghi chú:</label>  {!! nl2br($record->reason) !!}
                    </div>
                    <br>
                    <div class="mt-5">
                        <label for="">Người duyệt:</label>  {{ $record->approver->name ?? '' }}
                    </div>
                    <br>
                    <div class="mt-5">
                        <label for="">Ngày duyệt:</label>  {{ date(DATE_FORMAT, strtotime($record->approver_at)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


