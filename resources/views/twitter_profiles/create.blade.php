@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>{{ $user->name}}, Let's create your Twitter Profile(s) here</h1>

<p>Request Token: {{ $request_token }}</p>
@endsection