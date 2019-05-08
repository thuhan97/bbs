<?php
$team = \Auth::user()->team();

$logoUrl = $team->banner ?? 'http://jvb-corp.com/img/logo.png';
$name = $team->name ?? $config->name;
?>

<!-- Sidebar -->
<div class="sidebar fixed sidebar-fixed position-fixed" id="slide-out">

    <div class="text-center mb-xl-3">
        <a href="/" class="logo-wrapper waves-effect">
            <img src="{{$logoUrl}}" class="img-fluid" alt="">
        </a>

        <p><strong class="text-uppercase text-primary">
                {{$name}}
            </strong></p>
    </div>
    <div class="list-group list-group-flush" style="margin: 0 -15px">
        <a href="/"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['default']) ? 'active': '' }}">
            <i class="fas fa-home mr-3"></i>{{__l('Dashboard')}}
        </a>
        <a href="{{route('regulation')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['regulation', 'regulation_detail']) ? 'active': '' }}">
            <i class="fas fa-anchor mr-3"></i>{{__l('regulation')}}</a>

        <a href="{{route('contact')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['contact']) ? 'active': '' }}">
            <i class="fas fa-address-book mr-3"></i> {{__l('contact')}}</a>

        <a href="{{route('project')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['project', 'project_detail']) ? 'active': '' }}">
            <i class="fas fa-industry mr-3"></i>
            {{__l('Project')}}</a>

        {{--        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">--}}
        {{--            <i class="fas fa-building mr-3"></i>--}}
        {{--            Phòng họp</a>--}}
        {{--        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">--}}
        {{--            <i class="fas fa-desktop mr-3"></i>--}}
        {{--            Quản lý thiết bị</a>--}}
        <a href="{{route('list_share_document')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['list_share_document']) ? 'active': '' }}">
            <i class="fas fa-file mr-3"></i>
            Chia sẻ tài liệu</a>
        <a href="{{route('share_experience')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['share_experience']) ? 'active': '' }}">
            <i class="fas fa-book mr-3"></i>
            Kinh nghiệm làm việc</a><!-- 
        <a href="{{route('post')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['post', 'post_detail']) ? 'active': '' }}">
            <i class="fas fa-bell mr-3"></i>{{__l('Post')}}</a> -->
        @can('team-leader')
            <a href="{{route('list_suggestions')}}"
               class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['list_suggestions']) ? 'active': '' }}">
                <i class="fas fa-bell mr-3"></i>Đề xuất & góp ý</a>
        @endcan
        <a href="{{route('event')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['event', 'event_detail']) ? 'active': '' }}">
            <i class="fas fa-calendar mr-3"></i> {{__l('Event')}}</a>
    </div>
</div>
<!-- Sidebar -->