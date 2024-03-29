
<div class="rp-row container">

    <a href="{{ $page=='checkout' ? '#' : route( 'remjobs.show', $remjob->slug ) }}" class="overlay"></a>
    
    @if( $remjob->external_api == null )

        @if( $remjob->plan->yellow_background )
        <div class="row rp-row__header job-box rp-row__highlight inner container" style="margin-left:0;margin-right:0;">
        @else
        <div class="row rp-row__header job-box rp-row__standard inner container" style="margin-left:0;margin-right:0;">
        @endif

    @else
        <div class="row rp-row__header job-box rp-row__standard inner container" style="margin-left:0;margin-right:0;">
    @endif
    

            {{-- LOGO --}}
            <div class="col-1">
                
                @if( $remjob->external_api == null )

                    {{-- remjob posts --}}
                    @if( $remjob->company->logo != null and $remjob->plan->show_logo )
                        <img src="{{ asset('storage/' . $remjob->company->logo ) }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" class="jobrow-company-logo">
                    @else
                        <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="jobrow-company-logo">
                    @endif

                @else

                    {{-- external apis posts --}}
                    @if( $remjob->company->logo != null )
                        <img src="{{ $remjob->company->logo }}" alt="{{ Str::of( $remjob->company->name )->substr(0, 1) }}" class="jobrow-company-logo">
                    @else
                        <img src="{{ asset('storage/logos/nologo.png') }}" alt="Remote Positions" class="jobrow-company-logo">
                    @endif

                @endif

            </div>

            {{-- POSITION --}}
            <div class="col-11 row">
            
                {{-- POSITION COMPANY LOCATIONS --}}
                <div class="col-sm-10 col-lg-5 mt-lg-3 mt-sm-2 ml-3">
                    <h5 class="mb-1 rp-job-title"> {{ ucwords( $remjob->position ) }} </h5>
                    <a  class="mb-1 company-badge company-brand"
                        title="{{'browse '.$remjob->company->name.' jobs'}}"
                        data-toggle="tooltip"
                        href="{{ $page=='checkout' ? '#' : route( 'remjobs.searchByCompany', $remjob->company->slug )  }}"  
                        >
                        {{ $remjob->company->name }}
                    </a>
                    @if( in_array( strtoupper( $remjob->locations ), ['WORLDWIDE', 'GLOBAL', 'ANYWHERE', 'REMOTE'] ) )
                        <p class="rp-location"><i class="fa fa-globe" aria-hidden="true" style="color:#668cff;"></i></i> {{ strtoupper( $remjob->locations ) }} </p>
                    @elseif( $remjob->locations != null )
                        <p class="rp-location"><i class="fa fa-map-marker" style="color:#4CAF50;"></i> {{ strtoupper( $remjob->locations ) }} </p>
                    @endif
                    

                </div>

                {{-- TAGS --}}
                <div class="col-sm-10 col-lg-4 mt-lg-4 pb-7 ml-3">
                    @foreach( $remjob->tags()->take(5)->get() as $tag )
                        @if( $tag->name != '')
                            <a href="{{ $page=='checkout' ? '#' : route( 'remjobs.searchByTags', 'remote_'.$tag->name.'_jobs' )  }}"  class="job-badget">
                                <button 
                                    class="rp-tag-item"  
                                    title="{{'browse '.$tag->name.' jobs'}}"
                                    data-toggle="tooltip"
                                    data-placement="top">
                                    {{ $tag->name }}
                                </button>&nbsp;
                            </a>
                        @endif               
                    @endforeach
                </div>

                {{-- TIME AGO --}}
                <div class="col-sm-10 col-lg-1 mt-3 ml-3">
                    <p class="job-date">{{ $remjob->created_at->diffForHumans() }}</p>
                </div>

            </div>

    </div>

</div>



  
  
  
  
  
  
  