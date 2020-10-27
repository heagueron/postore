
<div class="card" style="margin:10px;" data-toggle="collapse" href="{{ '#position-' . $remjob->id}}">
    
    <div class="card-header job-box">

        <div class="row" style="align-content: center !important;">

            <div class="col pr-2 pl-1">
                {{__('logo')}}
            </div>

            <div class="col-3 pr-2 pl-1">
                <h6 class="mb-1"> {{ $remjob->company_name }} </h6>
                <h5 class="mb-1"> {{ ucwords( $remjob->position ) }} </h5>
                <span class="badge badge-secondary mb-1">{{ $remjob->location }}</span>
            </div>

            <div class="col pr-2 pl-1 mt-3">
            </div>

            <div class="col-4 pr-2 pl-1 mt-3">

                @foreach( $remjob->tags as $tag )
                    <a href="{{'remote-'.$tag->name.'-jobs'}}" class="job-badget">
                        <span 
                            class="badge badge-pill badge-light rp-tag"  
                            title="{{'select '.$tag->name.' jobs'}}"
                            data-toggle="tooltip"
                            data-placement="top">
                            {{ $tag->name }}
                        </span>&nbsp;
                    </a>                 
                @endforeach

            </div>

            <div class="col-1 pr-2 pl-1 mt-3">
                <p class="job-date">{{ $remjob->created_at->diffForHumans() }}</p>
            </div>

            <div class="col-2 pr-2 pl-1 mt-3">
                {{__('apply button')}}
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

            <p> {{__('See all jobs at ')}}
                <a href="#" style="color:black;">{{ $remjob->company_name }}</a>
            </p>

        </div>
    </div>
</div>
  
  
  
  
  
  
  