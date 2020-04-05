<h3> Your scheduled posts</h3>

<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">To be posted on</th>
      <th scope="col">Text</th>
      <th scope="col">Profiles</th>
      <th scope="col">Posted</th>
    </tr>
  </thead>

  <tbody>
    @forelse( $sposts as $spost )
        <tr>
            <td>{{ $spost->post_date }}</td>
            <td>
              <div class="post-text-container">
                @foreach( explode("\r\n", $spost->text) as $line )
                    {{ $line }}<br/>
                @endforeach
              </div>
              @if($spost->media_files_count > 0)
                <div class="post-media-container">
                  <img 
                    src="{{ asset('storage/' . $spost->media_1) }}" class="show-image-1" alt="" >
                </div>
              @endif
            </td>
            <td>
                @foreach( $spost->twitter_profiles as $twitterProfile)
                    <span>{{ $twitterProfile->handler }}</span>
                @endforeach
            </td>
            <td>{{ $spost->posted }}</td>
        </tr>
    @empty
        <p>No scheduled post pending</p>
    @endforelse
  </tbody>

</table>
