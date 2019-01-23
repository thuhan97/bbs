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
                <th class="text-center" scope="col">Ngày sinh</th>
                <th class="text-center" scope="col">Số điện thoại</th>
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
                    <td class="text-center">
                        @if($user->birthday)
                            <span class="btn-showinfo btn btn-info">
                                <i class="fas fas-eyes"></i>
                                Xem
                            </span>
                            <span class="info">
                             {{$user->birthday}}
                        </span>
                        @else
                            <span>{{__l('updating')}}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($user->phone)
                            <span class="btn-showinfo btn btn-info">
                                <i class="fas fas-eyes"></i>
                                Xem
                            </span>
                            <span class="info">
                             {{$user->phone}}
                        </span>
                        @else
                            <span>{{__l('updating')}}</span>
                        @endif
                    </td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <h2>{{__l('list_empty', ['name'=>'nhân viên'])}}</h2>
    @endif
@endsection

@push('extend-css')
    <style>
        .info, .btn-showinfo.show {
            display: none;
        }

        .btn-showinfo.show ~ .info {
            display: block;
        }
    </style>
@endpush
@push('extend-js')
    <script type="text/javascript" src="{{ asset('js/jquery.lazy.min.js') }}"></script>
    <script>
        $(function () {
            $('.lazy').Lazy();

            $('.btn-showinfo').click(function () {
                $(this).addClass('show');
            });
        });
    </script>
@endpush