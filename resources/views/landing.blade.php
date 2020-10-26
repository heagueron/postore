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
            @foreach( $remjobs as $remjob)
                <x-jobrow :remjob="$remjob" />
            @endforeach
        </div>

    </div>
    

@endsection

