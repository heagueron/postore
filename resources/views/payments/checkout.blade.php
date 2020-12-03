@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')

    @include('partials.nav')

    <div class="d-flex justify-content-center">
        <h1>Check Your Remote Job Post: {{ $remjob->position }}</h1>
    </div>

    <hr class="m-5">

    <div class="row p-5">


    <div class="col-9">
        <!--Main job preview -->
        <h3><i>Here is how your job post will look in main page:</i></h3>
        <x-jobrow :remjob="$remjob" page='checkout'/>

        <h3 class="mt-5"><i>Here is how your job post detail page will look:</i></h3>

 
            <div class="mt-5">

                <p>{{ __(
                    'show.postDate',
                    [   'postDate' => \Carbon\Carbon::parse($remjob->created_at)->toFormattedDateString()] 
                    ) }}
                </p>

                <h3 style="font-weight:bold;">{{ $remjob->position }}</h3>
                <div>
                    @foreach( $remjob->tags()->take(5)->get() as $tag )
                        <a href="#"  class="job-badget">
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
                    
                    @if( $remjob->total != null or $remjob->external_api != 'https://remoteok.io')
                        <div>{!! $remjob->description !!}</div>
                    @else
                        <p>{{ __('Press Apply to get this remote job details.') }}</p>
                    @endif

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
                        <a  href="#"
                            class="rp-jobrow__apply mt-4 mb-4" target="_blank"> 
                    @else
                        <a  href="#"  
                            class="rp-jobrow__apply mt-4 mb-4" target="_blank" rel="noindex nofollow">  
                    @endif
                        {{ __('Apply for this job') }}
                    </a>

                    <div class="d-flex mt-4 mb-4">

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
        <td>{{ '' }}</td>
      </tr>
      <tr>
        <td>{{ $remjob->plan->name }}</td>
        <td>{{  $remjob->plan->value }}</td>
      </tr>

      <tr>
        <td>{{ __('text.crDuration', ['duration' => \App\Option::find(1)->value]) }}</td>
        <td>{{ '' }}</td>
      </tr>
      <tr>
        <td>{{ __('text.crShareTwitter') }}</td>
        <td>{{ '' }}</td>
      </tr>

      @if( $remjob->plan->show_logo)
      <tr>
        <td>{{ __('text.crShowLogo') }}</td>
        <td>{{ '' }}</td>
      </tr>
      @endif

      @if( $remjob->plan->yellow_background)
      <tr>
        <td>{{ __('text.crYellowBG') }}</td>
        <td>{{ '' }}</td>
      </tr>
      @endif

      @if( $remjob->plan->main_front_page)
      <tr>
        <td>{{ __('text.crMFP') }}</td>
        <td>{{ '' }}</td>
      </tr>
      @endif

      @if( $remjob->plan->category_front_page)
      <tr>
        <td>{{ __('text.crMCP') }}</td>
        <td>{{ '' }}</td>
      </tr>
      @endif

      <tr>
        <td><strong>{{__('Total')  }}</strong></td>
        <td><strong>${{ $remjob->total }}</strong></td>
      </tr>

    </tbody>
  </table>

  <div class="d-flex justify-content-center flex-column text-center">

        <a  href="#" target="_blank"
            class="rp-jobrow__apply__checkout"> 
            {{ __('Buy this') }}
        </a>
        <p>LINK: {{ $remjob->plan->gumroad_link }}</p>
        <p>GR ID: {{ $remjob->plan->gumroad_product_id }}</p>

  </div>

        </div>

    </div>

@endsection