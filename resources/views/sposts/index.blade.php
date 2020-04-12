<h3> Scheduled Posts</h3>

{{-- LARGE DEVICES --}}
<table class="table table-sm posts-table-large" >
  <thead>
    <tr>
      <th scope="col" style="width: 300px;">Post on</th>
      <th scope="col" style="width: 1200px;">Content</th>
      <th scope="col" style="width: 300px;">Profiles</th>
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
            </td>
            <td class="show-post-text">
                @foreach( $spost->twitter_profiles as $twitterProfile)
                    <i class="fab fa-twitter-square fa-2x"></i> {{ $twitterProfile->handler }}<br>
                @endforeach
            </td>
        </tr>
    @empty
        <p>No scheduled post pending</p>
    @endforelse
  </tbody>

</table>

{{-- SMALL DEVICES --}}
<table class="table table-sm posts-table-small" >
  <thead>
    <tr>
      <th scope="col">Content</th>
      <th scope="col">Profiles</th>
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
            </td>
            
            <td class="show-post-text d-flex align-items-start flex-column">
              <div class="mb-auto">
                @foreach( $spost->twitter_profiles as $twitterProfile)
                    <i class="fab fa-twitter-square fa-2x"></i> {{ '@' . $twitterProfile->handler }}<br>
                @endforeach
              </div>
              <div class="mt-4">
                <p style="margin-bottom: 2px;font-weight: bold; color:#212529; font-size: 0.8rem;">Post On</p>
                <p style="margin-bottom: 2px;">{{ Str::of($spost->post_date)->before(' ') }}</p>
                <p>{{ Str::of($spost->post_date)->after(' ') }}</p>
              </div>
                
            </td>
        </tr>
    @empty
        <p>No scheduled post pending</p>
    @endforelse
  </tbody>

</table>

