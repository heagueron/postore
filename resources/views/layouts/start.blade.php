<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield( 'title' )</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- Quick CSS -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/quick-website.css') }}">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 80vh;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            /*right: 10px;*/
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white justify-content-center">

        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="LOGO POSTORE" src="{{ asset('storage/images/logo.png') }}" id="navbar-logo" class="w-25">
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                
                @if (Route::has('login'))
                
                    <ul class="navbar-nav mt-4 mt-lg-0 ml-auto flex-center">

                        @auth
                            <li class="nav-item links nav__option">
                                <a href="{{ url('/home') }}" class="nav__option__link">Home</a>
                            </li>    
                        @else
                            <li class="nav-item links nav__option">
                                <a href="{{ route('login') }}" class="nav__option__link">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item links nav__option">
                                    <a href="{{ route('register') }}" class="nav__option__link">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                @endif

            </div>
        </div>
    </nav> 

    <div class="full-height flex-center">
        @yield('content')
    </div>   

</body>
</html>