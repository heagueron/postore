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
    
        

        <form action="{{ route('remjobs.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Title</label>
                <input type="text" class="form-control" name="name" value="">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <!--<textarea name="description" autocomplete="off" rows="4" cols="50"></textarea><br/><br/>-->
                <textarea class="form-control"
                    name="description" 
                    id="productDescription">
                </textarea>
            </div>
            
            <div class="form-group">
                <label for="product">Upload your product</label>
                <input lang="en"
                    type="file"
                    class="form-control-file"
                    name="path"
                >
                @if( $errors->has('path'))
                <strong>{{ $errors->first('path') }}</strong>
                @endif
            </div>
            
            <div class="form-group">
                <label for="image">Image</label>
                <input lang="en"
                    type="file"
                    class="form-control-file"
                    id="image"
                    name="image"
                >
                @if( $errors->has('image'))
                    <strong>{{ $errors->first('image') }}</strong>
                @endif
            </div>

            <!-- Salary -->
            <div class="form-group">
                <label for="salary">Salary</label>

                <input class="form-control"
                    type="number"
                    id="salary"
                    name="salary"
                >
                @if( $errors->has('salary'))
                    <strong>{{ $errors->first('salary') }}</strong>
                @endif
            </div>

            <br><button class="btn btn-primary" type="submit">Post this remote job</button>

        </form>

    <!-- @error('name') <small style="color:red">{{ $message }} </small> @enderror -->
    </div>

    

@endsection
