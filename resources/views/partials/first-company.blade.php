<!-- company name -->
<div>
    <span class="rp-group__head">{{ __('text.crCompanyNameLabel') }}*</span>
    <input  data-required="required" autocomplete="off" id="companyNameElement"
            type="text" name="company_name" data-name="your company name"
            value="{{ !is_null( old('company_name'))? old('company_name') : '' }}"               
    >
    {{-- Hidden input to hold company id --}}
    <input type="hidden" id="companyIdElement" name="company_id" value="{{ !is_null( old('company_id'))? old('company_id') : '' }}">

    <span class="rp-group__info">
        {{__('text.crCompanyNameTip')}}
    </span>
    @error('company_name') 
        <p class="rp-group__error">{{ $message }}</p> 
    @enderror
</div>

<!-- company_email -->
<div>
    <span class="rp-group__head">{{ __('text.crCompanyEmailLabel') }}*</span>
    <input  data-required="required" autocomplete="off" id="companyEmailElement"
            type="text" name="company_email" data-name="your company email"
            value="{{ !is_null( old('company_email'))? old('company_email') : '' }}"               
    >
    <span class="rp-group__info">
        {{__('text.crCompanyEmailTip')}}
    </span>
    @error('company_email') 
        <p class="rp-group__error">{{ $message }}</p> 
    @enderror
</div>