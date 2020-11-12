

<div class="rp-row " style="padding:0">


    @if( $remjob->highlight_yellow )
    <div class="row rp-row__header job-box rp-row__highlight" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}" style="margin-left:0;margin-right:0;">
    @else
    <div class="row rp-row__header job-box rp-row__standard" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}" style="margin-left:0;margin-right:0;">
    @endif

        <div class="col">
            @if( $remjob->company_logo != null and $remjob->show_logo )
                <img src="{{ asset('storage/' . $remjob->company_logo ) }}" alt="LOGO">
            @else
                <p style="font-size:2.0rem;">{{ Str::of( $remjob->company_name )->substr(0, 1) }}</p>
            @endif
        </div>

        <div class="col-3 mt-3">
            <h5 class="mb-1 rp-job-title"> {{ ucwords( $remjob->position ) }} </h5>
            <a  class="mb-1 company-badge company-brand"
                title="{{'browse '.$remjob->company_name.' jobs'}}"
                data-toggle="tooltip"
                href="{{  route( 'remjobs.searchByCompany', $remjob->company_slug )  }}"  
                >
                {{ $remjob->company_name }}
            </a>
            
            <p class="rp-location"> {{ strtoupper( $remjob->locations ) }} </p>

        </div>

        <div class="col">
        </div>

        <div class="col-4 pb-7">
            @foreach( $remjob->tags as $tag )
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

        <div class="col mt-3">
            <p class="job-date">{{ $remjob->created_at->diffForHumans() }}</p>
        </div>

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

    <div class="rp-row__body collapse" id="{{ 'position-' . $remjob->id}}"  data-parent="#rp-accordion">
        
        <!-- <p>{{ $remjob->description }}</p> -->
        <div class="p-5">{!! $remjob->description !!}</div>

        @if($remjob->locations)
            <h4 class="pl-5">{{__('Location')}}</h4>
            <p class="pl-5">{{ $remjob->locations }}</p>
        @endif

        <div class="d-flex pl-5">

            <p class="mr-2"> {{__('See all jobs at ')}}</p>
            <p>
                <a class="company-brand" href="{{  route( 'remjobs.searchByCompany', $remjob->company_slug )  }}" >
                    {{ $remjob->company_name }}
                </a>
            </p>
            


        </div>
    </div>

</div>
  
  
  
  
  
  
  