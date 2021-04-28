@extends('layouts.app')

@section('title', 'Remjob | Api Documentation')

@section('content')

    <div class="sp_page sp_center">
       
        @include('partials.nav')

        <section class="sp_intro mt-4">

            <div class="sp_center">
                <div class="mt-5 sp_intro__img_container">
                    <img src="{{ asset('images/api.png') }}" alt="api docs page image" class="sp_intro__topImg">
                </div>
                
                <h3 class="sp_intro__title mt-5">Remjob API Endpoints</h3>

            </div>

            <p class="sp_intro__description mt-5 mb-3 mx-3">
                This API and its documentation are intended to provide a subset of the functionalities at Remjob IO.
            </p>

            <p class="sp_intro__description mt-3 mb-3 mx-3">
                All Remjob API endpoints are rooted in https://remjob.io/api/v1.
            </p>

            <p class="sp_intro__description mt-3 mb-3 mx-3">
                All Remjob API endpoints return a standard Json representation of the requested data.<br>  
            </p>

            <ul class="sp_list">
                <li class="my-4">
                    List all jobs:
                    <p style="color:#4CAF50;">https://remjob.io/api/v1/remjobs</p>
                    Returns recent 150 remote jobs.
                </li>
            </ul>

        </section>


        <div class="sp_wrapper sp_center">




            <section class="sp_elements mb-5">


                <div class="sp_center text-center">
                    <h1 class="sp_elements__title my-4">Have additional questions?</h1>

                    <a href="mailto:info@remjob.io?subject=Additional questions&amp;body=Hello. I need additional information about Remjob IO API ... %0A%0A%0A" style="color:#367c39; text-decoration:underline;">
                        Send an email to us.
                    </a>
                </div>

            </section>

        </div> <!-- sp_wrapper -->
        

    </div> <!-- sp_page -->


@endsection