@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>SCHEDULED CONTENT</h1>

<form action="/stweets" method="post">
    @csrf
    <label for="text">Write your tweet</label><br/>
    <textarea name="text" autocomplete="off" rows="4" cols="50"></textarea><br/>

    </br><smal>twitter_profile_id: {{ $user->twitter_profiles->first()->id }}</small></br>
    <!--<input type="hidden" name="twitter_profile_id" value="{{ $user->twitter_profiles->first()->id }}">-->

    <button type="submit">Save</button>
</form>
@error('name') <small style="color:red">{{ $message }} </small> @enderror

@endsection