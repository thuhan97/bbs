@extends('layouts.end_user')
@section('page-title', 'chi-tiet-de-xuat-gop-y')
@section('breadcrumbs')
    {!! Breadcrumbs::render('detail_suggestions',$suggestion) !!}
@endsection
@section('content')
    <!-- Jumbotron -->
    <div class="jumbotron p-0 mt-3">

        <!-- Card content -->
        <div class="card-body mb-3">
            <!-- Title -->
            <h2 class="card-title h3 pb-0 pb-xxl-4"><strong>Nội dung đề xuất - góp ý</strong></h2>
            <!-- Text -->
            <p class="card-text py-2 space-text-5">{!! nl2br($suggestion->content)  !!}</p>
            <!-- Button -->
            <h5 class="card-title h6 mt-4"><b>Người gửi :</b></h5>
            <p class="card-text py-2 space-text-5">{{$suggestion->user->name ?? ''}}</p>
            @can('manager')
                <form action="{{ route('approve_suggestion',['id'=>$suggestion->id]) }}" method="post">
                    @csrf
                    <h5 class="card-title h6 my-4"><b>Ý kiến của người duyệt</b></h5>
                    <textarea class="form-control" id="exampleFormControlTextarea3" rows="4"
                              name="isseus_comment">{!! $suggestion->isseus_comment !!}</textarea>
                    <br>
                    <div class="pb-2">
                        <input type="checkbox" class="form-check-input" id="materialUnchecked" name="status"
                               value="{{ACTIVE_STATUS}}" {{ old('status', $suggestion->status ?? ACTIVE_STATUS) == ACTIVE_STATUS ? 'checked' : '' }}>
                        <label class="form-check-label" for="materialUnchecked">Đã giải quyết</label>
                    </div>
                    <div>
                        <button class="btn btn-info btn-block my-4 m-auto btn-send-suggestion" type="submit">Cập
                            nhật
                        </button>
                    </div>
                </form>
            @else
                @if($suggestion->isseus_comment)
                    <h5 class="card-title h6 my-4">Ý kiến xử lý -
                        <b>{{ $suggestion->suggestions_isseus->name ?? '' }}</b></h5>
                    <div>{!! nl2br($suggestion->isseus_comment) !!}</div>
                @else
                    <div>Chưa có ý kiến xử lý</div>
                @endif
            @endcan
        </div>
    </div>
@endsection
