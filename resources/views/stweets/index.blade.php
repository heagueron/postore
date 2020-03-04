@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>Scheduled statuses for: {{ $user->name }}</h1>

<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">To be posted on</th>
      <th scope="col">Text</th>
      <th scope="col">Posted</th>
    </tr>
  </thead>

  <tbody>
    @forelse( $stweets as $stweet )
        <tr>
            <td>{{ $stweet->post_date }}</td>
            <td>
                @foreach( explode("\r\n", $stweet->text) as $line )
                    {{ $line }}<br/>
                @endforeach    
            </td>
            <td>{{ $stweet->posted }}</td>
        </tr>
    @empty
        <p>No tweets available. </p>
    @endforelse
  </tbody>

</table>


@endsection