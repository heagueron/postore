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

                <div class="d-flex flex-column">

                    <!-- <h2>RJ Custom Select</h2> -->

                    <!--surround the select box with a "rj-custom-select" DIV element. Remember to set the width:-->
                    <div class="rj-custom-select" id="rj-custom-select">
                        <select class="rj-select">
                            @foreach( $categories as $category )
                                @if( $selectedCategory->id == $category->id )
                                    <option selected value="{{ $category->tag }}">{{ $category->name }}</option>
                                @else 
                                    <option value="{{ $category->tag }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- <select class="wide mb-3" id="selectCategory2" style="marging-top:8px !important;">
                        @foreach( $categories as $category )
                            @if( $selectedCategory->id == $category->id )
                                <option selected value="{{ $category->tag }}" class="mt-2">{{ $category->name }}</option>
                            @else 
                                <option value="{{ $category->tag }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select> -->

                    

                    <div class="text-center my-5">
                    {{-- Open Subscribe Modal --}}
                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#createSubscriberModal">
                        {{__('I want to subscribe')}}
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

