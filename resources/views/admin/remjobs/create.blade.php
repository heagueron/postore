@extends('layouts.app')

@section('title', 'Admin | Edit remjob')

@section('content')

    <div class="d-flex justify-content-between my-3 mx-5">
        <h3>
            <span>{{__('Create a remjob')}}</span>
        </h3>
        <a href="{{ route('admin.remjobs.index') }}" style="color:#4CAF50;">
            Back to Admin Dashboard | Remjobs <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <hr class="m-2">

    <div class="container">

        <form action="{{ route('remjobs.store') }}" method="post" enctype="multipart/form-data" id="post-job-form">
            @csrf

            <button class="post-button" type="submit">
                Create the job!
            </button>

        </form>

    </div>

    
@endsection
