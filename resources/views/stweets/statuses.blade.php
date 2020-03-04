@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>Recent statuses for: {{ $content->name }}</h1>

@forelse( $statuses as $status )
    <p><strong>Date: </strong>{{ $status->created_at }}</p>
    <p><strong>Text: </strong>{{ $status->text }}</p>
    <br>
@empty
    <p>No tweets available. </p>
@endforelse

@endsection