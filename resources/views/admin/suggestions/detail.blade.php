
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-md-6">
                <h4><b>Người góp ý </b>: {{ $record->user->name ?? '' }}</h4>
                <h4><b>Người phê duyệt </b>: {{ $record->suggestions_isseus->name ?? '' }}</h4>
                <h4><b>Trạng thái </b>: {{ $record->status == DEFAULT_VALUE ? 'Chờ duyệt' : 'Đã duyệt' }}</h4>
                <h4><b>Ngày góp ý </b>: {{ $record->created_at->format('d-m-Y') }}</h4>
            </div>
            <div class="col-md-6">
                <h4><b>Nội dung góp ý: </b></h4>
                <textarea class="form-control" name="description" id="approve_comment" rows="4">{!! $record->content !!}  </textarea>
            </div>
            <div class="col-md-6">
                <h4><b>Ý kiến của Admin : </b></h4>
                <textarea class="form-control" name="description" id="approve_comment" rows="4">{!! $record->comment !!}</textarea>
            </div>
            <div class="col-md-6">
                <h4><b>Ý kiến của người duyệt :</b></h4>
                <textarea class="form-control" name="description" id="approve_comment" rows="4">{!! $record->isseus_comment !!}</textarea>
            </div>
        </div>
        <br>
        <hr>
 </section>


