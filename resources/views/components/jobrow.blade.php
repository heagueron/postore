

<div class="rp-row " style="padding:0">


    @if( $remjob->highlight_yellow )
    <div class="row rp-row__header job-box rp-row__highlight" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}" style="margin-left:0;margin-right:0;">
    @else
    <div class="row rp-row__header job-box rp-row__standard" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}" style="margin-left:0;margin-right:0;">
    @endif

        {{-- LOGO --}}
        <div class="col">

            @if( $remjob->total != null )
                @if( $remjob->company->logo != null and $remjob->show_logo )
                    <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="LOGO">
                @else
                    <p style="font-size:2.0rem;">{{ Str::of( $remjob->company->name )->substr(0, 1) }}</p>
                @endif
            @else
                @if( $remjob->company->logo != null and $remjob->show_logo )
                    <img src="{{ $remjob->company->logo }}" alt="LOGO" class="w-100">
                @else
                    <p style="font-size:2.0rem;">{{ Str::of( $remjob->company->name )->substr(0, 1) }}</p>
                @endif
            @endif

        </div>

        {{-- POSITION COMPANY LOCATIONS --}}
        <div class="col-3 mt-3">
            <h5 class="mb-1 rp-job-title"> {{ ucwords( $remjob->position ) }} </h5>
            <a  class="mb-1 company-badge company-brand"
                title="{{'browse '.$remjob->company->name.' jobs'}}"
                data-toggle="tooltip"
                href="{{  route( 'remjobs.searchByCompany', $remjob->company->slug )  }}"  
                >
                {{ $remjob->company->name }}
            </a>
            
            <p class="rp-location"> {{ strtoupper( $remjob->locations ) }} </p>

        </div>

        <div class="col">
        </div>

        {{-- TAGS --}}
        <div class="col-4 pb-7">
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

        {{-- TIME AGO --}}
        <div class="col mt-3">
            <p class="job-date">{{ $remjob->created_at->diffForHumans() }}</p>
        </div>

        {{-- APPLY --}}
        <div class="col-2">
            @if( $remjob->apply_email == null )
                <a  href="{{ $remjob->apply_link }}"
                    class="rp-jobrow__apply" target="_blank"> 
            @else
                <a  href="mailto:{{ $remjob->apply_email }}"  
                    class="rp-jobrow__apply" target="_blank" rel="noindex nofollow">  

            @endif
                    {{ __('Apply') }}
                </a>
        </div>

    </div>

    {{-- DESCRIPTION --}}
    <div class="rp-row__body collapse" id="{{ 'position-' . $remjob->id}}"  data-parent="#rp-accordion" >
        
        @if( $remjob->total != null or $remjob->external_api != 'https://remoteok.io')
            <div class="pl-5">{!! $remjob->description !!}</div>
        @else
            <p class="pl-5">{{ __('Press Apply to get this remote job details.') }}</p>
        @endif

        @if($remjob->locations)
            <h4 class="pl-5">{{__('Location')}}</h4>
            <p class="pl-5">{{ $remjob->locations }}</p>
        @endif

        <div class="d-flex pl-5">

            <p class="mr-2"> {{__('See all jobs at ')}}</p>
            <p>
                <a class="company-brand" href="{{  route( 'remjobs.searchByCompany', $remjob->company->slug )  }}" >
                    {{ $remjob->company->name }}
                </a>
            </p>
            


        </div>
    </div>

</div>
  
  
  
  
  
  
  