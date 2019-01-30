@extends('layouts.end_user')
@section('breadcrumbs')
    {!! Breadcrumbs::render('regulation_detail', $regulation) !!}
@endsection
@section('content')
    <div class="card">
        <h5 class="card-header h5">{{$regulation->name}}</h5>
        <div class="card-body">
            {{--<h5 class="card-title">{!! $regulation->introduction !!}</h5>--}}
            <div class="card-text">{!! $regulation->content !!}</div>

            @if($regulation->regulation_files->isNotEmpty())
                <hr class="mt-5"/>
                <h6 class="">
                    <i>
                        Danh sách tài liệu đính kèm
                    </i>
                </h6>
                <div class="">
                    <ul>
                        @foreach($regulation->regulation_files as $index => $file)
                            <li>
                                <a href="{{$file->file_path}}" target="_blank"><i class="fas fa-file"></i>  File đính kèm {{$index+1}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="text-right">
                <p>
                    <b>{{ $regulation->created_at->format(DATE_FORMAT) }}</b>
                </p>
            </div>
        </div>
    </div>
@endsection