@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')

    @include('partials.nav')

    {{-- Retrieve localization for javascript --}}
    <input type="hidden" id="localeElement" value="{{ App::getLocale() }}">
    
    <div class="d-flex justify-content-center mt-3 flex-column text-center">
        <h1>{{ strtoupper( __('text.crFormTitle') ) }}</h1>
        <!-- <h5>{{ __('text.crBasePriceTip', ['basePrice' => \App\Option::find(1)->value]) }}</h5> -->
    </div>

    <hr class="m-5">

    <div class="container">

        <form action="{{ route('remjobs.store') }}" method="post" enctype="multipart/form-data" id="post-job-form">
            @csrf

            <!-- T H E   J O B -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">{{ __('text.crGroupTitleJob') }}</div>
                
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

                <!-- position -->
                <div>
                    <span class="rp-group__head">{{ __('text.crPositionLabel') }}*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="position" data-name="a job position"
                            value="{{ !is_null( old('position'))? old('position') : '' }}"    
                    >
                    <span class="rp-group__info">
                        {{__('text.crPositionTip')}}
                    </span>
                    @error('position') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- category -->
                <div>
                    <span class="rp-group__head">{{__('text.crCategoryLabel')}}*</span>

                    <select data-required="required" name="category_id" id="categoryElement">
                            
                        <option>{{__('text.crCategoryTitle')}}</option>

                        @foreach( $categories as $category)

                            @if ( old('category_id') == $category->id )
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                            <option style="display:none" id="{{ 'tag-'.$category->id }}" 
                                value="{{ $category->tag }}">
                            </option>

                        @endforeach
                    </select>

                    <span class="rp-group__info">
                        {{__('text.crCategoryTip')}}
                    </span>
                    @error('category_id') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                    
                </div> 

                <!-- tags -->
                <div>
                    <span class="rp-group__head">{{__('text.crTagsLabel')}}*</span>
                    <input  data-required="required" autocomplete="off" id="tagsElement"
                            type="text" name="tags" data-name="job tags"
                            value="{{ !is_null( old('tags'))? old('tags') : '' }}"
                            
                        >
                    <span class="rp-group__info">
                        {{__('text.crTagsTip')}}
                    </span>
                    @error('tags') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- locations -->
                <div>
                    <span class="rp-group__head">{{__('text.crLocationLabel')}}</span>
                    <input  autocomplete="off"
                            type="text" name="locations" data-name="candidate locations allowed"
                            value="{{ !is_null( old('locations'))? old('locations') : __('text.crLocationDefault') }}"
                            
                        >
                    <span class="rp-group__info">
                        {{__('text.crLocationTip')}}
                    </span>
                    @error('locations') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>



            </div>

            <!-- J O B   D E T A I L S -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">{{__('text.crGroupTitleJobDetails')}}</div>
                
                <!-- salary -->
            
                <div class="d-flex flex-column" id="salary-range">
                    <span class="rp-group__head salary__items">{{__('text.crSalaryLabel')}}</span>
                    <div class="d-flex">

                        <span class="rp-group__head salary__items">{{__('text.crMinSalaryLabel')}} </span>
                        <input  autocomplete="off" data-name="minimun salary"
                            type="text" name="min_salary" placeholder="0" 
                            value="{{ !is_null( old('min_salary'))? old('min_salary') : '0' }}"
                             data-toggle="tooltip" title="{{__('text.crMinSalaryTooltip')}}"  
                        >
                        <span class="rp-group__head salary__items">{{__('text.crMaxSalaryLabel')}} </span>
                        <input  autocomplete="off" data-name="maximun salary"
                            type="text" name="max_salary" placeholder="0" 
                            value="{{ !is_null( old('max_salary'))? old('max_salary') : '0' }}"
                             data-toggle="tooltip" title="{{__('text.crMaxSalaryTooltip')}}"   
                        >

                    </div>
                </div>                
                <span class="rp-group__info">
                    {{__('text.crSalaryTip')}}
                </span>
                @error('min_salary') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
                @error('max_salary') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
                

                <!-- description -->
                <div>
                    <span class="rp-group__head">{{__('text.crDescriptionLabel')}}*</span>
                    <textarea class="form-control" name="description" id="description" style="margin:14px">
                        {{ !is_null( old('description'))? old('description') : '' }}
                    </textarea>
                    <span class="rp-group__info">
                        {{__('text.crDescriptionTip')}}
                    </span>
                    @error('description') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- apply_link -->
                <div>
                    <span class="rp-group__head mb-1">{{__('text.crApplyLabel')}}*</span>

                    @if( is_null(old('apply_mode')) or old('apply_mode') == 'link')
                        <div class="custom-control custom-radio custom-control-inline ml-3">
                            <input type="radio" class="custom-control-input" id="apply-link" name="apply_mode" value="link"
                                checked="checked">
                            <label class="custom-control-label pt-1" for="apply-link">{{__('text.crLinkLabel')}}</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="apply-email" name="apply_mode" value="email">
                            <label class="custom-control-label pt-1" for="apply-email">{{__('text.crEmailLabel')}}</label>
                        </div>

                        <input  data-required="required" autocomplete="off" placeholder="https://..."
                            style="display:block"
                            type="text" name="apply_link" data-name="apply link" id="apply-link-input"
                            value="{{ !is_null( old('apply_link'))? old('apply_link') : null }}"      
                        >
                        <input  data-required="required" autocomplete="off" style="display:none" placeholder="email@job.com"
                            style="display:none"
                            type="text" name="apply_email" data-name="apply email" id="apply-email-input" 
                            value="{{ !is_null( old('apply_email'))? old('apply_email') : null }}"     
                        >
                        <span class="rp-group__info" id="apply-mode-info">
                            {{__('text.crLinkTip')}}
                        </span>

                    @else
                        <div class="custom-control custom-radio custom-control-inline ml-3">
                            <input type="radio" class="custom-control-input" id="apply-link" name="apply_mode" value="link">
                            <label class="custom-control-label pt-1" for="apply-link">{{__('text.crLinkLabel')}}</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="apply-email" name="apply_mode" value="email"
                            checked="checked" >
                            <label class="custom-control-label pt-1" for="apply-email">{{__('text.crEmailLabel')}}</label>
                        </div>

                        <input  data-required="required" autocomplete="off" placeholder="https://..."
                            style="display:none"
                            type="text" name="apply_link" data-name="apply link" id="apply-link-input"
                            value="{{ !is_null( old('apply_link'))? old('apply_link') : null }}"      
                        >
                        <input  data-required="required" autocomplete="off" placeholder="email@job.com"
                            style="display:block"
                            type="text" name="apply_email" data-name="apply email" id="apply-email-input" 
                            value="{{ !is_null( old('apply_email'))? old('apply_email') : null }}"     
                        >

                        <span class="rp-group__info" id="apply-mode-info">
                            {{__('text.crEmailTip')}}
                        </span>

                    @endif

                    

                    @error('apply_link') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                    @error('apply_email') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror

                </div>

                

                

            </div>


            <!-- C O M P A N Y   D E T A I L S -->
            <div class="rp-group">

                <div class="rp-group__title">More Company Details</div>

                <!-- company_logo -->
                <div>
                    <span class="rp-group__head">company_logo*</span>

                    <div class="logo-box" id="company-logo-container">
                        <p>💾 Upload</p>
                        <input type="file" name="company_logo" class="input_company_logo" accept=".jpg,.png" id="company-logo-input">
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
                            value="{{ !is_null( old('company_twitter'))? old('company_twitter') : '' }}"               
                    >
                    <span class="rp-group__info">
                        Your company's twitter profile (no '@' please). We will tag (mention) this profile when we share the job in twitter. 
                    </span>
                    @error('company_twitter') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>
            
            </div>

            <!-- P L A N S -->
            <div class="rp-group">

                <div class="rp-group__title">{{__('text.crPlanSelectorTitle')}}</div>

                @include('partials.pricing-table')
                
            
            </div>

        </form>

    </div>

    <div style="height:150px;"></div>


    {{-- PREVIEW AND POST THE JOB BUTTON --}}
    <div class="row job-post-preview">

        <div class="col-10 job-post-preview__job">
            <x-jobrow-preview />   
        </div>

        <div class="col-2 job-post-preview__post">
            <button form="post-job-form" class="post-button" type="submit" id="post-the-job-button">
                {{ __('text.crPostTheJob') }}
            </button>
        </div>

    </div>
    
@endsection
