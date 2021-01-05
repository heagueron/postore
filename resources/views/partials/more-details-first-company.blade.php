<!-- company_logo -->
<div>
    <span class="rp-group__head">company_logo*</span>

    <div class="logo-box" id="company-logo-container">
        <p>💾 Upload</p>
        <input type="file" name="company_logo" class="input_company_logo" 
                accept=".jpg,.png" id="company-logo-input"
        >
    </div>

    <span class="rp-group__info">
        Company logo.
    </span>
    @error('company_logo') 
        <p class="rp-group__error">{{ $message }}</p> 
    @enderror
    
</div>
                

<!-- company_twitter -->
<div>
    <span class="rp-group__head">Company twitter profile</span>
    <input  autocomplete="off" id="companyTwitterElement"
            type="text" name="company_twitter" data-name="your company twitter"
            value="{{ !is_null( old('company_twitter'))? old('company_twitter') : '' }}"               
    >
    <span class="rp-group__info">
        Company twitter profile (no '@' please). We will tag (mention) this profile when we share the job in twitter. 
    </span>
    @error('company_twitter') 
        <p class="rp-group__error">{{ $message }}</p> 
    @enderror
</div>