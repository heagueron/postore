<!-- company_logo -->
<div>
    <span class="rp-group__head">company_logo*</span>

    <div class="logo-box" id="company-logo-container" 
            style="background-image:url( {{ asset('storage/'.$user->companies->first()->logo) }} )">
        <p>💾 Upload</p>
        <input type="file" name="company_logo" class="input_company_logo" 
                accept=".jpg,.png" id="company-logo-input"
        >
        
    </div>

    <span class="rp-group__info">
        Your company logo.
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
            value="{{ !is_null( old('company_twitter'))? old('company_twitter') : $user->companies()->first()->twitter }}"               
    >
    <span class="rp-group__info">
        Your company's twitter profile (no '@' please).
    </span>
    @error('company_twitter') 
        <p class="rp-group__error">{{ $message }}</p> 
    @enderror
</div>