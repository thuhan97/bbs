<!--Main Navigation-->
<header>
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container-fluid">

            <!-- Brand -->
            <a class="navbar-brand waves-effect" href="/">
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
                    <li class="nav-item {{ \App\Utils::checkRoute(['work_time']) ? 'active': '' }}">
                        <a href="{{route('work_time')}}" class="nav-link waves-effect">{{__l('work_time')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item {{ \App\Utils::checkRoute(['day_off']) ? 'active': '' }}">
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
                </ul>
                <!-- Right -->
                <ul class="navbar-nav nav-flex-icons">
                    <li class="nav-item">
                        <span class="nav-link disabled">
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true"
                           aria-expanded="false">{{Auth::user()->name}}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('profile')}}">{{__l('Profile')}}</a>
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