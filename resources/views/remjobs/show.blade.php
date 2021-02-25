@extends('layouts.app')

@section('title', 'Remote Resources | Welcome')

@section('content')

    @include('partials.nav')

    @include('subscribers.create')
    
    <div class="container" style="margin-top:7rem;">

        <div class="d-flex justify-content-between mt-5">

            <a href="{{ route('landing') }}" style="color:#4CAF50;">
                <i class="fas fa-arrow-left"></i>{{__('show.back')}}
            </a>

            @if( $remjob->category )
            <a href="{{route('remjobs.searchByTags', 'remote-' .$remjob->category->tag.'-jobs')}}" style="color:#4CAF50;">
                {{ __('show.browseCategory', ['category' => $remjob->category->name]) }}<i class="fas fa-arrow-right"></i>
            </a>
            @endif

        </div>


        <div class="row mt-5">
            <div class="col-lg-9 col-sm-12 remjob-description">

                <p>{{ __(
                    'show.postDate',
                    [   'postDate' => \Carbon\Carbon::parse($remjob->created_at)->toFormattedDateString()] 
                    ) }}
                </p>

                <h3 style="font-weight:bold;">{{ $remjob->position }}</h3>
                <div>
                    @foreach( $remjob->tags()->take(5)->get() as $tag )
                        <a href="{{  route( 'remjobs.searchByTags', 'remote-'.$tag->name.'-jobs' )  }}"  class="job-badget">
                            <button 
                                class="rp-tag-item"  
                                title="{{'browse '.$tag->name.' jobs'}}"
                                data-toggle="tooltip"
                                data-placement="top">
                                {{ $tag->name }}
                            </button>&nbsp;
                        </a>                
                    @endforeach
                </div>

                {{-- DESCRIPTION --}}
                <div class="mt-5">
                    <div>{!! $remjob->description !!}</div>
                   

                    @if($remjob->min_salary)
                        <p class="mt-2">
                            <span style="font-weight:bold;">{{__('Min. Annual Salary: ')}}</span>
                            <span>${{ number_format($remjob->min_salary,0,'.',',') }}</span>
                        </p>
                    @endif
                    @if($remjob->max_salary)
                        <p>
                            <span style="font-weight:bold;">{{__('Max. Annual Salary: ')}}</span>
                            <span>${{ number_format($remjob->max_salary,0,'.',',')  }}</span>
                        </p>
                    @endif

                    @if($remjob->locations)
                        <h4 class="mt-2">{{__('Location')}}</h4>
                        <p class= >{{ $remjob->locations }}</p>
                    @endif

                    @if( $remjob->apply_email == null )
                        <a  href="{{ $remjob->apply_link }}"
                            class="rp-jobrow__apply mt-4 mb-4" target="_blank"> 
                    @else
                        <a  href="mailto:{{ $remjob->apply_email }}"  
                            class="rp-jobrow__apply mt-4 mb-4" target="_blank" rel="noindex nofollow">  
                    @endif
                        {{ __('Apply for this job') }}
                    </a>

                    <div class="d-flex mt-4 mb-4">

                        <p class="mr-2"> {{__('See all jobs at ')}}</p>
                        <p>
                            <a class="company-brand" href="{{  route( 'remjobs.searchByCompany', $remjob->company->slug )  }}" >
                                {{ $remjob->company->name }}
                            </a>
                        </p>
                        
                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-sm-12">
                <div class="card bg-light pb-2 card-company">
                    <div class="card-body text-center">

                        @if( $remjob->external_api == null )
                            @if( $remjob->company->logo != null and $remjob->plan->show_logo )
                                <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" width="60" height=auto>
                            @else
                                <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="w-50" >
                            @endif
                        @else
                            @if( $remjob->company->logo != null )
                                <img src="{{ $remjob->company->logo }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" width="80" height=auto>
                            @else
                                <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="w-50" >
                            @endif
                        @endif

                        <h3 class="mt-4 mb-4">{{ $remjob->company->name }}</h3>

                        <hr class="m-4">

                        @if( in_array( strtoupper( $remjob->locations ), ['WORLDWIDE', 'GLOBAL', 'ANYWHERE'] ) )
                            <p class="rp-location mt-4 mb-4"><i class="fa fa-globe" aria-hidden="true" style="color:#668cff;"></i></i> {{ strtoupper( $remjob->locations ) }} </p>
                        @elseif( $remjob->locations != null )
                            <p class="rp-location mt-4 mb-4"><i class="fa fa-map-marker" style="color:#4CAF50;"></i> {{ strtoupper( $remjob->locations ) }} </p>
                        @endif

                        @if( $remjob->apply_email == null )
                            <a  href="{{ $remjob->apply_link }}"
                                class="rp-jobrow__apply mt-4 mb-4" target="_blank"> 
                        @else
                            <a  href="mailto:{{ $remjob->apply_email }}"  
                                class="rp-jobrow__apply mt-4 mb-4" target="_blank" rel="noindex nofollow">  
                        @endif
                            {{ __('Apply') }}
                        </a>

                        <hr class="m-4">

                        <a href="{{ route('landing') }}" style="color:#4CAF50;">
                            {{__('show.allJobs')}}<i class="fas fa-arrow-right"></i>
                        </a>




                    </div>
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

        @if( \App\Remjob::where('category_id', $remjob->category_id )->count() > 1 )                
            <div class="d-flex flex-column align-content-center justify-content-center my-5">
                
                <h5 style="font-weight:bold" class="mb-4">{{ __('show.similarJobs', ['category' => $remjob->category->name]) }}</h5>
                    
                @foreach( \App\Remjob::where('category_id', $remjob->category_id )
                                        ->where("id", "!=", $remjob->id)
                                        ->take(5)
                                        ->orderBy('created_at', 'desc')
                                        ->get() as $remjob )    
                    <x-jobrow :remjob="$remjob" page='landing'/>
                @endforeach

            </div>
        @endif

    </div>
    

@endsection

