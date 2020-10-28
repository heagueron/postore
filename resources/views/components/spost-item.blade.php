<div class="d-flex">
    <div class="show-post-profiles">

        {{-- First twitter_profile --}}
        <label class="show-social-selector" title="{{'@' . $spost->twitter_profiles()->first()->handler}}"  data-toggle="tooltip">
            <i class="fab fa-twitter-square show-social-selector-twitter"></i>
            <img src="{{ $spost->twitter_profiles()->first()->avatar }}" class="show-avatar img-fluid" alt="" >           
        </label>

        {{-- All that post this --}}
        @if( $spost->twitter_profiles()->count() > 1)
            <div class="show-other-profiles-container">
            
                <div class="show-other-profiles-trigger" id="{{'other-profiles-' .$spost->id}}">
                    <i class="fas fa-ellipsis-h" title="Full profiles list" data-toggle="tooltip"></i>
                </div>

                <div class="show-other-profiles hidden-other-profiles" id="{{'other-profiles-' .$spost->id}}">
                    @foreach( $spost->twitter_profiles as $tp)
                    <div class="show-other-profiles-item">
                        {{'@' .$tp->handler}}
                    </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{--show-post-options-container--}}
        <div class="show-post-options-container">

            <div class="show-post-options-trigger" id="{{'trigger-' .$spost->id}}">
            <i class="fas fa-cog" title="Post options" data-toggle="tooltip"></i>
            </div>
            
            <div class="show-post-options-menu hidden-options-menu" id="{{'menu-' .$spost->id}}">
            
            @if($mode == 'index')
                <div class="show-post-options-item">
                    <a class="ml-2" href="{{ route('sposts.edit', $spost->id) }}">Edit</a>
                </div>
                <div class="show-post-options-item">
                    <form method="POST" action="{{ route('sposts.send_now', $spost->id) }}">
                    @csrf @method('POST')
                    <button type="submit" class="post-options-btn"
                        title="Send Now this scheduled post">
                        Send Now
                    </button>
                    </form>
                </div>
                <div class="show-post-options-item">
                    <form method="POST" action="{{ route('sposts.destroy', $spost->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="post-options-btn"
                        title="Delete this scheduled post">
                        Delete the post
                        </button>
                    </form>
                </div>

            @elseif($mode == 'archive')
                <div class="show-post-options-item">
                    <a class="ml-2" href="{{ route('sposts.edit', $spost->id) }}">Re-post</a>
                </div>
                <div class="show-post-options-item">
                    <form method="POST" action="{{ route('sposts.destroy', $spost->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="post-options-btn"
                        title="Delete this scheduled post">
                        Delete the post
                        </button>
                    </form>
                </div>
            @endif

            </div>
        </div>
        
    </div>

    <div class="row content-row">
        <div class="show-post-content mb-2 col-sm-9">
            {{-- Post text --}}
            <div class="show-post-text mb-2">
                @foreach( explode("\r\n", $spost->text) as $line )
                    {{ $line }}<br/>
                @endforeach 
            </div>
        
            {{-- Post media --}}
            @if($spost->media_files_count > 0)

            <div class="post-media-container d-flex ml-3">

                @switch($spost->media_files_count)
                    @case(1)
                    <div class="d-flex flex-column" id="mediaColumn1" >
                        <div class="media-item-container"data-name="{{$spost->names[0]}}">
                        <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-1 img-fluid" alt="" >
                        </div>
                    </div>    

                    @break

                    @case(2)
                    <div class="d-flex flex-column"  id="mediaColumn1" >
                        <div class="media-item-container"data-name="{{$spost->names[0]}}">
                        <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-2 img-fluid" alt="" >
                        </div>
                    </div> 

                    <div class="d-flex flex-column" id="mediaColumn2">
                        <div class="media-item-container" data-name="{{$spost->names[1]}}">
                        <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-2 img-fluid" alt="" >
                        </div>
                    </div> 

                    @break
                
                    @case(3)
                    <div class="d-flex flex-column"  id="mediaColumn1" >
                        <div class="media-item-container"data-name="{{$spost->names[0]}}">
                        <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-2 img-fluid" alt="" >
                        </div>
                    </div>

                    <div class="d-flex flex-column" id="mediaColumn2">
                        <div class="media-item-container" data-name="{{$spost->names[1]}}">
                        <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-3 img-fluid" alt="" >
                        </div>
                        <div class="media-item-container" data-name="{{$spost->names[2]}}">
                        <img src="{{ asset('storage/' . $spost->media[2]) }}" class="show-image-3 img-fluid" alt="" >
                        </div>
                    </div> 
                    @break

                    @case(4)
                    <div class="d-flex flex-column"  id="mediaColumn1" >
                        <div class="media-item-container"data-name="{{$spost->names[0]}}">
                        <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-3 img-fluid" alt="" >
                        </div>
                        <div class="media-item-container" data-name="{{$spost->names[1]}}">
                        <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-3 img-fluid" alt="" >
                        </div>

                    </div>
                    

                    <div class="d-flex flex-column" id="mediaColumn2">
                        <div class="media-item-container" data-name="{{$spost->names[2]}}">
                        <img src="{{ asset('storage/' . $spost->media[2]) }}" class="show-image-3 img-fluid" alt="" >
                        </div>
                        <div class="media-item-container" data-name="{{$spost->names[3]}}">
                        <img src="{{ asset('storage/' . $spost->media[3]) }}" class="show-image-3 img-fluid" alt="" >
                        </div>
                    </div>
                    @break

                    @default
                        Default case...
                @endswitch

            </div> <!-- End of global post media container -->

            @endif
        </div>
        <div class="show-post-date col-sm-3">
            <!-- <div class="date-lg">
                <p class="mb-1 show-date-node" title="Post date" data-toggle="tooltip">
                    {{ Str::of($spost->post_date)->before(' ') }}
                </p>
                <p>{{ Str::of($spost->post_date)->after(' ') }}</p>
            </div> -->
            <div class="d-flex">
                <p class="mb-1 show-date-node" title="Post date" data-toggle="tooltip">
                    {{ $spost->post_date }}
                </p>
            </div>
            
        </div>
    </div>

</div>

@if($mode == 'archive')

    <div class="show-post-engagement">
        <span>{{'@' . $spost->twitter_profiles()->first()->handler}}</span>

        <span class="ml-3" style="color:green;">
            <i class="fas fa-retweet" title="Retweets" data-toggle="tooltip"></i>
        </span>
        {{ $spost->engagement[$spost->twitter_profiles()->first()->id]['retweet_count'] }}

        <span class="ml-3" style="color:red;">
            <i class="fas fa-heart" title="Likes" data-toggle="tooltip"></i>
        </span>
        {{ $spost->engagement[$spost->twitter_profiles()->first()->id]['favorite_count'] }}
    </div>

@endif