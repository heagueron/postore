@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')

    <div class="nav logo-button-container">

        <div style="flex: 1" class="nav__logo">
            <a href="{{ route('landing') }}" aria-current="page" alt="Remote Position">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Remote Positions">
            </a>
        </div>
        
    </div>

    <div class="d-flex justify-content-center">
        <h1 >Hire remote resources</h1>
    </div>

    <hr class="m-5">

    <div class="container">
    
        <form action="{{ route('remjobs.store') }}" method="post" enctype="multipart/form-data" id="post-job-form">
            @csrf

            <!-- T H E   J O B -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">JOB</div>
                
                <!-- company_name -->
                <div>
                    <span class="rp-group__head">Company name*</span>
                    <input  data-required="required" autocomplete="off" id="companyNameElement"
                            type="text" name="company_name" data-name="your company name"
                            value="{{ !is_null( old('company_name'))? old('company_name') : '' }}"               
                    >
                    <span class="rp-group__info">
                        Your company's brand or trade name. Please do not include Inc., Ltd., B.V., Pte., etc.
                    </span>
                    @error('company_name') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- position -->
                <div>
                    <span class="rp-group__head">Position*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="position" data-name="a job position"
                            value="{{ !is_null( old('position'))? old('position') : '' }}"    
                    >
                    <span class="rp-group__info">
                        Please enter a single job position like "Javascript Developer" or "Virtual Assistant".
                    </span>
                    @error('position') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- category -->
                <div>
                    <span class="rp-group__head">Category*</span>

                    <select data-required="required" name="category_id" id="categoryElement">
                            
                        <option>Select a job category</option>

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
                        Select the category for the position.
                    </span>
                    @error('category_id') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                    
                </div> 

                <!-- tags -->
                <div>
                    <span class="rp-group__head">Tags*</span>
                    <input  data-required="required" autocomplete="off" id="tagsElement"
                            type="text" name="tags" data-name="job tags"
                            value="{{ !is_null( old('tags'))? old('tags') : '' }}"
                            
                        >
                    <span class="rp-group__info">
                        Enter job related tags (like dev, javascript, php, devops, etc.) and separate multiple tags 
                        by comma. Jobs will be shown on each tag specific page (like /remote-devops-jobs).
                    </span>
                    @error('tags') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- locations -->
                <div>
                    <span class="rp-group__head">Location</span>
                    <input  autocomplete="off"
                            type="text" name="locations" data-name="candidate locations allowed"
                            value="{{ !is_null( old('locations'))? old('locations') : 'Worldwide' }}"
                            
                        >
                    <span class="rp-group__info">
                        Location, country or timezone where candidate must be locatedv (e.g. Europe, United States or CET Timezone). 
                        Can be left as "Worldwide".
                    </span>
                    @error('locations') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>



            </div>

            <!-- J O B   D E T A I L S -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">JOB DETAILS</div>
                
                <!-- salary -->
            
                <div class="d-flex flex-column" id="salary-range">
                    <span class="rp-group__head salary__items">Annual Salary (US $)</span>
                    <div class="d-flex">

                        <input  autocomplete="off" data-name="minimun salary"
                            type="text" name="min_salary" placeholder="0" 
                            value="{{ !is_null( old('min_salary'))? old('min_salary') : '0' }}"
                             data-toggle="tooltip" title="Minimun salary per year"  
                        >
                        <input  autocomplete="off" data-name="maximun salary"
                            type="text" name="max_salary" placeholder="0" 
                            value="{{ !is_null( old('max_salary'))? old('max_salary') : '0' }}"
                             data-toggle="tooltip" title="Maximun salary per year"   
                        >

                    </div>
                </div>                
                <span class="rp-group__info">
                    Although it is not required, we recommend to enter salary data to help Google index the job.
                    Remember to enter annual salary data in US $ (like 60,000).
                </span>
                @error('min_salary') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
                @error('max_salary') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
                

                <!-- description -->
                <div>
                    <span class="rp-group__head">description*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="description" data-name="job description"
                            value="{{ !is_null( old('description'))? old('description') : '' }}"  
                    >
                    <span class="rp-group__info">
                        The job description.
                    </span>
                    @error('description') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- apply_link -->
                <div>
                    <span class="rp-group__head">apply_link*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="apply_link" data-name="apply link"
                            value="{{ !is_null( old('apply_link'))? old('apply_link') : '' }}"
                            
                        >
                    <span class="rp-group__info">
                        The job apply_link.
                    </span>
                    @error('apply_link') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- company_logo -->
                <div>
                    <span class="rp-group__head">company_logo*</span>
                    <input lang="en" type="file" class="form-control-file" id="company_logo"
                            name="company_logo" data-name="company logo"
                        >
                    <span class="rp-group__info">
                        The company_logo.
                    </span>
                    @error('company_logo') 
                        <p class="rp-group__error">{{ $message }}</p> 
                    @enderror
                </div>

                

            </div>

        </form>

    </div>

    <div style="height:150px;"></div>

    <div class="row job-post-preview">

        <div class="col-10 job-post-preview__job">
            <x-jobrow-preview />   
        </div>

        <div class="col-2 job-post-preview__post">
            <button form="post-job-form" class="post-button">
                Post the job
            </button>
        </div>

    </div>
    
@endsection
