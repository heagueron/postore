@extends('layouts.app')

@section('title', 'Remote Resources | Welcome')

@section('content')

    @include('partials.hero')

   
    <div class="container">
        
        @include('partials.categories')

            <x-jobrow :remjob="$remjob" />

    </div>
    

@endsection

