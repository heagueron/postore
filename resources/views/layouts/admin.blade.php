<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <title>{{ __('Remjob ADMIN') }}</title>

 <!-- Favicon -->
 <link rel="icon" href="{{ asset('images/remjob.png') }}" type="image/png">

 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>

 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />


 <body>

    <div class="remjob-grid-container">

        <aside class="remjob-sidenav">
            
            @include('partials.menu')

        </aside>

        <main class="remjob-main">
            <div class="container-fluid">
                @yield('content')
            </div>
            <flash  class="alert-flash" message="{{ session('flash') }}"></flash>
            <fail  class="alert-flash" message="{{ session('fail') }}"></fail>
        </main>

    </div>

</body>
</html>

