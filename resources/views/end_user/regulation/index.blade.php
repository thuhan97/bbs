@extends('layouts.end_user')
@section('page-title', __l('regulation'))

@section('breadcrumbs')
    @if(empty($search))
        {!! Breadcrumbs::render('regulation') !!}
    @else
        {!! Breadcrumbs::render('regulation_search', $search) !!}
    @endif
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-xxl-10">
            <!-- Search form -->
            <form class="mb-4">
                <div class="md-form active-cyan-2 mb-3">
                    @include('layouts.partials.frontend.search-input', ['search' => $search, 'text' => __l('Search')])
                    <input type="hidden" name="page_size" value="{{$perPage}}">
                </div>
            </form>
            @if($regulations->isNotEmpty())

                <table class="table table-bordered table-hover">
                    <thead class="grey white-text">
                    <tr>
                        <th style="width: 50px">STT</th>
                        <th>Nội quy/quy định</th>
                        <th style="width: 200px">Ngày bắt đầu hiệu lực</th>
                        <th style="width: 100px">Tải xuống</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($regulations as $idx => $regulation)
                        <tr class="list-reulation">
                            <td class="text-right">
                                {{$idx + 1}}
                            </td>
                            <td>
                                <a href="{{route('regulation_detail', ['id' => $regulation->id])}}">{{$regulation->name}}</a>
                            </td>
                            <td class="text-center">{{$regulation->approve_date}}</td>
                            <td class="text-center">
                                @if($regulation->file_path)
                                    <a class="text-dark" target="_blank"
                                       href="{{route('regulation_download', ['id' => $regulation->id])}}">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                <h2>{{__l('list_empty', ['name'=>'thông báo'])}}</h2>
            @endif
        </div>
    </div>
@endsection