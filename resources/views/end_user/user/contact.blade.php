@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('contact') !!}
@endsection
@section('content')
    <!-- Search form -->
    <form class="mb-4">
        <div class="md-form active-cyan-2 mb-3">
            <input name="search" value="{{old('search', $search)}}" class="form-control" type="text"
                   placeholder="{{__l('Search_contact')}}" aria-label="Search">
            <input type="hidden" name="page_size" value="{{$perPage}}">
        </div>
    </form>
    @if($users->isNotEmpty())
        <p>{{__l('total_user', ['number' => $users->count()])}}</p>
        <table id="contactTbl" class="table table-striped">
            <colgroup>
                <col style="width: 30px">
                <col style="width: 120px">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                {{--<col style="width: 160px">--}}
            </colgroup>
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Mã nhân viên</th>
                <th scope="col">Tên nhân viên</th>
                <th scope="col">Ngày sinh</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                {{--<th scope="col">Chi tiết</th>--}}
            </tr>
            </thead>
            <tbody>

            @foreach($users as $id => $user)
                <tr>
                    <th scope="row">{{$id + 1}}</th>
                    <td class="text-center">
                        <img class="avatar lazy img-fluid z-depth-1 rounded-circle" data-src="{{$user->avatar}}"
                             src="{{URL_IMAGE_NO_IMAGE}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'" width="80"
                             height="80">
                    </td>
                    <td>{{$user->staff_code}}</td>
                    <td>{{$user->name}}</td>
                    <td class="">{{$user->birthday}}</td>
                    <td class="">{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    {{--<td>--}}
                    {{--<button type="button" class="btnViewDetail btn btn-primary text-uppercase">--}}
                    {{--{{__l('detail')}}--}}
                    {{--</button>--}}
                    {{--</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <h2>{{__l('list_empty', ['name'=>'nhân viên'])}}</h2>
    @endif
@endsection

@push('extend-js')
    <script type="text/javascript" src="{{ asset('js/jquery.lazy.min.js') }}"></script>
    <script>
        $(function () {
            $('.lazy').Lazy();
        });
    </script>
@endpush