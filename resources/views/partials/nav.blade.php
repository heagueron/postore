
<nav class="navbar navbar-expand-md navbar-light bg-transparent" id="app-nav">
<!-- <nav class="navbar navbar-expand-md navbar-light" style="background-image:url( {{ asset('images/green-bg.png') }} )" id="app-nav"> -->
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}" aria-current="page">
            <img src="{{ asset('images/remjob7.png') }}" alt="Remote Positions" class="w-15" >
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item nav-item__name">
                    <h3 style="font-weight:bold;">{{ __('text.siteName') }}</h3>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @if( Request::path() == '/')
                    <li class="nav-item mr-5">
                        <a class="nav-link nav-link__post" href="{{ route('post_a_job') }}">{{ __('text.postAJob') }}</a>
                    </li>
                @endif
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item mr-2">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown mr-2">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('auth.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                

            </ul>
        </div>
    </div>
</nav>