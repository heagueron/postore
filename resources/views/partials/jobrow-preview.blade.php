
<!-- NEW job preview -->

<h3 class="rp-group__head mb-1">{{ __('text.crPreviewTitle') }}</h3>
<div class="rp-row rp-row__highlight" id="job-preview-container">

    <div class="row rp-row__header job-box ">
        <!-- logo preview -->
        @if( \App\Company::where('user_id', $user->id)->exists() )
            @if( $user->companies->count() == 1 )
                <div class="col-1" id="preview_logo_container">
                    @if($user->companies->first()->logo)
                        <img src="{{ asset('storage/'.$user->companies->first()->logo) }}" alt="logo" id="preview-logo" class="jobrow-company-logo">
                    @else
                        <img src="{{ asset('storage/logos/nologo.png') }}" alt="logo" id="preview-logo" class="jobrow-company-logo">
                    @endif
                </div>
            @else
                {{-- HAS MORE THAN ONE COMPANY ! --}} 
                <div class="col-1" id="preview_logo_container">
                    @if($user->companies->first()->logo)
                        <img src="{{ asset('storage/'.$user->companies->first()->logo) }}" alt="logo" id="preview-logo" class="w-100">
                    @else
                        <img src="{{ asset('storage/logos/nologo.png') }}" alt="logo" id="preview-logo" class="jobrow-company-logo">
                    @endif
                </div>
            @endif
        @else
            <div class="col-1" id="preview_logo_container">
                <img src="{{ asset('storage/logos/nologo.png') }}" alt="logo" id="preview-logo" class="jobrow-company-logo">
            </div>
        @endif


        <!-- position, company and location preview -->
        <div class="col-3 mt-3 ml-3">
            <h5 class="mb-1 rp-job-title" id="preview_position_container"> {{ ucwords(__('text.crPositionLabel')) }} </h5>
            <p class="mb-1 company-badge company-brand" id="preview_company_container">
                {{ __('text.crCompany') }}
            </p>
            <p class="rp-location" id="preview_locations_container"> {{ __('text.crLocationDefault') }}</p>
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

  
  
  
  
  
  
  