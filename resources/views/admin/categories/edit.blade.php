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

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>

@endsection