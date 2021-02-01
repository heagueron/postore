<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="remote jobs">
    <meta name="author" content="Hector Aguero - heagueron@gmail.com">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield( 'title' )</title>
    <!-- <title>{{ __('Remote Resources | Welcome') }}</title> -->

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/remjob.png') }}" type="image/png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- GUMROAD -->
    <script src="https://gumroad.com/js/gumroad.js"></script>
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d67ba59f50.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" /> -->


    <!-- include summernote css -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">


</head>
<body>

    <div id="app" class="content">

    <input style="display:none;" id="appURL" value="{{ config('app.url') }}">

            @yield('content')

                
            @if( session()->has('message') )
                <div class="alert alert-primary" role="alert">
                    <strong>{{ session()->get('message')}}</strong>
                </div>
            @endif

            <flash  class="alert-flash" message="{{ session('flash') }}"></flash>
            <fail  class="alert-flash" message="{{ session('fail') }}"></fail>

        
    </div>

    <footer class="footer" id="app-footer">
        @include('partials.footer')
    </footer>

</body>
</html>