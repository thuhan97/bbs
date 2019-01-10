<!-- Sidebar -->
<div class="sidebar-fixed position-fixed">

    <div class="text-center">
        <a href="/" class="logo-wrapper waves-effect">
            <img src="http://jvb-corp.com/img/logo.png" class="img-fluid" alt="">
        </a>
    </div>
    <div class="list-group list-group-flush">
        <a href="/"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['default']) ? 'active': '' }}">
            <i class="fas fa-chart-pie mr-3"></i>{{__l('Dashboard')}}
        </a>
        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">
            <i class="fas fa-map mr-3"></i>
            Quy định, Nội quy
        </a>

        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">
            <i class="fas fa-map mr-3"></i>
            Dự án</a>

        <a href="#" class="list-group-item list-group-item-action waves-effect disabled">
            <i class="fas fa-map mr-3"></i>
            Phòng họp</a>

        <a href="{{route('post')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['post', 'post_detail']) ? 'active': '' }}">
            <i class="fas fa-map mr-3"></i>{{__l('Post')}}</a>

        <a href="{{route('event')}}"
           class="list-group-item list-group-item-action waves-effect {{ \App\Utils::checkRoute(['event', 'event_detail']) ? 'active': '' }}">
            <i class="fas fa-table mr-3"></i>{{__l('Event')}}</a>
    </div>
</div>
<!-- Sidebar -->