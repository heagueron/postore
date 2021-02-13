@extends('layouts.app')

@section('title', 'Edit a Job')

@section('content')

    @include('partials.nav')

    <div class="container" style="margin-top:7rem;">

        <div class="d-flex justify-content-center mt-3 flex-column text-center">
            <h1>{{ strtoupper( __('text.edFormTitle') ) }}</h1>
        </div>

    </div>


    <hr class="m-5">

    <div class="container mb-4">

        <form action="{{ route('remjobs.update', $remjob->id) }}" method="post" enctype="multipart/form-data" id="post-job-form">
            @csrf
            @method('PATCH')

            {{-- Retrieve localization for javascript --}}
            <input type="hidden" id="localeElement" value="{{ App::getLocale() }}">
            

            <!-- T H E   J O B -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">{{ __('text.crGroupTitleJob') }}</div>

                

                <!-- position -->
                <div>
                    <span class="rp-group__head">{{ __('text.crPositionLabel') }}*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="position" data-name="a job position"
                            value="{{ !is_null( old('position'))? old('position') : $remjob->position }}"    
                    >
                    
                    <span class="rp-group__info"> {{__('text.crPositionTip')}} </span>

                    @error('position') <p class="rp-group__error">{{ $message }}</p> @enderror

                </div>

                <!-- category -->
                <div>
                    <span class="rp-group__head">{{__('text.crCategoryLabel')}}*</span>

                    <select data-required="required" name="category_id" id="categoryElement">
                            
                        <option>{{__('text.crCategoryTitle')}}</option>

                        @foreach( $categories as $category)

                            @if ( old('category_id') == $category->id )
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @elseif ( $remjob->category_id == $category->id )
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
                            value="{{ !is_null( old('tags'))? old('tags') : $tagsText }}"
                            
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
                            value="{{ !is_null( old('locations'))? old('locations') : $remjob->locations }}"
                            
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
                            type="text" name="min_salary" 
                            value="{{ !is_null( old('min_salary'))? old('min_salary') : $remjob->min_salary }}"
                             data-toggle="tooltip" title="{{__('text.crMinSalaryTooltip')}}"  
                        >
                        <span class="rp-group__head salary__items">{{__('text.crMaxSalaryLabel')}} </span>
                        <input  autocomplete="off" data-name="maximun salary"
                            type="text" name="max_salary"
                            value="{{ !is_null( old('max_salary'))? old('max_salary') : $remjob->max_salary }}"
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
                        {{ !is_null( old('description'))? old('description') : $remjob->description }}
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

                    @if( $remjob->apply_mode == 'link')
                        <div class="custom-control custom-radio custom-control-inline ml-3">
                            <input type="radio" class="custom-control-input" id="apply-link" name="apply_mode" value="link"
                                checked="checked">
                            <label class="custom-control-label pt-1" for="apply-link">{{__('text.crLinkLabel')}}</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="apply-email" name="apply_mode" value="email">
                            <label class="custom-control-label pt-1" for="apply-email">{{__('text.crEmailLabel')}}</label>
                        </div>

                        <input  data-required="required" autocomplete="off" 
                            style="display:block"
                            type="text" name="apply_link" data-name="apply link" id="apply-link-input"
                            value="{{ !is_null( old('apply_link'))? old('apply_link') : $remjob->apply_link }}"      
                        >
                        <input  data-required="required" autocomplete="off" style="display:none" 
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

                        <input  data-required="required" autocomplete="off" 
                            style="display:none"
                            type="text" name="apply_link" data-name="apply link" id="apply-link-input"
                            value="{{ !is_null( old('apply_link'))? old('apply_link') : null }}"      
                        >
                        <input  data-required="required" autocomplete="off" 
                            style="display:block"
                            type="text" name="apply_email" data-name="apply email" id="apply-email-input" 
                            value="{{ !is_null( old('apply_email'))? old('apply_email') : $remjob->apply_email }}"     
                        >
                        <span class="rp-group__info" id="apply-mode-info">
                            {{__('text.crEmailTip')}}
                        </span>
                    @endif
                    
                    @error('apply_link') <p class="rp-group__error">{{ $message }}</p> @enderror
                    @error('apply_email') <p class="rp-group__error">{{ $message }}</p> @enderror

                </div>  

            </div>

        </form>

        {{-- UPDATE THE JOB BUTTON --}}

        <div class="job-post-preview__post">

            <button form="post-job-form" class="post-button" type="submit" id="post-the-job-button">
                Update the job!
            </button>

        </div>


    </div>

@endsection
