<div class="box-footer clearfix">
    <div class="row">
        <div class="col-md-5">
            <div class="row pagination-row">
                <div class="col-md-3">
                    <select id="pageSize" name="per_page" class="pageSize form-control">
                        @foreach(PAGE_LIST as $item)
                            <option @if($item == $perPage) selected
                                    @endif data-href="{{ str_replace('page', 'per_page', $records->url($item)) }}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    bản ghi trên một trang.
                </div>
            </div>

        </div>
        <div class="col-md-7">
            <!-- Pagination -->
            <div class="pull-right">
                <div class="no-margin text-center">
                    {!! $records->render() !!}
                </div>
            </div>
            <!-- / End Pagination -->
        </div>
    </div>


</div>
<!-- /.box-footer -->
