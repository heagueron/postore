
<div class="card" style="margin:10px;" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}">
    
    <div class="card-header job-box">

        <div class="row rp-jobrow">

            <div class="col pr-2 pl-1 d-flex justify-content-center align-content-center ">
                @if( $remjob->company_logo != null )
                    <img src="{{ asset('storage/' . $remjob->company_logo ) }}" alt="LOGO" >
                @else
                    <p style="font-size:2.0rem;">{{ Str::of( $remjob->company_name )->substr(0, 1) }}</p>
                @endif
                
            </div>

            <div class="col-3 pr-2 pl-1">

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

            <div class="col pr-2 pl-1 d-flex justify-content-center align-content-center">
            </div>

            <div class="col-4 pr-2 pl-1 d-flex justify-content-center align-content-center">

                @foreach( $remjob->tags as $tag )
                    <a href="{{'remote-'.$tag->name.'-jobs'}}" class="job-badget">
                        <span 
                            class="badge badge-pill badge-light rp-tag"  
                            title="{{'browse '.$tag->name.' jobs'}}"
                            data-toggle="tooltip"
                            data-placement="top">
                            {{ $tag->name }}
                        </span>&nbsp;
                    </a>                 
                @endforeach

            </div>

            <div class="col-1 pr-2 pl-1 d-flex justify-content-center align-content-center">
                <p class="job-date">{{ $remjob->created_at->diffForHumans() }}</p>
            </div>

            <div class="col-2 pr-2 pl-1 d-flex justify-content-center align-content-center">
                <a href="{{ $remjob->apply_link }}"
                    class="rp-jobrow__apply" 
                    target="_blank">
                    
                    {{ __('Apply to this job') }}

                </a>
            </div>

        </div>

    </div>

    <div id="{{ 'position-' . $remjob->id}}" class="collapse" data-parent="#rp-accordion">

        <div class="card-body">

            <p>{{ $remjob->text }}</p>

            @if($remjob->location)
                <h4>{{__('Location')}}</h4>
            <p>{{ $remjob->location }}</p>
            @endif

            <div class="d-flex">

                <p class="mr-2"> {{__('See all jobs at ')}}</p>
                <p>
                    <a class="company-brand" href="{{  route( 'remjobs.searchByCompany', $remjob->company_slug )  }}" >
                        {{ $remjob->company_name }}
                    </a>
                </p>
                


            </div>
                
            
    

        </div>
    </div>
</div>
  
  
  
  
  
  
  