@extends('layouts.app')

@section('title', 'Create post')

@section('content')

<h3>{{ $user->name }}, schedule your post here</h3>

<form action="/sposts" method="post">
    @csrf

    <div class="form-group">
        <label for="text">Your content</label>
        <textarea name="text" class="form-control" autocomplete="off" rows="4" cols="50"></textarea>
    </div>
    @error('text') <div class="alert alert-danger">{{ $message }}</div> @enderror
    
    <div class="form-group">
        <label for="text">Social accounts</label><br/>
        @foreach($user->twitter_profiles as $tp)
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox" name="twitter_accounts[]" value="{{$tp->id}}"> 
                    <label><i class="fab fa-twitter-square fa-2x"></i> {{$tp->handler}}</label>
                </label>
            </div>
        @endforeach
    </div>
    @error('twitter_accounts') <div class="alert alert-danger">{{ $message }}</div> @enderror
    
    <div class="form-group">
        <label for="text">Date and time</label><br/>
        <datetime format="YYYY-MM-DD H:i:s" width="300px" name='post_date' firstDayOfWeek="1"></datetime>
    </div>
    @error('post_date') <div class="alert alert-danger">{{ $message }}</div> @enderror

    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <br><button class="btn btn-primary" type="submit">Save</button>

</form>

@endsection