@extends('layouts.app')

@section('title', 'Scheduler')

@section('content')

@if( !session()->has('errors') && !session()->has('date_error') )
<button class="add-new-post-button btn btn-primary"  id="add_new_post" title="Add new post" tabindex=""> 
    <i class="fas fa-plus"></i> 
    <span class="ml-3">Add new post</span> 
</button>
@endif

@if( session()->has('info') )
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Info: </strong> {{ session()->get('info')}}
    </div>
@endif

{{-- Scheduled Post (Spost) Form --}}

@if( session()->has('errors') || session()->has('date_error') )
    <div id="new-scheduled-post" style="display:block">
@else
    <div id="new-scheduled-post" style="display:none">
@endif

    <h3 class="inline-block" id="new-compose-title">New Scheduled Post</h3>
    <hr>
    <div id="create_post_content">

        <form action="/sposts" method="post" enctype="multipart/form-data">
            @csrf

            {{-- Social profiles --}}
            <div class="form-group social-profiles-container mt-2">
                <label>From</label><br/>
                <div class="d-flex">
                    @foreach($user->twitter_profiles as $tp)
                        <div class="mr-3">
                            <input hidden
                                type="checkbox" 
                                class="custom-control-input" 
                                id="{{'tp-' .$tp->id}}" 
                                name="twitter_accounts[]" 
                                value="{{$tp->id}}">
                        
                            <label class="social-selector social-selector-inactive" 
                                for="{{'tp-' .$tp->id}}" title="{{'@' . $tp->handler}}">
                                <i class="fab fa-twitter-square social-selector-twitter"></i>

                                <img src="{{ $tp->avatar }}" class="show-avatar img-fluid" alt="" >
                                <i class="fas fa-check-circle social-selector-check check-inactive"
                                    id="{{'check-' .$tp->id}}">
                                </i>
                                
                            </label>
                        </div>

                    @endforeach
                </div>
                
                @if( session()->has('profile_error') )
                    <div class="alert alert-danger">{{ session()->get('profile_error') }}</div>
                @endif
            </div>
            
            {{-- New post text content --}}
            <div class="form-group post-text-group">
                <textarea name="text" class="form-control post-text-container" autocomplete="off" 
                        rows="4" cols="50" id="post_text" placeholder="What would you like to tell?"
                        maxlength="280">
                    {{ old('text') }}
                </textarea>
                <p id="post-character-count" class="post-character-count" value="0">0</p>
                @error('text') <div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
                
            {{-- Media file loader --}}
            <div class="media-files-container" id="media-files-container">
                <input hidden name="media_files_count" value="0" id="media_files_count">
                <input hidden type='file' id="imageUpload0" name="media_1" accept=".png, .jpg, .jpeg" />
                <input hidden type='file' id="imageUpload1" name="media_2" accept=".png, .jpg, .jpeg" />
                <input hidden type='file' id="imageUpload2" name="media_3" accept=".png, .jpg, .jpeg" />
                <input hidden type='file' id="imageUpload3" name="media_4" accept=".png, .jpg, .jpeg" />

                {{-- Preview media files --}}
                <div class="avatar-preview d-flex mb-2" id="image-preview-container">
                    <div class="d-flex flex-column" id="previewColumn1"></div>
                    <div class="d-flex flex-column" id="previewColumn2"></div>
                    <!-- <div id="imagePreview" class="imagePreview"></div> -->
                </div>
                @error('media_1') <div class="alert alert-danger">{{ $message }}</div> @enderror
                @error('media_2') <div class="alert alert-danger">{{ $message }}</div> @enderror
                @error('media_3') <div class="alert alert-danger">{{ $message }}</div> @enderror
                @error('media_4') <div class="alert alert-danger">{{ $message }}</div> @enderror
                {{-- Add media button --}}
                <button class="add-media-button btn btn-primary mb-4"  id="add-media-button" title="Add media" tabindex=""> 
                    <i class="fab fa-instagram"></i> 
                    <span class="ml-2">Add file</span> 
                </button>
                
            </div>

            {{-- Date and time picker --}}
            <div class="form-group datetime-container" title="Choose a date and a time">
                <input 
                    class="form-control" 
                    type="datetime-local" 
                    value="{{$currentDate}}" 
                    name='post_date' 
                    id="post_date"
                    min="{{ $currentDate }}">
                
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
            </div>       
            
            <input hidden name="user_id" value="{{ $user->id }}" id="post-user-id">
            <input hidden name="send-now" value="false" id="send-now-flag">

            <button class="btn btn-primary disabled" type="submit" id="submit-schedule">Schedule the post</button>
            <button class="btn btn-success disabled" id="post_now">Post it now!</button>
            
        </form>

    </div>

</div>





{{-- Scheduled Posts (sposts) --}}
<div class="mt-4">
@include('sposts.index')
</div>


@endsection