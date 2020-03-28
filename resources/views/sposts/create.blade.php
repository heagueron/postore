@extends('layouts.app')

@section('title', 'Create post')

@section('content')

<button class="add-new-post-button btn btn-primary"  id="add_new_post" title="Add new post" tabindex=""> 
    <i class="fas fa-plus"></i> 
    <span class="ml-3">Add new post</span> 
</button>

<h3 class="inline-block" id="new-compose-title" style="display:none;">New Post</h3>
<hr>

<div class="collapse" id="create_post_content">

    <form action="/sposts" method="post">
        @csrf

        {{-- Social profiles --}}
        <div class="form-group mt-2">
            <label for="text">From</label><br/>
            @foreach($user->twitter_profiles as $tp)
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="checkbox" name="twitter_accounts[]" value="{{$tp->id}}"> 
                        <label><i class="fab fa-twitter-square fa-2x"></i> {{$tp->handler}}</label>
                    </label>
                </div>
            @endforeach
        </div>
        @if( session()->has('profile_error') )
            <div class="alert alert-danger">{{ session()->get('profile_error') }}</div>
        @endif

        {{-- New post text content --}}
        <div class="form-group">
            <textarea name="text" class="form-control" autocomplete="off" 
                      rows="4" cols="50" id="post_text" placeholder="What would you like to tell?">
                {{ old('text') }}
            </textarea>
        </div>
        @error('text') <div class="alert alert-danger">{{ $message }}</div> @enderror
        
        <!-- <div title="Add an image" id="show_img_loader">
            <i class="fab fa-instagram fa-2x"></i>
        </div>
        <div style="display:none;" id="load_post_img">
            
        </div> -->

        {{-- Date and time picker --}}
        <div class="form-group" title="Choose a date and a time">
            <input 
                class="form-control" 
                type="datetime-local" 
                value="{{$currentDate}}" 
                name='post_date' 
                id="post_date"
                min="{{$currentDate}}">
        </div>       
        @if( session()->has('date_error') )
            <div class="alert alert-danger">
                {{ session()->get('date_error') }}
            </div>
        @endif
        @error('post_date')
            <div class="alert alert-danger">
                {{ $message }}
            </div> 
        @enderror

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <button class="btn btn-primary" type="submit">Schedule the post</button>
        <button class="btn btn-success" id="post_now">Post it now!</button>
        
    </form>

</div>



{{-- Form for the image uploading --}}
<!-- <form action="{{route('sposts.image')}}" method="post" enctype="multipart/form-data" id="image_form">
    @csrf
</form> -->

@endsection