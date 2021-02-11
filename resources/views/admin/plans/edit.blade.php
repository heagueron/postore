@extends('layouts.admin')

@section('title', 'Admin|Plans')

@section('content')

        <form action="{{ route('admin.plans.update', $plan->id) }}" method="post">
            @csrf
            @method('PATCH')

            <!-- name -->
            <div>
                <span class="rp-group__head">NAME*</span>
                <input  type="text" name="name"
                        value="{{ !is_null( old('name'))? old('name') : $plan->name }}"               
                >
                @error('name') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- description -->
            <div>
                <span class="rp-group__head">Description*</span>
                <input  type="text" name="description"
                        value="{{ !is_null( old('description'))? old('description') : $plan->description }}"               
                >
                @error('description') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- value -->
            <div>
                <span class="rp-group__head">Value*</span>
                <input  type="text" name="value"
                        value="{{ !is_null( old('value'))? old('value') : $plan->value }}"               
                >
                @error('value') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            <!-- gumroad_permalink -->
            <div>
                <span class="rp-group__head">gumroad_permalink*</span>
                <input  type="text" name="gumroad_permalink"
                        value="{{ !is_null( old('gumroad_permalink'))? old('gumroad_permalink') : $plan->gumroad_permalink }}"               
                >
                @error('gumroad_permalink') 
                    <p class="rp-group__error">{{ $message }}</p> 
                @enderror
            </div>

            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>


        </form>

@endsection