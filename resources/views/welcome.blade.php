<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Hector Aguero">
    <title>{{ __('Postore | Welcome') }}</title>
    
    <!-- Preloader -->
    <style>
        @keyframes hidePreloader {
            0% {
                width: 100%;
                height: 100%;
            }

            100% {
                width: 0;
                height: 0;
            }
        }

        body>div.preloader {
            position: fixed;
            background: white;
            width: 100%;
            height: 100%;
            z-index: 1071;
            opacity: 0;
            transition: opacity .5s ease;
            overflow: hidden;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body:not(.loaded)>div.preloader {
            opacity: 1;
        }

        body:not(.loaded) {
            overflow: hidden;
        }

        body.loaded>div.preloader {
            animation: hidePreloader .5s linear .5s forwards;
        }
    </style>
    
    <script>
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.querySelector('body').classList.add('loaded');
            }, 300);
        });
    </script>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/logo.png') }}" type="image/png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset( 'app-assets/libs/@fortawesome/fontawesome-free/css/all.min.css' ) }}">
    <!-- Quick CSS -->
    <link rel="stylesheet" href="{{ asset( 'app-assets/css/quick-website.css' ) }}" id="stylesheet">
</head>

<body class="loaded">
    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-cookies" data-backdrop="false" aria-labelledby="modal-cookies" aria-hidden="true">
        <div class="modal-dialog modal-dialog-aside left-4 right-4 bottom-4">
            <div class="modal-content bg-dark-dark">
                <div class="modal-body">
                    <!-- Text -->
                    <p class="text-sm text-white mb-3">
                        We use cookies so that our themes work for you. By using our website, you agree to our use of cookies.
                    </p>
                    <!-- Buttons -->
                    <a href="#" class="btn btn-sm btn-white" target="_blank">Learn more</a>
                    <button type="button" class="btn btn-sm btn-primary mr-2" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="LOGO POSTORE" src="{{ asset('storage/images/logo.png') }}" id="navbar-logo" class="w-25">
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div>
                <p class="mt-4 font-weight-bold text-uppercase">Postore</p>
            </div>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">

                <ul class="navbar-nav mt-4 mt-lg-0 ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ url('/home') }}">Home</a>
                            </li>    
                        @else
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li> 
                            @endif

                        @endauth
                    @endif
                    
                    <!-- <li class="nav-item dropdown dropdown-animate" data-toggle="hover">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                        <div class="dropdown-menu dropdown-menu-single">
                            <a href="#" class="dropdown-item">Homepage</a>
                            <a href="#" class="dropdown-item">About us</a>
                            <a href="#" class="dropdown-item">Contact</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Login</a>
                        </div>
                    </li> -->
                    <!-- <li class="nav-item ">
                        <a class="nav-link" href="#">Docs</a>
                    </li> -->
                </ul>

            </div>

        </div>
    </nav>

    <!-- Main content -->

    <section class="slice py-3">
        <div class="container">
            <div class="row row-grid align-items-center">
                <div class="col-12 col-md-5 col-lg-6 order-md-2 text-center">
                    <!-- Image -->
                    <figure class="w-100">
                        <img alt="Image placeholder" src="{{ asset('app-assets/img/svg/illustrations/illustration-3.svg') }} " class="img-fluid mw-md-120">
                    </figure>
                </div>
                <div class="col-12 col-md-7 col-lg-6 order-md-1 pr-md-5">
                    <!-- Heading -->
                    <h1 class="display-4 text-center text-md-left mb-3">
                        Schedule your <strong class="text-primary">Twitter posts</strong>
                    </h1>
                    <!-- Text -->
                    <p class="lead text-center text-md-left text-muted">
                        Get your posting workflow optimized and grow your engagement.
                    </p>
                    <!-- Buttons -->
                    <div class="text-center text-md-left mt-5">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-icon">
                            <span class="btn-inner--text">{{ __( 'Get started' )}}</span>
                            <span class="btn-inner--icon"><i data-feather="chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="slice slice-lg pt-lg-6 pb-0 pb-lg-6 bg-section-secondary">
        <div class="container">
            <!-- Title -->
            <!-- Section title -->
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-6">
                    <span class="badge badge-soft-success badge-pill badge-lg">
                        {{ __( 'Get started' )}}
                    </span>
                    <h2 class=" mt-4">{{ __( 'Carefuly crafted functionality ready to use in your posts scheduling' )}}</h2>
                    <div class="mt-2">
                        <p class="lead lh-180">{{ __( 'Design, preview, test and schedule your posts' )}}</p>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="pt-4 pb-5">
                                <img src="{{ asset('app-assets/img/svg/illustrations/illustration-5.svg') }}" class="img-fluid img-center" style="height: 150px;" alt="Illustration">
                            </div>
                            <h5 class="h4 lh-130 mb-3">{{ __( 'Unleash you creativity' )}}</h5>
                            <p class="text-muted mb-0">{{ __( 'Create posts and their media that are easy to customize and change' )}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="pt-4 pb-5">
                                <img src="{{ asset('app-assets/img/svg/illustrations/illustration-6.svg') }}" class="img-fluid img-center" style="height: 150px;" alt="Illustration">
                            </div>
                            <h5 class="h4 lh-130 mb-3">{{ __( 'Get more results' )}}</h5>
                            <p class="text-muted mb-0">{{ __( 'By properly scheduling your content you can fine target your audience' )}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="pt-4 pb-5">
                                <img src="{{ asset('app-assets/img/svg/illustrations/illustration-7.svg') }}" class="img-fluid img-center" style="height: 150px;" alt="Illustration">
                            </div>
                            <h5 class="h4 lh-130 mb-3">{{ __( 'Increase your audience' )}}</h5>
                            <p class="text-muted mb-0">{{ __( 'More well planned posts mean more engaging, exposure and sales' )}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    

    <section class="slice slice-lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <span class="badge badge-primary badge-pill">{{__('Key features')}}</span>
                    <h5 class="lh-180 mt-4 mb-6">{{__('Postore allows you to schedule your posts -or statuses- in Twitter')}}</h5>
                </div>
            </div>
            <!-- Features -->
            <div class="row mx-lg-n4">
                <!-- Features - Col 1 -->
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-warning text-white mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <span class="h6">{{__('Scheduling')}}</span>
                                <p class="text-sm text-muted mb-0">
                                {{__('Setup your posts scheduling strategy ')}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-primary text-white mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <span class="h6">{{__('Analytics')}}</span>
                                <p class="text-sm text-muted mb-0">
                                    {{__('Check your most engaging content')}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-danger text-white mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <span class="h6">{{__('Automation')}}</span>
                                <p class="text-sm text-muted mb-0">
                                    {{__('Mass load posts from a file')}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-success text-white mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <span class="h6">300+ components</span>
                                <p class="text-sm text-muted mb-0">
                                    Built to be customized.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-info text-white mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <span class="h6">23+ widgets</span>
                                <p class="text-sm text-muted mb-0">
                                    Built to be customized.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div class="icon icon-shape rounded-circle bg-warning text-white mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                            <div>
                                <span class="h6">Bootstrap Flexbox Grid</span>
                                <p class="text-sm text-muted mb-0">
                                    Built to be customized.
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- Features - Col 3 -->
                <!--<div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div>
                                    <div class="icon icon-shape rounded-circle bg-info text-white mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="h6">Animate CSS</span>
                                <p class="text-sm text-muted mb-0">
                                    Built to be customized.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div>
                                    <div class="icon icon-shape rounded-circle bg-danger text-white mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="h6">Integrated plugins</span>
                                <p class="text-sm text-muted mb-0">
                                    Built to be customized.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 px-lg-4">
                    <div class="card shadow-none">
                        <div class="p-3 d-flex">
                            <div>
                                <div>
                                    <div class="icon icon-shape rounded-circle bg-primary text-white mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="h6">Smart HTML markup</span>
                                <p class="text-sm text-muted mb-0">
                                    Built to be customized.
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <section class="slice slice-lg bg-section-secondary">
        <div class="container text-center">
            <div class="row justify-content-center mb-6">
                <div class="col-lg-8">
                    <!-- Title -->
                    <h2 class="h1 strong-600">
                        {{ __('Complete features at your hand') }}
                    </h2>
                    <!-- Text -->
                    <p class="text-muted">
                        {{ __('Thousands of Twitter users around the world have already made Postore the main tool for automating their posting process.') }}
                    </p>
                </div>
            </div>
            <!-- Pricing -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md">
                    <div class="card card-pricing text-center px-3 hover-scale-110">
                        <div class="card-header py-5 border-0 delimiter-bottom">
                            <div class="h1 text-center mb-0">$<span class="price font-weight-bolder">49</span></div>
                            <span class="h6 text-muted">Standard License</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled text-sm mb-4">
                                <li class="py-2">1 end product</li>
                                <li class="py-2">Use for personal or a client</li>
                                <li class="py-2">Use in a free end product</li>
                                <li class="py-2">6 months technical support</li>
                            </ul>
                            <a href="#" class="btn btn-sm btn-warning hover-translate-y-n3 hover-shadow-lg mb-3">Purchase now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md">
                    <div class="card card-pricing bg-dark text-center px-3 border-0 hover-scale-110">
                        <div class="card-header py-5 border-0 delimiter-bottom">
                            <div class="h1 text-white text-center mb-0">$<span class="price font-weight-bolder">590</span></div>
                            <span class="h6 text-white">Extended License</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled text-white text-sm opacity-8 mb-4">
                                <li class="py-2">1 end product</li>
                                <li class="py-2">Use for personal or a client</li>
                                <li class="py-2">Use in a free end product</li>
                                <li class="py-2">Use in an end product that is <strong class="text-success text-underline--dashed">sold</strong></li>
                                <li class="py-2">6 months technical support</li>
                            </ul>
                            <a href="#" class="btn btn-sm btn-white hover-translate-y-n3 hover-shadow-lg mb-3">Purchase now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center">
                <p class="mb-2">
                    Both pricings contains all 6 months free support. Need more?
                </p>
                <a href="#" class="text-primary text-underline--dashed">Contact us<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right ml-2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
            </div>
        </div>
    </section>

    <footer class="position-relative" id="footer-main">
        <div class="footer pt-lg-7 footer-dark bg-dark">
            <!-- SVG shape -->
            <div class="shape-container shape-line shape-position-top shape-orientation-inverse">
                <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class=" fill-section-secondary">
                    <polygon points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <!-- Footer -->
            <div class="container pt-4">
                <div class="row">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <!-- Theme's logo -->
                        <a href="index.html">
                            <img alt="Image placeholder" src="{{ asset('storage/images/logo.png') }}" class="w-25" id="footer-logo">
                        </a>
                        <!-- Postore' mission -->
                        <p class="mt-4 text-sm opacity-8 pr-lg-4">
                            {{__('Postore was created to allow you to increase your Twitter engagement by automating your post scheduling process')}}
                        </p>
                        <!-- Social -->
                        <ul class="nav mt-4">
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="https://twitter.com/heagueron" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-6 col-sm-4 ml-lg-auto mb-5 mb-lg-0">
                        <h6 class="heading mb-3">Account</h6>
                        <ul class="list-unstyled">
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Settings</a></li>
                            <li><a href="#">Billing</a></li>
                            <li><a href="#">Notifications</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-6 col-sm-4 mb-5 mb-lg-0">
                        <h6 class="heading mb-3">About</h6>
                        <ul class="list-unstyled">
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Pricing</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-6 col-sm-4 mb-5 mb-lg-0">
                        <h6 class="heading mb-3">Company</h6>
                        <ul class="list-unstyled">
                            <li><a href="#">Community</a></li>
                            <li><a href="#">Help center</a></li>
                            <li><a href="#">Support</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="divider divider-fade divider-dark my-4">
                <div class="row align-items-center justify-content-md-between pb-4">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">
                            {{__('© 2020')}} <a href="#" class="font-weight-bold">{{ __('Postore') }}</a>{{ __('. All rights reserved') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Terms
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Privacy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Cookies
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core JS  -->
    <script src="{{ asset( 'app-assets/libs/jquery/dist/jquery.min.js' ) }}"></script>
    <script src="{{ asset( 'app-assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js' ) }}"></script>
    <script src="{{ asset( 'app-assets/libs/svg-injector/dist/svg-injector.min.js' ) }}"></script>
    <script src="{{ asset( 'app-assets/libs/feather-icons/dist/feather.min.js' ) }}"></script>
    <!-- Quick JS -->
    <script src="{{ asset( 'app-assets/js/quick-website.js' ) }}"></script>
    <!-- Feather Icons -->
    <script>
        feather.replace({
            'width': '1em',
            'height': '1em'
        })
    </script>


</body></html>

