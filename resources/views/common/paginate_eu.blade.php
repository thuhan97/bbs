<br/>
<hr/>
<div class="box-footer clearfix">
    <div class="row">
        <div class="col-md-5">
            <div class="row pagination-row">
                <div class="col-md-3">
                    <select id="pageSize" name="page_size" class="pageSize form-control">
                        @foreach(PAGE_LIST as $item)
                            <option @if($item == $perPage) selected
                                    @endif data-href="{{ str_replace('page', 'page_size', $records->url($item)) }}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    <p class="label text-left normal-text">
                        kết quả/trang
                    </p>
                </div>
            </div>

        </div>
        <div class="col-md-7">
            <!-- Pagination -->
            <div class="float-right">
                <div class="no-margin text-center">
                    {!! $records->render() !!}
                </div>
            </div>
            <!-- / End Pagination -->
        </div>
    </div>


</div>
<!-- /.box-footer -->
