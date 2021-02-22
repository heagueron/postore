@extends('layouts.app')

@section('title', 'Information')

@section('content')

    @include('partials.nav')

    <div class="d-flex justify-content-center mt-3">
        <h1>{{ $title }}</h1>
    </div>

    <hr class="m-5">

    <div class="container">
        <div class="d-flex justify-content-center align-content-center flex-column text-center">
            
            <div class="mb-5">
                {{ $message }}
            </div>
                
            <div class="mt-5 mb-5">
                <a href="{{ route('landing') }}" class="footer__post">
                    {{ __('text.siteName') }}
                </a>
            </div>

        </div>
    </div>

@endsection