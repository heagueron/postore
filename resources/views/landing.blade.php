@extends('layouts.app')

@section('title', 'Remote Resources | Welcome')

@section('content')

    @include('partials.hero')
    @include('subscribers.create')
   
    <div class="d-flex flex-column">

        @if( !$request->is('worldwide_remote_jobs') )
            <div class="worlwide-filter mt-2 mr-4 ml-auto"><a href="{{ route('remjobs.worlwide') }}">⬜️	Show only worldwide jobs </a></div>
        @else 
            <div class="worlwide-filter mt-2 mr-4 ml-auto"><a href="{{ route('landing') }}">✅ Show only worldwide jobs </a></div>
        @endif

        <div class="row mt-3">

            <div class="col-sm-12 col-lg-3">
                @include('partials.categories')

                <div class="text-center mt-4">
                    {{-- Open Subscribe Modal --}}
                    <button type="button" class="btn remjob-button" data-toggle="modal" data-target="#createSubscriberModal">
                        {{__('I want to subscribe')}}
                    </button>
                </div>
                
            </div>

            <div class="col-sm-12 col-lg-9">
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

