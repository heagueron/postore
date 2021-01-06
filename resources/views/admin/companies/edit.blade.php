@extends('layouts.admin')

@section('title', 'Admin|Companies')

@section('content')

        <form action="{{ route('admin.companies.update', $company->id) }}" method="post" enctype="multipart/form-data" id="update-job-form">
            @csrf
            @method('PATCH')

            <!-- user id -->
            <input type="text" name="user_id" value="{{ !is_null( $company->user) ? $company->user->id : '' }}">
            @error('user_id') 
                <p class="rp-group__error">{{ $message }}</p> 
            @enderror

            <!-- company name -->
            <div>
                <span class="rp-group__head">{{ __('text.crCompanyNameLabel') }}*</span>
                <input  data-required="required" autocomplete="off" id="companyNameElement"
                        type="text" name="company_name" data-name="your company name"
                        value="{{ !is_null( old('company_name'))? old('company_name') : $company->name }}"               
                >
                {{-- Input to hold company id --}}
                <input type="text" id="companyIdElement" name="company_id" value="{{ $company->id }}">

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
                        value="{{ !is_null( old('company_email'))? old('company_email') : $company->email }}"               
                >
                <span class="rp-group__info">
                    {{__('text.crCompanyEmailTip')}}
                </span>
                @error('company_email') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <input type="hidden" id="storedLogo" value="logos/nologo.png">
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
                        value="{{ !is_null( old('company_twitter'))? old('company_twitter') : $company->twitter }}"               
                >
                <span class="rp-group__info">
                    Company twitter profile (no '@' please). We will tag (mention) this profile when we share the job in twitter. 
                </span>
                @error('company_twitter') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>

@endsection