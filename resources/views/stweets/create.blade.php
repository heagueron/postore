@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>SCHEDULED CONTENT</h1>

<form action="/stweets" method="post">
    @csrf
    <label for="text">Write your tweet</label><br/>
    <textarea name="text" autocomplete="off" rows="4" cols="50"></textarea><br/>
    <button type="submit">Save</button>
</form>
@error('name') <small style="color:red">{{ $message }} </small> @enderror

@endsection