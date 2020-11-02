
<!-- NEW job preview -->
<h3 class="rp-group__head mb-1">Job Post Preview:</h3>
<div class="rp-row">

    <div class="row rp-row__header job-box">

        <!-- logo preview -->
        <div class="col" id="preview_logo_container">
            <img src="{{ asset('storage/logos/logo1.png') }}" alt="logo" id="preview-logo" class="w-100">
        </div>

        <!-- position, company and location preview -->
        <div class="col-3 mt-3">
            <h5 class="mb-1 rp-job-title" id="preview_position_container"> {{ ucwords( 'position' ) }} </h5>
            <p class="mb-1 company-badge company-brand" id="preview_company_container">
                {{ __('Company') }}
            </p>
            <p class="rp-location" id="preview_locations_container"> {{ __('Worlwide') }}</p>
        </div>

        <div class="col">
        </div>

        <!-- tags preview -->
        <div class="col-4 pb-7" id="preview_tags_container">
            
            @foreach( [1,2,3] as $tag )
                <span class="rp-tag-item">
                    {{ __('Tag'.$tag) }}
                </span>&nbsp;          
            @endforeach                 
            
        </div>

        <!-- time ago preview -->
        <!-- <div class="col mt-3">
            <p class="job-date"></p>
        </div> -->

        <!-- apply button preview -->
        <div class="col-2 pr-2 pl-1 d-flex justify-content-center align-content-center">
            <p class="rp-jobrow__preview"> 
                {{ __('Apply to this job') }}
            </p>
        </div>

    </div>

</div>

  
  
  
  
  
  
  