<div class="input-group">
    <input name="search" value="{{request('search', $search)}}" class="form-control" type="text"
           placeholder="{{$text}}" aria-label="Search">

    <div class="input-group-prepend">
        <button class="btn btn-info" id="inputGroup-sizing-default">Tìm kiếm</button>
    </div>
</div>