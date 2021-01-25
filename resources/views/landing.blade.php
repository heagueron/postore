@extends('layouts.app')

@section('title', 'Remote Resources | Welcome')

@section('content')

    @include('partials.hero')

   
    <div class="container">

        <div class="row mt-5">

            <div class="col-sm-12 col-lg-2">@include('partials.categories')</div>

            <div class="col-sm-12 col-lg-10">
                <div  id="rp-accordion">

                    @forelse ( $remjobs as $remjob )
                        <x-jobrow :remjob="$remjob" page='landing'/>
                    @empty
                        <p class="d-flex justify-content-center align-content-center">
                            {{ __('text.noRemjobs') }}
                        </p>
                    @endforelse

                </div>
            </div>

        </div>
        
        

        

    </div>
    

@endsection

