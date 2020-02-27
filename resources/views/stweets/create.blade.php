@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>{{ $user->name }}, Schedule your tweet here</h1>
TPI: {{ $user->twitter_profiles->first()->id }}

@endsection