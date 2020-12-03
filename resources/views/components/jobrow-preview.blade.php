
<!-- NEW job preview -->
<h3 class="rp-group__head mb-1">Job Post Preview:</h3>
<div class="rp-row" style="background-color:#f9f9f9;">

    <div class="row rp-row__header job-box">

        <!-- logo preview -->
        <div class="col-1" id="preview_logo_container">
            <img src="{{ asset('storage/logos/nologo.png') }}" alt="logo" id="preview-logo" class="w-100">
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

    </div>

</div>

  
  
  
  
  
  
  