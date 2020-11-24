@extends('layouts.app')

@section('title', 'Information')

@section('content')

    @include('partials.nav')

    <div class="d-flex justify-content-center mt-3">
        <h1>Information</h1>
    </div>

    <hr class="m-5">

    <div class="container">
        <div class="d-flex justify-content-center align-content-center">
            {{ $message }}
        </div>
    </div>

@endsection