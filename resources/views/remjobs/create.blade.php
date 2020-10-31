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
                            type="text" name="company_name" value=""
                            data-name="your company name"
                        >
                    <span class="rp-group__info">
                        Your company's brand or trade name. Please do not include Inc., Ltd., B.V., Pte., etc.
                    </span>
                    @error('company_name') <p><small style="color:red">{{ $message }} </small></p> @enderror
                </div>

                <!-- position -->
                <div>
                    <span class="rp-group__head">Position*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="position" value=""
                            data-name="a job position"
                        >
                    <span class="rp-group__info">
                        Please enter a single job position like "Javascript Developer" or "Virtual Assistant".
                    </span>
                    @error('position') <small style="color:red">{{ $message }} </small> @enderror
                </div>

                <!-- category -->
                <div>
                    <span class="rp-group__head">Category*</span>
                    <select data-required="required" name="category" id="categoryElement">
                            <option>Select a job category</option>
                        @foreach( $categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                                <p></p>
                            </option>
                            <option 
                                style="display:none" 
                                id="{{ 'tag-'.$category->id }}" 
                                value="{{ $category->tag }}"></option>
                        @endforeach
                    </select>
                    <span class="rp-group__info">
                        Select the category for the position.
                    </span>
                    @error('category') <small style="color:red">{{ $message }} </small> @enderror
                </div> 

                <!-- tags -->
                <div>
                    <span class="rp-group__head">Tags*</span>
                    <input  data-required="required" autocomplete="off" id="tagsElement"
                            type="text" name="tags" value=""
                            data-name="job tags"
                        >
                    <span class="rp-group__info">
                        Enter job related tags (like dev, javascript, php, devops, etc.) and separate multiple tags 
                        by comma. Jobs will be shown on each tag specific page (like /remote-devops-jobs).
                    </span>
                    @error('tags') <small style="color:red">{{ $message }} </small> @enderror
                </div>

                <!-- locations -->
                <div>
                    <span class="rp-group__head">Location</span>
                    <input  autocomplete="off"
                            type="text" name="locations" value="Worldwide"
                            data-name="candidate locations allowed"
                        >
                    <span class="rp-group__info">
                        Location, country or timezone where candidate must be locatedv (e.g. Europe, United States or CET Timezone). 
                        Can be left as "Worldwide".
                    </span>
                    @error('locations') <small style="color:red">{{ $message }} </small> @enderror
                </div>



            </div>

            <!-- J O B   D E T A I L S -->
            <div class="rp-group" id="rp-post-fs1">

                <div class="rp-group__title">JOB DETAILS</div>
                
                <!-- salary -->
            
                <div class="d-flex flex-column" id="salary-range">
                    <span class="rp-group__head salary__items">Annual Salary (US $)</span>
                    <div class="d-flex">
                        <input  autocomplete="off"
                            type="text" name="min_salary" placeholder="0" value="0"
                            data-name="minimun salary"
                            title="Minimun salary per year"
                            data-toggle="tooltip"
                        >
                        <input  autocomplete="off"
                            type="text" name="max_salary" placeholder="0" value="0"
                            data-name="maximun salary"
                            title="Maximun salary per year"
                            data-toggle="tooltip"
                        >
                    </div>
                </div>                
                <span class="rp-group__info">
                    Although it is not required, we recommend to enter salary data to help Google index the job.
                    Remember to enter annual salary data in US $ (like 60,000).
                </span>
                @error('min_salary') <small style="color:red">{{ $message }} </small> @enderror
                @error('max_salary') <small style="color:red">{{ $message }} </small> @enderror
                

                <!-- description -->
                <div>
                    <span class="rp-group__head">description*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="description" value=""
                            data-name="your company name"
                        >
                    <span class="rp-group__info">
                        The job description.
                    </span>
                    @error('description') <small style="color:red">{{ $message }} </small> @enderror
                </div>

                <!-- apply_link -->
                <div>
                    <span class="rp-group__head">apply_link*</span>
                    <input  data-required="required" autocomplete="off" 
                            type="text" name="apply_link" value=""
                            data-name="your company name"
                        >
                    <span class="rp-group__info">
                        The job apply_link.
                    </span>
                    @error('apply_link') <small style="color:red">{{ $message }} </small> @enderror
                </div>

                <!-- company_logo -->
                <div>
                    <span class="rp-group__head">company_logo*</span>
                    <input lang="en" type="file" class="form-control-file" id="company_logo"
                            name="company_logo" data-name="your company name"
                        >
                    <span class="rp-group__info">
                        The company_logo.
                    </span>
                    @error('company_logo') <small style="color:red">{{ $message }} </small> @enderror
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
