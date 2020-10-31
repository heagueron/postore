<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="remote jobs">
    <meta name="author" content="Hector Aguero - heagueron@gmail.com">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield( 'title' )</title>
    <!-- <title>{{ __('Remote Resources | Welcome') }}</title> -->

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

</head>
<body>

    <div id="app">


            @yield('content')

                
            @if( session()->has('message') )
                <div class="alert alert-primary" role="alert">
                    <strong>{{ session()->get('message')}}</strong>
                </div>
            @endif

            <flash  class="alert-flash" message="{{ session('flash') }}"></flash>

        
    </div>
    
</body>
</html>