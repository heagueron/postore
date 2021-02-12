@extends('layouts.admin')

@section('title', 'Admin|Text Option')

@section('content')

        <form action="{{ route('admin.textOptions.update', $textOption->id) }}" method="post">
            @csrf
            @method('PATCH')

            <!-- name -->
            <div>
                <span class="rp-group__head">NAME*</span>
                <input  type="text" name="name"
                        value="{{ !is_null( old('name'))? old('name') : $textOption->name }}"               
                >
                @error('name') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- value -->
            <div>
                <span class="rp-group__head">Value*</span>

                <textarea name="value" class="form-control post-text-container" autocomplete="off" 
                        rows="4" cols="50">
                        {{ !is_null( old('value'))? old('value') : $textOption->value }}
                </textarea>
                
                @error('value') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>


        </form>

@endsection