<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CoreUI CSS -->
 <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous">

 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

 <title>{{ __('Remote Jobs') }}</title>

 <!-- Favicon -->
 <link rel="icon" href="{{ asset('storage/images/remjob.png') }}" type="image/png">

 </head>

 <body class="c-app">
 
    <div class="c-wrapper">

        <div class="c-body">
            <main class="c-main" style="padding-top: 0.2rem;">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <flash  class="alert-flash" message="{{ session('flash') }}"></flash>
                <fail  class="alert-flash" message="{{ session('fail') }}"></fail>
            </main>
        </div>

    </div>

 <!-- Optional JavaScript -->
 <!-- Popper.js first, then CoreUI JS -->
 <script src="https://unpkg.com/@popperjs/core@2"></script>
 <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
 </body>
</html>

