
@extends('layouts.app')

@section('title', 'Remote Resources | Welcome')

@section('content')

    @include('partials.nav')
   
    <div class="container">

        <div class="mt-5">

            <h1>{{ __('privacy.title') }}</h1>
            <p>{{ __('privacy.updated') }}</p>

            @if( App::isLocale('es') )
                <div>{!! \App\TextOption::find(3)->value !!}</div>
            @else
                <div>{!! \App\TextOption::find(2)->value !!}</div>
            @endif
        </div>

    </div>

@endsection