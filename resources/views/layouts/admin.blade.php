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

 <title>{{ __('Remote Jobs') }}</title>

 <!-- Favicon -->
 <link rel="icon" href="{{ asset('images/remjob.png') }}" type="image/png">

 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>

 <!-- Datatable -->
 <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



 <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

 <body class="c-app">
 
    @include('partials.menu')

    <div class="c-wrapper" id="app">

        <!-- <header class="c-header c-header-light c-header-fixed">
        </header> -->
        
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <flash  class="alert-flash" message="{{ session('flash') }}"></flash>
                <fail  class="alert-flash" message="{{ session('fail') }}"></fail>
            </main>
        </div>
        <footer class="c-footer">
            <div><a href="https://coreui.io">CoreUI</a> © 2020 creativeLabs.</div>
            <div class="mfs-auto">Powered by&nbsp;<a href="https://coreui.io/pro/">CoreUI Pro</a></div>
        </footer>

    </div>

    <!-- Optional JavaScript -->
    <!-- Popper.js first, then CoreUI JS -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
</body>
</html>

