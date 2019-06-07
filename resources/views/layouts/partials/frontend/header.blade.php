<!--Main Navigation-->
<?php
$notifications = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())->with('sender:id,avatar')->orderBy('created_at', 'desc')->take(100)->get();
$notificationCount = 0;
foreach ($notifications as $notification) {
    if ($notification->read_at == null)
        $notificationCount++;
}
?>
<header>
    <!-- Navbar -->
    {{--<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">--}}
    <nav id="main-nav" class="navbar fixed-top navbar-light white scrolling-navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="float-left ">
                <a href="#" data-activates="slide-out" class="navbar-toggler button-collapse"><i
                            class="fas fa-bars" style="color: white;margin-top: 5px"></i><span
                            class="sr-only" aria-hidden="true">Menu</span></a>
            </div>
            <!-- Brand -->
            <a class="navbar-brand waves-effect" href="/">
                <strong class="white-text">BBS</strong>
            </a>

            <!-- Collapse -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                {{--<span class="fas fa-grip-horizontal"></span>--}}
                <span class="far fa-address-card"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto custom-scrollbar">
                    <li class="d-none d-xl-block nav-item {{ \App\Utils::checkRoute(['work_time']) ? 'active': '' }}">
                        <a href="{{route('work_time')}}" class="nav-link waves-effect">{{__l('work_time')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item {{ \App\Utils::checkRoute(['day_off', 'day_off_approval']) ? 'active': '' }}">
                        <a href="{{route('day_off')}}" class="nav-link waves-effect">{{__l('day_off')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item {{ \App\Utils::checkRoute(['ask_permission']) ? 'active': '' }}">
                        <a href="{{route('ask_permission')}}"
                           class="nav-link waves-effect">{{__l('ask_permission')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item {{ \App\Utils::checkRoute(['punish']) ? 'active': '' }}">
                        <a href="{{route('punish')}}"
                           class="nav-link waves-effect">{{__l('Punish')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item  {{ \App\Utils::checkRoute(['report']) ? 'active': '' }}">
                        <a href="{{route('report')}}"
                           class="nav-link waves-effect">{{__l('Report')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item d-block d-md-none {{ \App\Utils::checkRoute(['report']) ? 'active': '' }}">
                        <a class="nav-link waves-effect"
                           href="{{route('changePassword')}}">{{__l('change_password')}}</a>
                    </li>
                    <li class="nav-item d-block d-md-none {{ \App\Utils::checkRoute(['report']) ? 'active': '' }}">
                        <a class="nav-link waves-effect"
                           href="{{route('logout')}}">{{__l('logout')}}
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item d-none d-sm-block">
                        <a class="nav-link waves-effect waves-light" id="nav_bar_avatar">
                            <img src="{{Auth::user()->avatar}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'"
                                 class="rounded-circle z-depth-0" alt="avatar image">
                        </a>
                    </li>
                    <li class="nav-item dropdown d-none d-sm-block">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                           role="button"
                           aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item d-none d-sm-block"
                               href="{{route('profile')}}">{{__l('Profile')}}</a>
                            <a class="dropdown-item" href="{{route('changePassword')}}">{{__l('change_password')}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="{{route('logout')}}">{{__l('logout')}}
                            </a>
                        </div>
                    </li>
                </ul>
                <!-- Right -->
                <ul class="navbar-nav mr-2">
                    <li class="nav-item dropdown">
                        <a style="font-size: 22px" class="nav-link position-relative" data-toggle="dropdown" href="#"
                           role="button" aria-expanded="false" id="btnNotification"><i class="bell fas fa-bell"></i></a>
                        @if($notifications->isNotEmpty())
                            <div class="badge position-absolute text-center lblNotifyBagde"
                                 data-count="{{$notificationCount}}">{{$notificationCount}}</div>
                            <div class="dropdown-menu dropdown-right z-depth-1" id="notification">
                                @foreach($notifications as $notification)
                                    <div class="dropdown-item notify-read-{{$notification->is_read}}"
                                         onclick="location.href='{{$notification->data}}'">
                                        <div class="notice-img text-center d-flex justify-content-center ">
                                            <img class="rounded-circle"
                                                 src="{{ $notification->sender->avatar ?? JVB_LOGO_URL}}"/>
                                        </div>
                                        <div class="notice-content ">
                                            <div class="wrap-text notice-title">{{$notification->title}}</div>
                                            <div class="text-gray wrap-text notice-text">{!! strip_tags($notification->content) !!}</div>
                                            <div class="text-gray">
                                                <i>
                                                    <span class="notice-icon {{NOTIFICATION_LOGO[$notification->logo_id] ?? NOTIFICATION_LOGO[0]}}"></span>
                                                    <span class="time-subcribe"
                                                          data-time="{{$notification->created_at}}"
                                                          title="{{$notification->created_at}}">{{get_beautiful_time($notification->created_at)}}</span>
                                                </i>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        @endif

                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- Navbar -->
    <div id="notification_template" class="hidden">
        <div class="dropdown-item notify-read-0">
            <div class="notice-img text-center d-flex justify-content-center ">
                <img class="rounded-circle" src="{{JVB_LOGO_URL}}"/>
            </div>
            <div class="notice-content ">
                <div class="wrap-text notice-title"></div>
                <div class="text-gray wrap-text notice-text"></div>
                <div class="text-gray">
                    <i>
                        <span class="notice-icon"></span>
                        <span class="time-subcribe"
                              data-time=""
                              title="">
                                                </span>
                    </i>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.frontend.sidebar')

</header>
<!--Main Navigation-->
@push('extend-js')
    <script>
        $(function () {
            $("#btnNotification").click(function () {
                if ($(".lblNotifyBagde").attr('data-count') == 0) {
                    $("#notification .dropdown-item").removeClass('notify-read-0').addClass('notify-read-1');
                } else {
                    $.ajax({
                        url: '{{route('notification_mark_read')}}',
                        dataType: 'JSON',
                        type: 'POST',
                        success: function (data) {
                            $(".lblNotifyBagde").attr('data-count', 0).text(0).hide();
                        }
                    })
                }
            });
        })
    </script>
@endpush
