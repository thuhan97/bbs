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
                @if(View::hasSection('breadcrumbs'))
                    @yield('breadcrumbs')
                @else
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">{{__l('Home')}}
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
            @endif
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
                            <a class="dropdown-item" href="#">Quản lý thời gian</a>
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