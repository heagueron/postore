<div>
    {{-- Hidden to identify Create/Edit --}}
    <input hidden name="ce-selector" id="ce-selector" value="{{$mode}}">
    
    {{-- Social profiles --}}
    <div class="form-group social-profiles-container mt-2">
        @if($mode=='edit')
        <input hidden class="edit-spost" type="text" id="{{'edit-' . $spost->id}}">
        @endif

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
    
    @if($mode=='schedule')
        {{-- Hidden to identify media count --}}
        <input hidden name="media_files_count" value="0" id="media_files_count">
        
        {{-- Media inputs --}}
        <input hidden type='file' id="imageUpload0" name="media_1" data-assigned="false" accept=".png, .jpg, .jpeg" />
        <input hidden type='file' id="imageUpload1" name="media_2" data-assigned="false" accept=".png, .jpg, .jpeg" />
        <input hidden type='file' id="imageUpload2" name="media_3" data-assigned="false" accept=".png, .jpg, .jpeg" />
        <input hidden type='file' id="imageUpload3" name="media_4" data-assigned="false" accept=".png, .jpg, .jpeg" />

        {{-- Preview media files --}}
        <div class="d-flex mb-2 image-preview-container" style="display:none !important;">
            <div class="d-flex flex-column" id="mediaColumn1" ></div>
            <div class="d-flex flex-column" id="mediaColumn2" ></div>
        </div> <!-- End image-preview-container -->

    @elseif($mode=='edit')
        {{-- Hidden to identify media count --}}
        <input hidden name="media_files_count" value="{{$spost->media_files_count}}" id="media_files_count">

        {{-- Hidden to identify a) if media is changed (by setting value to 1) and b) media present --}}
        <input hidden name="ck-media_1" id="ck-media_1" value="0" 
            data-media-present="{{is_null($spost->media_1)? false : true }}">
        <input hidden name="ck-media_2" id="ck-media_2" value="0"
            data-media-present="{{is_null($spost->media_2)? false : true }}">           
        <input hidden name="ck-media_3" id="ck-media_3" value="0"
            data-media-present="{{is_null($spost->media_3)? false : true }}">
        <input hidden name="ck-media_4" id="ck-media_4" value="0"
            data-media-present="{{is_null($spost->media_4)? false : true }}">

        {{-- Preview media files --}}
        <div class="d-flex mb-2 image-preview-container" style="display:none !important;">
            @switch($spost->media_files_count)

                @case(0)
                    <div class="d-flex flex-column" id="mediaColumn1" ></div>
                    <div class="d-flex flex-column" id="mediaColumn2" ></div>
                    @break

                @case(1)
                    <div class="d-flex flex-column" id="mediaColumn1" >
                        <div class="imagePreview mic-1" data-name="{{$spost->names[0]}}" data-input="{{'imageUpload' .$spost->inputs[0]}}">
                            <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-1 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                    </div>
                    <div class="d-flex flex-column" id="mediaColumn2" ></div>   
                    @break

                @case(2)
                    <div class="d-flex flex-column"  id="mediaColumn1" >
                        <div class="imagePreview mic-2" data-name="{{$spost->names[0]}}" data-input="{{'imageUpload' .$spost->inputs[0]}}">
                            <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-2 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                    </div> 

                    <div class="d-flex flex-column" id="mediaColumn2">
                        <div class="imagePreview mic-2" data-name="{{$spost->names[1]}}" data-input="{{'imageUpload' .$spost->inputs[1]}}">
                            <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-2 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                    </div> 
                    @break
                
                @case(3)
                    <div class="d-flex flex-column"  id="mediaColumn1" >
                        <div class="imagePreview mic-2" data-name="{{$spost->names[0]}}" data-input="{{'imageUpload' .$spost->inputs[0]}}">
                            <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-2 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                    </div>

                    <div class="d-flex flex-column" id="mediaColumn2">
                        <div class="imagePreview mic-3" data-name="{{$spost->names[1]}}" data-input="{{'imageUpload' .$spost->inputs[1]}}">
                            <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-3 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i> 
                        </div>
                        <div class="imagePreview mic-3" data-name="{{$spost->names[2]}}" data-input="{{'imageUpload' .$spost->inputs[2]}}">
                            <img src="{{ asset('storage/' . $spost->media[2]) }}" class="show-image-3 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                    </div> 
                    @break

                @case(4)
                    <div class="d-flex flex-column"  id="mediaColumn1" >
                        <div class="imagePreview mic-3" data-name="{{$spost->names[0]}}" data-input="{{'imageUpload' .$spost->inputs[0]}}">
                            <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-3 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                        <div class="imagePreview mic-3" data-name="{{$spost->names[1]}}" data-input="{{'imageUpload' .$spost->inputs[1]}}">
                            <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-3 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>

                    </div>

                    <div class="d-flex flex-column" id="mediaColumn2">
                        <div class="imagePreview mic-3" data-name="{{$spost->names[2]}}" data-input="{{'imageUpload' .$spost->inputs[2]}}">
                            <img src="{{ asset('storage/' . $spost->media[2]) }}" class="show-image-3 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                        <div class="imagePreview mic-3" data-name="{{$spost->names[3]}}" data-input="{{'imageUpload' .$spost->inputs[3]}}">
                            <img src="{{ asset('storage/' . $spost->media[3]) }}" class="show-image-3 img-fluid" alt="" >
                            <i class="far fa-times-circle removeMedia2"></i>
                        </div>
                    </div>
                    @break

            @endswitch
        </div> <!-- End image-preview-container -->
        

    @endif
   
        @error('media_1') <div class="alert alert-danger">{{ $message }}</div> @enderror
        @error('media_2') <div class="alert alert-danger">{{ $message }}</div> @enderror
        @error('media_3') <div class="alert alert-danger">{{ $message }}</div> @enderror
        @error('media_4') <div class="alert alert-danger">{{ $message }}</div> @enderror
        
        {{-- Add media button --}}
        <button class="add-media-button btn btn-primary mb-4"  id="add-media-button3" title="Add media" tabindex=""> 
            <i class="fab fa-instagram"></i> 
            <span class="ml-2">Add image</span> 
        </button>
    
    </div>

    {{-- Date and time picker --}}
    <div class="form-group datetime-container" title="Choose a date and a time">
        <input 
            class="form-control" 
            type="datetime-local" 
            value="{{ $spost->currentDate }}" 
            name='post_date' 
            id="post_date"
            min="{{ $spost->minDate }}">
        
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

</div>