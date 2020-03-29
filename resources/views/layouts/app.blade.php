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
            
                <div id="sidebarCollapse" class="mr-5"><i class="fas fa-bars fa-2x"></i></div>
                <a class="navbar-brand" href="{{ url('/') }}">
                    Postore
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sposts.schedule') }}">Scheduler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Statistics</a>
                        </li>

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

        <div class="row">

            <div class="col-md-2 col-sm-12" style="display:none;" id="p-sidebar">

                <div class="postore_left_icon_menu">
                    <ul class="list-unstyled components" style="border:none;">
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DR</a>
                        </li>
                    </ul>
                </div>

                <div class="postore_left_expanded_menu">

                    <ul class="list-unstyled components" style="border:none;">
 
                        <li class="mb-3">
                            <a href="{{ route('sposts.schedule') }}">SCHEDULER</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">SOCIAL ACCOUNTS</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">TIMETABLES</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">DRAFTS</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">FILE UPLOADS</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">SETTINGS</a>
                        </li>
                        <li class="mb-3">
                            <a href="#">HELP</a>
                        </li>
                    </ul> 
                </div>
                

                
                
            </div>

            <div class="col-12" id="p-content">
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