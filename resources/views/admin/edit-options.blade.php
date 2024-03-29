@extends('layouts.admin')

@section('title', 'Remote Jobs')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <h4>{{ __('admin.pageTitle') }}</h4>
        </div>
    </div>
    
    <form action="{{ route('admin.update-options') }}" method="post">
        @csrf
        @method('PATCH')

        <!-- PRICES VALUES -->
        
        <div class="rp-group">
            <span class="rp-group__head mb-3">{{ __('admin.planPricesTitle') }}</span>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{ $adminPlans[0]->name }}</div>
                <div class="col-2">
                    <input  type="number" name="base_price"
                            value="{{ !is_null( old('base_price'))? old('base_price') : $adminPlans[0]->value }}"               
                    >
                </div>
            </div> 
            
            <div class="row mb-2">
                <div class="col-4 pt-3">{{ $adminPlans[1]->name }}</div>
                <div class="col-2">
                    <input  type="number" name="pro_price"
                            value="{{ !is_null( old('pro_price'))? old('pro_price') : $adminPlans[1]->value }}"               
                    >
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{ $adminPlans[2]->name }}</div>
                <div class="col-2">
                    <input  type="number" name="premium_price"
                            value="{{ !is_null( old('premium_price'))? old('premium_price') : $adminPlans[2]->value }}"               
                    >
                </div>
            </div> 
                
        </div>

        <div class="rp-group">

            <span class="rp-group__head mb-3">{{__('admin.otherParamsTitle')}}</span>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{ $adminOptions[0]->name }}</div>
                <div class="col-2">
                    <input  type="number" name="remjob_active_duration"
                            value="{{ !is_null( old('remjob_active_duration'))? old('remjob_active_duration') : $adminOptions[0]->value }}"               
                    >
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{ $adminTextOptions[0]->name }}</div>
                <div class="col-4">
                    <input  type="text" name="support_email" style="margin:0 !important;"
                            value="{{ !is_null( old('support_email'))? old('support_email') : $adminTextOptions[0]->value }}"               
                    >
                </div>
            </div> 

        </div>

        <button type="submit" class="btn btn-warning mb-2" style="margin-left:28px;">{{ __('admin.update') }}</button>
    </form>

</div>
    
@endsection