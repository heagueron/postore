@extends('layouts.app')

@section('title', 'Remote Jobs | Welcome')

@section('content')

    @include('partials.hero')
    @include('subscribers.create')
   
    <div class="d-flex flex-column">

        @if( !$request->is('worldwide_remote_jobs') )
            <div class="worlwide-filter mt-2 mr-4 ml-auto"><a href="{{ route('remjobs.worlwide') }}">{{__('text.onlyWorldwide')}}</a></div>
        @else 
            <div class="worlwide-filter mt-2 mr-4 ml-auto"><a href="{{ route('landing') }}">{{__('text.notOnlyWorldwide')}}</a></div>
        @endif

        <div class="row mt-3">

            <div class="col-sm-12 col-lg-3">

                <div class="d-flex flex-column cat-subs-col">

                    <!--the original select box is surrounded with a "rj-custom-select" DIV element.-->
                    <div class="rj-custom-select" id="rj-custom-select" data-true-tag="{{ $trueTag  ?? '' }}">
                        <select class="rj-select">
                            @foreach( $categories as $category )
                                @if( $selectedCategory->id == $category->id )
                                    <option selected value="{{ $category->tag }}">{{ $category->name }}</option>
                                @else 
                                    <option value="{{ $category->tag }}" data-tag="{{ $category->tag }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="subscribe-invitation-card my-3" 
                        style="background-image:url( {{ asset('images/news1.jpg') }} ), linear-gradient(45deg, #003333, #ffffff);" >

                        <h3 class="mb-5" style="color:white; float:right;font-weigth:bold;width:45%;">Never miss the news!</h3>
                        {{-- Open Subscribe Modal --}}
                        <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#createSubscriberModal">
                            {{__('text.subscribeLabel')}}
                        </button>
                    </div>
                    
            
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

