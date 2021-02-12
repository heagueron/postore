@extends('layouts.admin')

@section('title', 'Admin|Option')

@section('content')

        <form action="{{ route('admin.options.update', $option->id) }}" method="post">
            @csrf
            @method('PATCH')

            <!-- name -->
            <div>
                <span class="rp-group__head">NAME*</span>
                <input  type="text" name="name"
                        value="{{ !is_null( old('name'))? old('name') : $option->name }}"               
                >
                @error('name') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- value -->
            <div>
            <span class="rp-group__head">VALUE*</span>
                <input  type="text" name="value"
                        value="{{ !is_null( old('value'))? old('value') : $option->value }}"               
                >
                @error('value') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>


        </form>

@endsection