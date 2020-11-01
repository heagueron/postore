@extends('layouts.app')

@section('title', 'Remote Resources | Welcome')

@section('content')

    @include('partials.hero')

   
    <div class="container">
        
        @include('partials.categories')

        <!-- <div class="banner-post-job">
            <p>{{ __('👉 Looking for remote position resources?') }}</p>
            <a href="post-a-job.php" alt="Post a job" class="post-button">{{ __('Post a Job') }}</a>
        </div> -->

        <div class="card-container"  id="rp-accordion">

            @forelse ( $remjobs as $remjob )
                <x-jobrow :remjob="$remjob" />
            @empty
                <p class="d-flex justify-content-center align-content-center">
                    {{ __('There are not remote jobs posted in the selected category.') }}
                </p>
            @endforelse

        </div>

    </div>
    

@endsection
