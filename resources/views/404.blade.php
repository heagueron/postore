<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="remote jobs">
    <meta name="author" content="Hector Aguero - heagueron@gmail.com">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ __('Remote Positions | 404') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/logo.png') }}" type="image/png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .pr-404 {

            /* Full height */
            height: 100%; 

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .pr-404__title{
            font-size: 20rem;
            color:red;
        }
        .pr-404__description{
            font-size: 2rem;
            color:green;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="pr-404" style="background-image:url( {{ asset('storage/images/universe.jpg') }} )" id="app">

            <h1 class="pr-404__title">404</h1>
            <h3 class="pr-404__description">We searched all over the universe.</h3>
            <h3 class="pr-404__description">That page or job type does not exist.</h3>
            <div class="nav__actions">
                <a href="{{ route('landing') }}" alt="Home" class="post-button">{{ __('Home') }}</a>
            </div>
        
    </div>

</body>
</html>