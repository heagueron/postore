@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')

    @include('partials.nav')

    <div class="d-flex justify-content-center">
        <h1>Check Your Remote Job Post: {{ $remjob->position }}</h1>
    </div>

    <hr class="m-5">

    <div class="row">


    <div class="col-9">
        <!--Main job preview -->
        <div class="rp-row " style="padding:0">


            @if( $remjob->yellow_background )
            <div class="row rp-row__header job-box rp-row__highlight">
            @else
            <div class="row rp-row__header job-box rp-row__standard">
            @endif

                <div class="col">
                    @if( $remjob->company->logo != null and $remjob->show_logo )
                        <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="LOGO">
                    @else
                        <p style="font-size:2.0rem;">{{ Str::of( $remjob->company->name )->substr(0, 1) }}</p>
                    @endif
                </div>

                <div class="col-3 mt-3">
                    <h5 class="mb-1 rp-job-title"> {{ ucwords( $remjob->position ) }} </h5>
                    <a  class="mb-1 company-badge company-brand"
                        title="{{'browse '.$remjob->company->name.' jobs'}}"
                        data-toggle="tooltip"
                        href="#"  
                        >
                        {{ $remjob->company->name }}
                    </a>
                    
                    <p class="rp-location"> {{ strtoupper( $remjob->locations ) }} </p>

                </div>

                <div class="col">
                </div>


                {{-- TAGS --}}
                <div class="col-4 pb-7">
                    @foreach( $remjob->tags as $tag )
                        <a href="#" class="job-badget">
                            <button class="rp-tag-item">
                                {{ $tag->name }}
                            </button>&nbsp;
                        </a>                 
                    @endforeach
                </div>

                <div class="col mt-3">
                    <p class="job-date">{{ $remjob->created_at->diffForHumans() }}</p>
                </div>

                <div class="col-2">
                    @if( $remjob->apply_email == null )
                        <a  href="{{ $remjob->apply_link }}" target="_blank"
                            class="rp-jobrow__apply__checkout"> 
                    @else
                        <a  href="mailto:{{ $remjob->apply_email }}" target="_blank"
                            class="rp-jobrow__apply__checkout"  rel="noindex nofollow">  

                    @endif
                            {{ __('Apply') }}
                        </a>
                </div>

            </div>

            <div class="rp-row__body" id="{{ 'position-' . $remjob->id}}">
                
                <!-- <p>{{ $remjob->description }}</p> -->
                <div class="p-5">{!! $remjob->description !!}</div>

                @if($remjob->min_salary)
                    <p class="pl-5">
                        <span style="font-weight:bold;">{{__('Min. Annual Salary: ')}}</span>
                        <span>${{ number_format($remjob->min_salary,0,'.',',') }}</span>
                    </p>
                @endif
                @if($remjob->max_salary)
                    <p class="pl-5">
                        <span style="font-weight:bold;">{{__('Max. Annual Salary: ')}}</span>
                        <span>${{ number_format($remjob->max_salary,0,'.',',')  }}</span>
                    </p>
                @endif

                @if($remjob->locations)
                    <h4 class="pl-5">{{__('Location')}}</h4>
                    <p class="pl-5">{{ $remjob->locations }}</p>
                @endif

                <div class="d-flex pl-5">

                    <p class="mr-2"> {{__('See all jobs at ')}}</p>
                    <p>
                        <a class="company-brand" href="#" >
                            {{ $remjob->company->name }}
                        </a>
                    </p>
                    


                </div>
            </div>

        </div>
        <!--End of Main job preview -->
    </div>

    <div class="col-3">
            
    <table class="table">
    <thead>
      <tr>
        <th>{{__('Your Job Post has')}}</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

      <tr>
        <td style="color:#4CAF50;">Basic post</td>
        <td>{{ \App\Option::find(1)->value }}</td>
      </tr>
      <tr>
        <td>Show company logo</td>
        <td>{{ $remjob->show_logo ? \App\Option::find(2)->value : '--' }}</td>
      </tr>
      <tr>
        <td>Highlight in yellow</td>
        <td>{{ $remjob->yellow_background ? \App\Option::find(3)->value : '--' }}</td>
      </tr>
      <tr>
        <td>On frontpage 2 weeks</td>
        <td>{{ $remjob->main_front_page ? \App\Option::find(4)->value : '--' }}</td>
      </tr>
      <tr>
        <td>On frontpage of category 2 weeks</td>
        <td>{{ $remjob->category_front_page ? \App\Option::find(5)->value : '--' }}</td>
      </tr>

      <tr>
        <td><strong>{{__('Total')  }}</strong></td>
        <td><strong>${{ $remjob->total }}</strong></td>
      </tr>

    </tbody>
  </table>

  <div class="d-flex justify-content-center flex-column">

        <a  href="#" target="_blank"
            class="rp-jobrow__apply__checkout"> 
            {{ __('Buy this') }}
        </a>
        <p>LINK: {{ $remjob->gumroad_link }}</p>
        <p>GR ID: {{ $remjob->gumroad_product_id }}</p>

  </div>

        </div>

    </div>

@endsection