@extends('layouts.app')

@section('title', 'Admin | Edit remjob')

@section('content')

    <div class="d-flex justify-content-between my-3 mx-5">
        <h3>
            <span>{{'Edit Remote Job: ' .$remjob->id}}</span>
            <span>{{' | User: ' .$remjob->company->user->id}}</span>
            <span>{{' | Company: ' .$remjob->company->id}}</span>
        </h3>
        <a href="{{ route('admin.remjobs.index') }}" style="color:#4CAF50;">
            Back to Admin Dashboard | Remjobs <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <hr class="m-2">

    <div class="container">

        <form action="{{ route('admin.remjobs.update', $remjob->id) }}" method="post" enctype="multipart/form-data" id="admin-update-remjob-form">
            @csrf
            @method('PATCH')

            <div class="rp-group">

                <div class="rp-group__title">The Job</div>

                <!-- position -->
                <div>
                    <span class="rp-group__head">{{ __('text.crPositionLabel') }}*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="position" data-name="a job position"
                            value="{{ !is_null( old('position'))? old('position') : $remjob->position }}"    
                    >
                    @error('position')<p class="rp-group__error">{{ $message }}</p>@enderror
                </div>

                <!-- category_id -->
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
                    @error('category_id') <p class="rp-group__error">{{ $message }}</p>  @enderror
                    
                </div>

                <!-- tags -->
                <div>
                    <span class="rp-group__head">{{__('text.crTagsLabel')}}*</span>
                    <input  data-required="required" autocomplete="off" id="tagsElement"
                            type="text" name="tags" data-name="job tags"
                            value="{{ !is_null( old('tags'))? old('tags') : $tagsText }}"
                            
                        >
                    @error('tags') <p class="rp-group__error">{{ $message }}</p> @enderror
                </div>

                <!-- locations -->
                <div>
                    <span class="rp-group__head">{{__('text.crLocationLabel')}}</span>
                    <input  autocomplete="off"
                            type="text" name="locations" data-name="candidate locations allowed"
                            value="{{ !is_null( old('locations'))? old('locations') : $remjob->locations }}"
                            
                        >
                    @error('locations') <p class="rp-group__error">{{ $message }}</p>  @enderror
                </div>

                <!-- salary -->
            
                <div class="d-flex flex-column" id="salary-range">
                    <span class="rp-group__head salary__items">{{__('text.crSalaryLabel')}}</span>
                    <div class="d-flex">

                        <span class="rp-group__head salary__items">{{__('text.crMinSalaryLabel')}} </span>
                        <input  autocomplete="off" data-name="minimun salary"
                            type="text" name="min_salary" placeholder="0" 
                            value="{{ !is_null( old('min_salary'))? old('min_salary') : $remjob->min_salary }}"
                                data-toggle="tooltip" title="{{__('text.crMinSalaryTooltip')}}"  
                        >
                        <span class="rp-group__head salary__items">{{__('text.crMaxSalaryLabel')}} </span>
                        <input  autocomplete="off" data-name="maximun salary"
                            type="text" name="max_salary" placeholder="0" 
                            value="{{ !is_null( old('max_salary'))? old('max_salary') : $remjob->max_salary }}"
                                data-toggle="tooltip" title="{{__('text.crMaxSalaryTooltip')}}"   
                        >

                    </div>
                    @error('min_salary') <p class="rp-group__error">{{ $message }}</p> @enderror
                    @error('max_salary') <p class="rp-group__error">{{ $message }}</p> @enderror
                </div> 
            
            </div>

            <!-- J O B   D E T A I L S -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">{{__('text.crGroupTitleJobDetails')}}</div>
                
                <!-- description -->
                <div>
                    <span class="rp-group__head">{{__('text.crDescriptionLabel')}}*</span>
                    <textarea class="form-control" name="description" id="description" style="margin:14px">
                        {{ !is_null( old('description'))? old('description') : $remjob->description }}
                    </textarea>

                    @error('description') <p class="rp-group__error">{{ $message }}</p> @enderror
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

                        <input  data-required="required" autocomplete="off" placeholder="https://..."
                            style="display:block"
                            type="text" name="apply_link" data-name="apply link" id="apply-link-input"
                            value="{{ !is_null( old('apply_link'))? old('apply_link') : $remjob->apply_link }}"      
                        >
                        <input  data-required="required" autocomplete="off" style="display:none" placeholder="email@job.com"
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
                            value="{{ !is_null( old('apply_email'))? old('apply_email') : $remjob->apply_email }}"     
                        >
                        <span class="rp-group__info" id="apply-mode-info">
                            {{__('text.crEmailTip')}}
                        </span>
                    @endif
                    
                    @error('apply_link') <p class="rp-group__error">{{ $message }}</p> @enderror
                    @error('apply_email') <p class="rp-group__error">{{ $message }}</p> @enderror

                </div> 
                
                <!-- plan_id -->
                <div class="my-4">
                    <span class="rp-group__head">{{__('P L A N')}}*</span>

                    <select data-required="required" name="plan_id" id="planElement">

                        @foreach( \App\Plan::get() as $plan )

                            @if( old('plan_id') == $plan->id )
                                <option value="{{ $plan->id }}" selected>{{ $plan->name }}</option>
                            @elseif( $remjob->plan_id == $plan->id )
                                <option value="{{ $plan->id }}" selected>{{ $plan->name }}</option>
                            @else
                                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                            @endif

                        @endforeach

                    </select>
                    @error('plan_id') <p class="rp-group__error">{{ $message }}</p>  @enderror
                    
                </div>

                <!-- logo -->
                <div>
                    <span class="rp-group__head">{{__('Logo Link')}}</span>
                    <input  autocomplete="off"
                            type="text" name="logo" data-name="candidate locations allowed"
                            value="{{ !is_null( old('logo'))? old('logo') : $remjob->logo }}"
                            
                        >
                    @error('logo') <p class="rp-group__error">{{ $message }}</p>  @enderror
                </div>

            </div>

            <button class="post-button ml-4 my-2" type="submit" id="post-the-job-button">
                Update the job!
            </button>

        </form>

    </div>

    
@endsection
