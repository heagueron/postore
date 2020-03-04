@extends('layouts.app')

@section('title', 'STweets to post')

@section('content')

<h1>{{ $user->name }}, Schedule your tweet here</h1>
twitterProfileId: {{ $user->twitter_profiles->first()->id }}
<form action="/stweets" method="post">
    @csrf

    <label for="text">Write your tweet</label><br/>
    <textarea name="text" autocomplete="off" rows="4" cols="50"></textarea><br/>

    Datetime:
    <datetime format="YYYY-MM-DD H:i:s" width="300px" name='pickedDate' firstDayOfWeek="1"></datetime>

    <input type="hidden" name="twitter_profile_id" value="{{ $user->twitter_profiles->first()->id }}">

    <br><button class="btn btn-primary" type="submit">Save</button>

</form>

@error('name') <small style="color:red">{{ $message }} </small> @enderror

@endsection