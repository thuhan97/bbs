<!-- Sidebar -->
<div class="sidebar-fixed position-fixed">

    <div class="text-center">
        <a href="/" class="logo-wrapper waves-effect">
            <img src="http://jvb-corp.com/img/logo.png" class="img-fluid" alt="">
        </a>

        <p><strong class="text-uppercase text-primary">
                {{$config->name}}
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
            <i class="fas fa-address-book mr-3"></i>{{__l('contact')}}</a>

        <a href="{{route('project')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['project', 'project_detail']) ? 'active': '' }}">
            <i class="fas fa-industry mr-3"></i>
            {{__l('Project')}}</a>

        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">
            <i class="fas fa-building mr-3"></i>
            Phòng họp</a>
        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">
            <i class="fas fa-desktop mr-3"></i>
            Quản lý thiết bị</a>
        <a href="{{route('list_share_document')}}" class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['list_share_document']) ? 'active': '' }}">
            <i class="fas fa-file mr-3"></i>
            Chia sẻ tài liệu</a>
        <a href="{{route('share_experience')}}" class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['share_experience']) ? 'active': '' }}">
            <i class="fas fa-book mr-3"></i>
            Kinh nghiệm làm việc</a>
        <a href="{{route('post')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['post', 'post_detail']) ? 'active': '' }}">
            <i class="fas fa-bell mr-3"></i>{{__l('Post')}}</a>

        <a href="{{route('event')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['event', 'event_detail']) ? 'active': '' }}">
            <i class="fas fa-calendar mr-3"></i>{{__l('Event')}}</a>
    </div>
</div>
<!-- Sidebar -->