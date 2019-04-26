<!--Main Navigation-->
<header>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand waves-effect" href="/">
                {{--<img src="http://jvb-corp.com/img/logo.png" class="img-fluid" alt="" width="50">--}}
                <strong class="blue-text">BBS</strong>
            </a>

            <!-- Collapse -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
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
                    <li class="nav-item {{ \App\Utils::checkRoute(['report']) ? 'active': '' }}">
                        <a href="{{route('report')}}"
                           class="nav-link waves-effect">{{__l('Report')}}
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
                </ul>
                <!-- Right -->
                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item dropdown">
                        <a class="nav-link waves-effect waves-light" id="nav_bar_avatar">
                            <img src="{{Auth::user()->avatar}}" onerror="this.src='{{URL_IMAGE_NO_IMAGE}}'"
                                 class="rounded-circle z-depth-0" alt="avatar image">
                        </a>
                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item d-none d-sm-block "
                               href="{{route('profile')}}">{{__l('Profile')}}</a>
                            <a class="dropdown-item" href="{{route('changePassword')}}">{{__l('change_password')}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="{{route('logout')}}">{{__l('logout')}}
                            </a>
                        </div>
                    </li>
                </ul>

            </div>

        </div>
    </nav>
    <!-- Navbar -->

    @include('layouts.partials.frontend.sidebar')

</header>
<!--Main Navigation-->