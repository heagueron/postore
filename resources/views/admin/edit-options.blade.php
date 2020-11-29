@extends('layouts.admin')

@section('title', 'Remote Jobs')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <h4>{{__('ADMIN OPTIONS')}}</h4>
        </div>
    </div>

    <form action="{{ route('admin.update-options') }}" method="post">
        @csrf
        @method('PATCH')

        <!-- PRICES VALUES -->
        
        <div class="rp-group">
            <span class="rp-group__head mb-3">{{__('Base and Style Options Prices US$')}}</span>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Base Post')}}</div>
                <div class="col-2">
                    <input  type="number" name="base_price"
                            value="{{ !is_null( old('base_price'))? old('base_price') : $adminOptions[0]->value }}"               
                    >
                </div>
            </div> 
            
            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Show Logo')}}</div>
                <div class="col-2">
                    <input  type="number" name="show_logo"
                            value="{{ !is_null( old('show_logo'))? old('show_logo') : $adminOptions[1]->value }}"               
                    >
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Yellow Background')}}</div>
                <div class="col-2">
                    <input  type="number" name="yellow_background"
                            value="{{ !is_null( old('yellow_background'))? old('yellow_background') : $adminOptions[2]->value }}"               
                    >
                </div>
            </div> 
            
            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Main Front Page')}}</div>
                <div class="col-2">
                    <input  type="number" name="main_front_page"
                            value="{{ !is_null( old('main_front_page'))? old('main_front_page') : $adminOptions[3]->value }}"               
                    >
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Category Front Page')}}</div>
                <div class="col-2">
                    <input  type="number" name="category_front_page"
                            value="{{ !is_null( old('category_front_page'))? old('category_front_page') : $adminOptions[4]->value }}"               
                    >
                </div>
            </div>
                
        </div>

        <div class="rp-group">
            <span class="rp-group__head mb-3">{{__('Other parameters')}}</span>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Remote Job Active Duration (days)')}}</div>
                <div class="col-2">
                    <input  type="number" name="remjob_active_duration"
                            value="{{ !is_null( old('remjob_active_duration'))? old('remjob_active_duration') : $adminOptions[5]->value }}"               
                    >
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-4 pt-3">{{__('Support email')}}</div>
                <div class="col-4">
                    <input  type="text" name="support_email" style="margin:0 !important;"
                            value="{{ !is_null( old('support_email'))? old('support_email') : $adminTextOptions[0]->value }}"               
                    >
                </div>
            </div> 

        </div>

        <button type="submit" class="btn btn-warning mb-2" style="margin-left:28px;">Update</button>
    </form>

</div>
    
@endsection