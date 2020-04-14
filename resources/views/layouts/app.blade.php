<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield( 'title' )</title>

    
    
    <!-- Bootstrap Datetime picker -->
    <!-- Minified Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- Minified JS library -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- Minified Bootstrap JS -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!-- Datetime picker -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/d67ba59f50.js" crossorigin="anonymous"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-primary navbar-dark shadow-sm">

                <a class="navbar-brand" href="{{ url('/') }}">
                    Postore
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('sposts.schedule') }}">Scheduler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Statistics</a>
                        </li> -->

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            
        </nav>

        <div class="d-flex flex-row">

            <div class="left-side-menu" id="p-sidebar">

                <div class="postore_left_icon_menu">
                    <ul class="list-unstyled components left-menu-icons" style="border:none;">
                        <li class="mb-3 icon-menu-option" title="Scheduler" data-toggle="tooltip">
                            <a href="{{ route('sposts.schedule') }}"><i class="far fa-calendar-alt"></i></a>
                        </li>
                        <li class="mb-3 icon-menu-option" title="Social Accounts" data-toggle="tooltip">
                            <a href="{{ route('social_profiles.index') }}"><i class="fas fa-user"></i></a>
                        </li>

                        <li class="mb-3 icon-menu-option" title="File Upload" data-toggle="tooltip">
                            <a href="{{ route('file-upload') }}"><i class="fas fa-upload"></i></a>
                        </li class="mb-3">

                        <li class="mb-3 icon-menu-option" title="Settings" data-toggle="tooltip">
                            <a href="{{ route('settings') }}"><i class="fas fa-cog"></i></a>
                        </li>

                        <li class="mb-3 icon-menu-option" title="Become Pro" data-toggle="tooltip">
                            <a href="{{ route('upgrade') }}"><i class="fas fa-rocket"></i></a>
                        </li>

                        <li class="mb-3 icon-menu-option" title="Frequently Asked Questions" data-toggle="tooltip">
                            <a href="{{ route('faq') }}"><i class="far fa-question-circle"></i></a>
                        </li>
                    </ul>
                </div>

                <div class="postore_left_expanded_menu col-sm-12">

                    <ul class="list-unstyled components" style="border:none;">
 
                        <li class="mb-3">
                            <a href="{{ route('sposts.schedule') }}">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>SCHEDULE</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('social_profiles.index') }}">
                                <i class="fas fa-user mr-2"></i>
                                <span>SOCIAL ACCOUNTS</span>
                            </a>
                        </li>

                        <li class="mb-3">
                            <a href="{{ route('file-upload') }}">
                                <i class="fas fa-upload mr-2"></i>
                                <span>FILE UPLOAD</span>
                            </a>
                        </li class="mb-3">

                        <li class="mb-3">
                            <a href="{{ route('settings') }}">
                                <i class="fas fa-cog mr-2"></i>
                                <span>SETTINGS</span>
                            </a>
                        </li>

                        <li class="mb-3" title="Become Pro">
                            <a href="{{ route('upgrade') }}">
                                <i class="fas fa-rocket mr-2"></i>
                                <span>UPGRADE</span>
                            </a>
                        </li>

                        <li class="mb-3">
                            <a href="{{ route('faq') }}">
                                <i class="far fa-question-circle mr-2"></i>
                                <span>FAQ</span>
                            </a>
                        </li>

                    </ul> 
                </div>
 
            </div>

            <div style="flex:5" id="p-content">
                <main class="py-4">
                    @if( session()->has('message') )
                        <div class="alert alert-primary" role="alert">
                            <strong>{{ session()->get('message')}}</strong>
                        </div>
                    @endif

                    <flash  class="alert-flash" message="{{ session('flash') }}"></flash>
                    
                    <div class="container">
                        @yield('content')
                    </div> 
                </main>
            </div>

        </div>
        

    </div>

    
</body>
</html>