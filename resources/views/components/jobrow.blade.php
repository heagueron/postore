
<div class="rp-row">

    <a href="{{ $page=='checkout' ? '#' : route( 'remjobs.show', $remjob->slug ) }}" class="overlay"></a>
    
    @if( $remjob->yellow_background )
    <div class="row rp-row__header job-box rp-row__highlight inner" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}" style="margin-left:0;margin-right:0;">
    @else
    <div class="row rp-row__header job-box rp-row__standard inner" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}" style="margin-left:0;margin-right:0;">
    @endif
    

        {{-- LOGO --}}
        <div class="col-1">

            @if( $remjob->total != null )
                @if( $remjob->company->logo != null and $remjob->show_logo )
                    <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}">
                @else
                    <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="w-100" >
                @endif
            @else
                @if( $remjob->company->logo != null and $remjob->show_logo )
                    <img src="{{ $remjob->company->logo }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" width="80" height=auto>
                @else
                    <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="w-100" >
                @endif
            @endif

        </div>

        {{-- POSITION COMPANY LOCATIONS --}}
        <div class="col-3 mt-2 ml-2">
            <h5 class="mb-1 rp-job-title"> {{ ucwords( $remjob->position ) }} </h5>
            <a  class="mb-1 company-badge company-brand"
                title="{{'browse '.$remjob->company->name.' jobs'}}"
                data-toggle="tooltip"
                href="{{ $page=='checkout' ? '#' : route( 'remjobs.searchByCompany', $remjob->company->slug )  }}"  
                >
                {{ $remjob->company->name }}
            </a>
            @if( in_array( strtoupper( $remjob->locations ), ['WORLDWIDE', 'GLOBAL', 'ANYWHERE'] ) )
                <p class="rp-location"><i class="fa fa-globe" aria-hidden="true" style="color:#668cff;"></i></i> {{ strtoupper( $remjob->locations ) }} </p>
            @elseif( $remjob->locations != null )
                <p class="rp-location"><i class="fa fa-map-marker" style="color:#4CAF50;"></i> {{ strtoupper( $remjob->locations ) }} </p>
            @endif
            

        </div>

        <!-- <div class="col">
        </div> -->

        {{-- TAGS --}}
        <div class="col-4 pb-7">
            @foreach( $remjob->tags()->take(5)->get() as $tag )
            <a href="{{ $page=='checkout' ? '#' : route( 'remjobs.searchByTags', 'remote-'.$tag->name.'-jobs' )  }}"  class="job-badget">
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

    </div>

    {{-- DESCRIPTION --}}
    <div class="rp-row__body collapse" id="{{ 'positiom-' . $remjob->id}}"  data-parent="#rp-accordion" >
        
        @if( $remjob->total != null or $remjob->external_api != 'https://remoteok.io')
            <div class="pl-5">{!! $remjob->description !!}</div>
        @else
            <p class="pl-5">{{ __('Press Apply to get this remote job details.') }}</p>
        @endif

        @if($remjob->min_salary)
            <p class="pl-5 mt-2">
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
            <h4 class="pl-5 mt-2">{{__('Location')}}</h4>
            <p class="pl-5">{{ $remjob->locations }}</p>
        @endif

        <div class="d-flex pl-5 mt-2 mb-2">

            <p class="mr-2"> {{__('See all jobs at ')}}</p>
            <p>
                <a class="company-brand" href="{{  route( 'remjobs.searchByCompany', $remjob->company->slug )  }}" >
                    {{ $remjob->company->name }}
                </a>
            </p>
            


        </div>
    </div>

</div>



  
  
  
  
  
  
  