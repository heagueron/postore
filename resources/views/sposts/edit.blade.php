@extends('layouts.app')

@section('title', 'Edit')

@section('content')
{{-- Scheduled Post (Spost) Form --}}


    <div id="new-scheduled-post">


    <h3 class="inline-block" id="new-compose-title">Update Scheduled Post</h3>
    <hr>
    <div id="create_post_content">

        <form action="{{ route('sposts.update', $spost->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Social profiles --}}
            <div class="form-group social-profiles-container mt-2">

                <!--Hidden to identify edit page load-->
                <input hidden class="edit-spost" type="text" id="{{'edit-' . $spost->id}}">

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
            
            {{-- Post text content --}}
            <div class="form-group post-text-group">
                <textarea name="text" class="form-control post-text-container" autocomplete="off" 
                        rows="4" cols="50" id="post_text" placeholder="What would you like to tell?"
                        maxlength="280">
                    {{ !is_null( old('text'))? old('text') : $spost->text }}
                </textarea>
                <p id="post-character-count" class="post-character-count" 
                    value="{{ !is_null( old('text'))? strlen(trim(old('text'))) : strlen(trim($spost->text)) }}">
                </p>
                @error('text') <div class="alert alert-danger">{{ $message }}</div> @enderror
            </div>
                
            {{-- Media file loader --}}
            <div class="media-files-container" id="media-files-container">

                {{-- Hidden to identify removed media (by setting value to 1) --}}
                <input hidden name="ck-media-1" id="ck-media-1" value="0" 
                    data-media-present="{{is_null($spost->media_1)? false : true }}">

                <input hidden name="ck-media-2" id="ck-media-2" value="0"
                    data-media-present="{{is_null($spost->media_2)? false : true }}">
                    
                <input hidden name="ck-media-3" id="ck-media-3" value="0"
                    data-media-present="{{is_null($spost->media_3)? false : true }}">

                <input hidden name="ck-media-4" id="ck-media-4" value="0"
                    data-media-present="{{is_null($spost->media_4)? false : true }}">

                {{-- Hidden to identify media count --}}
                <input hidden name="media_files_count" value="{{$spost->media_files_count}}" id="media_files_count">

                {{-- The inputs will be created via jaavascript according to the media files received --}}
                <!-- <input hidden type='file' id="imageUpload0" name="media_1" accept=".png, .jpg, .jpeg" />
                <input hidden type='file' id="imageUpload1" name="media_2" accept=".png, .jpg, .jpeg" />
                <input hidden type='file' id="imageUpload2" name="media_3" accept=".png, .jpg, .jpeg" />
                <input hidden type='file' id="imageUpload3" name="media_4" accept=".png, .jpg, .jpeg" /> -->

                {{-- Preview media files --}}
                <div class="avatar-preview d-flex mb-2" id="image-preview-container">
                    <div class="d-flex flex-column" id="previewColumn1"></div>
                    <div class="d-flex flex-column" id="previewColumn2"></div>
                </div>



                @error('media_1') <div class="alert alert-danger">{{ $message }}</div> @enderror
                @error('media_2') <div class="alert alert-danger">{{ $message }}</div> @enderror
                @error('media_3') <div class="alert alert-danger">{{ $message }}</div> @enderror
                @error('media_4') <div class="alert alert-danger">{{ $message }}</div> @enderror

                {{-- Add media button --}}
                @if( $spost->media_files_count < 4 )
                    <button class="add-media-button btn btn-primary mb-4"  id="add-media-button" title="Add media" tabindex=""> 
                        <i class="fab fa-instagram"></i> 
                        <span class="ml-2">Add file</span> 
                    </button>
                @endif
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
            <!-- <input hidden name="send-now" value="false" id="send-now-flag"> -->

            <button class="btn btn-primary" type="submit" id="submit-schedule">Save changes</button>
            <a type="button" role="button" href="{{ route('sposts.schedule') }}" class="btn btn-success">Cancel</a>
            <!-- <button class="btn btn-success" id="post_now">Post it now!</button> -->
            
        </form>

    </div>

</div>


@endsection