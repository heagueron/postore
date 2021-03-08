@extends('layouts.admin')

@section('title', 'Admin|Categories')

@section('content')

        <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
            @csrf
            @method('PATCH')

            <!-- name -->
            <div>
                <span class="rp-group__head">NAME*</span>
                <input  type="text" name="name"
                        value="{{ !is_null( old('name'))? old('name') : $category->name }}"               
                >
                @error('name') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- tag -->
            <div>
                <span class="rp-group__head">tag*</span>
                <input  type="text" name="tag"
                        value="{{ !is_null( old('tag'))? old('tag') : $category->tag }}"               
                >
                @error('tag') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- language -->
            <div>
                <span class="rp-group__head">language*</span>
                <select name="language_id">
                    <!-- <option value="0">Select Language</option> -->
                    @foreach(\App\Language::all() as $language)
                        @if( $category->language_id == $language->id )
                            <option value="{{ $language->id }}" selected>{{ $language->name}}</option>
                        @else
                            <option value="{{ $language->id }}">{{ $language->name}}</option>
                        @endif
                    @endforeach
                </select>
                @error('language_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>


            <!-- Mailchimp Audience ID -->
            <div>
                <span class="rp-group__head">Mailchimp Audience ID</span>
                <input  type="text" name="mailchimp_audience_id"
                        value="{{ !is_null( old('mailchimp_audience_id') )? old('mailchimp_audience_id') : $category->mailchimp_audience_id }}"               
                >
                @error('mailchimp_audience_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Mailchimp Category ID -->
            <div>
                <span class="rp-group__head">Mailchimp Category ID</span>
                <input  type="text" name="mailchimp_category_id"
                        value="{{ !is_null( old('mailchimp_category_id') )? old('mailchimp_category_id') : $category->mailchimp_category_id }}"               
                >
                @error('mailchimp_category_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Mailchimp Interest ID -->
            <div>
                <span class="rp-group__head">Mailchimp Interest ID</span>
                <input  type="text" name="mailchimp_interest_id"
                        value="{{ !is_null( old('mailchimp_interes_id') )? old('mailchimp_interest_id') : $category->mailchimp_interest_id }}"               
                >
                @error('mailchimp_interest_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Mailchimp Base Campaign ID -->
            <div>
                <span class="rp-group__head">Mailchimp Base Campaign ID</span>
                <input  type="text" name="mailchimp_base_campaign_id"
                        value="{{ !is_null( old('mailchimp_base_campaign_id') )? old('mailchimp_base_campaign_id') : $category->mailchimp_base_campaign_id }}"               
                >
                @error('mailchimp_base_campaign_id') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- DATES-->
            <div>
                <span class="rp-group__head">Created At</span>
                <input  type="text" name="created_at"
                        value="{{ !is_null( old('created_at') )? old('created_at') : $category->created_at }}"               
                >
            </div>
            <div>
                <span class="rp-group__head">Updated At</span>
                <input  type="text" name="updated_at"
                        value="{{ !is_null( old('updated_at') )? old('updated_at') : $category->updated_at }}"               
                >
            </div>


            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>


        </form>

@endsection