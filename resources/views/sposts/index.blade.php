<h3> Scheduled Posts</h3>

{{-- LARGE DEVICES --}}
<table class="table table-sm posts-table-large" >

  <thead>
    <tr>
      <th scope="col" style="width: 300px;">Post on</th>
      <th scope="col" style="width: 1200px;">Share</th>
      <th scope="col" style="width: 300px;">From</th>
    </tr>
  </thead>

  <tbody>
    @forelse( $sposts as $spost )
        <tr>

            <td class="show-post-text">
              <p style="margin-bottom: 2px;">{{ Str::of($spost->post_date)->before(' ') }}</p>
              <p>{{ Str::of($spost->post_date)->after(' ') }}</p>
            </td>

            <td>
              <div class="show-post-text">
                @foreach( explode("\r\n", $spost->text) as $line )
                    {{ $line }}<br/>
                @endforeach
              </div>

              @if($spost->media_files_count > 0)

              <div class="post-media-container d-flex mb-2">

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

            </td>
            <td class="show-post-text">

                {{-- Reduced twitter_profiles list --}}
                <!-- {{$spost->twitter_profiles()->first()->handler}} -->
                {{-- First twitter_profile --}}
                <label class="social-selector" title="{{'@' . $spost->twitter_profiles()->first()->handler}}"  data-toggle="tooltip">
                  <i class="fab fa-twitter-square social-selector-twitter"></i>
                  <img src="{{ $spost->twitter_profiles()->first()->avatar }}" class="show-avatar img-fluid" alt="" >           
                </label>

                {{-- All that will post this --}}
                @if( $spost->twitter_profiles()->count() > 1)
                  <div class="show-other-profiles-container">
                    
                    <div class="show-other-profiles-trigger" id="{{'other-profiles-' .$spost->id}}">
                      <i class="fas fa-ellipsis-h" title="All that will post this" data-toggle="tooltip"></i>
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

                <!-- {{-- Full twitter_profiles list --}}
                @foreach( $spost->twitter_profiles as $tp)

                    <label class="social-selector" title="{{'@' . $tp->handler}}"  data-toggle="tooltip">
                        <i class="fab fa-twitter-square social-selector-twitter">
                        </i>
                        <img src="{{ $tp->avatar }}" class="show-avatar img-fluid" alt="" >           
                    </label>

                @endforeach
                {{-- End Full twitter_profiles list --}} -->

                {{--show-post-options-container--}}
                <div class="show-post-options-container">

                  <div class="show-post-options-trigger" id="{{'trigger-' .$spost->id}}">
                    <i class="fas fa-cog" title="Schedule post options" data-toggle="tooltip"></i>
                  </div>
                  
                  <div class="show-post-options-menu hidden-options-menu" id="{{'menu-' .$spost->id}}">

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

                  </div>
                </div>


            </td>
        </tr>
    @empty
        <p class="posts-table-large">No scheduled post pending</p>
    @endforelse
  </tbody>

</table>

{{-- SMALL DEVICES --}}
<table class="table table-sm posts-table-small " >

  <thead>
    <tr>
      <th scope="col">Share</th>
      <th scope="col">From</th>
    </tr>
  </thead>

  <tbody>
    @forelse( $sposts as $spost )
        <tr>

            <!-- <td class="show-post-text">
              <p style="margin-bottom: 2px;">{{ Str::of($spost->post_date)->before(' ') }}</p>
              <p>{{ Str::of($spost->post_date)->after(' ') }}</p>
            </td> -->

            <td>
              <div class="show-post-text">
                @foreach( explode("\r\n", $spost->text) as $line )
                    {{ $line }}<br/>
                @endforeach
              </div>
              @if($spost->media_files_count > 0)
              <div class="post-media-container d-flex mb-2">

                @switch($spost->media_files_count)
                  @case(1)
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-1 img-fluid" alt="" >
                  </div>
                  <div class="d-flex flex-column"></div>
                  @break

                  @case(2)
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-2 img-fluid" alt="" >
                  </div>
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-2 img-fluid" alt="" >
                  </div>
                  @break
                  
                  @case(3)
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-2 img-fluid" alt="" >
                  </div>
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-3 img-fluid" alt="" >
                    <img src="{{ asset('storage/' . $spost->media[2]) }}" class="show-image-3 img-fluid" alt="" >
                  </div>
                  @break

                  @case(4)
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[0]) }}" class="show-image-3 img-fluid" alt="" >
                    <img src="{{ asset('storage/' . $spost->media[1]) }}" class="show-image-3 img-fluid" alt="" >
                  </div>
                  <div class="d-flex flex-column">
                    <img src="{{ asset('storage/' . $spost->media[2]) }}" class="show-image-3 img-fluid" alt="" >
                    <img src="{{ asset('storage/' . $spost->media[3]) }}" class="show-image-3 img-fluid" alt="" >
                  </div>
                  @break

                  @default
                      Default case...
                @endswitch

              </div>
              @endif

              <div class="mt-1">
                <span style="font-weight: bold; color:#212529; font-size: 0.8rem;" title="To be posted on">{{ $spost->post_date }}</span>
              </div>

            </td>
            
            <td class="show-post-text d-flex align-items-start flex-column">
              <div class="mb-auto">
                @foreach( $spost->twitter_profiles as $tp)

                  <label class="social-selector" title="{{'@' . $tp->handler}}">
                      <i class="fab fa-twitter-square social-selector-twitter">
                      </i>
                      <img src="{{ $tp->avatar }}" class="show-avatar img-fluid" alt="" >           
                  </label>

                @endforeach
              </div>

              <i class="fas fa-cog"></i>
                
            </td>
        </tr>
    @empty
        <p class="posts-table-small">No scheduled post pending</p>
    @endforelse
  </tbody>

</table>

