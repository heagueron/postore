@extends('layouts.admin')

@section('title', 'Admin|Companies')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
         
        {{-- MODALS --}}
            @include('admin.companies.create')

            <div class="d-flex justify-content-between mb-2">

                <h2>COMPANIES</h2>

                {{-- Open Create Company Modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createCompanyModal">
                    <i class="fas fa-plus-circle"></i>
                </button>
                
            </div>

        </div>
    </div>
</div>

@endsection