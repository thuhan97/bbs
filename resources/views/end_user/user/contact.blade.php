@extends('layouts.end_user')
@section('page-title', __l('contact'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('contact') !!}
@endsection

@section('content')
    <!-- Search form -->
    <form>
        <div class="md-form active-cyan-2 mb-3">
            @include('layouts.partials.frontend.search-input', ['search' => $search, 'text' => __l('Search_contact')])
            <input type="hidden" name="page_size" value="{{$perPage}}">
        </div>
    </form>
    @if($users->isNotEmpty())
        <p class="mb-0">{{__l('total_user', ['number' => $users->count()])}}</p>
        <table id="contactTbl" class="table table-striped">
            <colgroup>
                <col class="d-none d-sm-table-cell" style="width: 30px">
                <col style="width: 60px">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                <col style="">
                {{--<col style="width: 160px">--}}
            </colgroup>
            <thead>
            <tr>
                <th class="d-none d-sm-table-cell" scope="col">#</th>
                <th scope="col">Ảnh</th>
                <th class="d-none d-sm-table-cell" scope="col">Mã nhân viên</th>
                <th scope="col">Tên nhân viên</th>
                <th class="d-none d-sm-table-cell" scope="col">Tên group</th>
                <th class="d-none d-sm-table-cell" scope="col">Tên team</th>
                <th class="d-none d-sm-table-cell" scope="col">Chức vụ</th>
                <th class="d-none d-sm-table-cell" scope="col">Email</th>
                <th class="text-center" scope="col">Số điện thoại</th>
                {{--<th scope="col">Chi tiết</th>--}}
            </tr>
            </thead>
            <tbody>

            @foreach($users as $id => $user)
                <tr>
                    <th class="d-none d-sm-table-cell" scope="row">{{$id + 1}}</th>
                    <td class="text-center">
                        <img class="avatar lazy img-fluid z-depth-1 rounded-circle" data-src="{{$user->avatar}}"
                             src="{{URL_IMAGE_NO_IMAGE}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'">
                    </td>
                    <td class="d-none d-sm-table-cell">{{$user->staff_code}}</td>
                    <?php
                    $team = $user->team();
                    ?>
                    <td>{{$user->name}}</td>
                    <td class="d-none d-sm-table-cell"
                        onclick="location.href='{{route('contact', ['search' => $team->group_name ?? ''])}}'">
                        @if($team)
                            @php($group = $groups->firstWhere('id', $team->group_id))

                            @if($group)
                                {{$group->name}}
                            @endif
                        @endif
                    </td>
                    <td class="d-none d-sm-table-cell"
                        onclick="location.href='{{route('contact', ['search' => $team->name ?? ''])}}'">{{$team->name ?? ''}}</td>
                    <td class="d-none d-sm-table-cell">{{JOB_TITLES[$user->jobtitle_id] ?? ''}}</td>
                    <td class="d-none d-sm-table-cell"><a href="mailto:{{$user->email}}"> {{$user->email}}</a></td>
                    <td class="text-center">
                        @if($user->phone)
                            <span class="btn-showinfo btn btn-primary btn-sm">
                                <i class="fas fas-eyes"></i>
                                Xem
                            </span>
                            <a href="tel:{{$user->phone}}" class="info">
                                {{$user->phone}}
                            </a>
                        @else
                            <span>{{__l('updating')}}</span>
                        @endif
                    </td>
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
