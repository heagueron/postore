@extends('layouts.app')

@section('title', 'Create post')

@section('content')

<h3>{{ $user->name }}, schedule your post here</h3>

<form action="/sposts" method="post">
    @csrf

    <div class="form-group">
        <label for="text">Your content</label>
        <textarea name="text" class="form-control" autocomplete="off" rows="4" cols="50" id="post_text">
            {{ old('text') }}
        </textarea>
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
    @if( session()->has('profile_error') )
        <div class="alert alert-danger">{{ session()->get('profile_error') }}</div>
    @endif

    <div class="form-group">
        <label for="post_date">Date and time</label>
        <input class="form-control" type="datetime-local" value="2020-10-10T10:00" name='post_date' id="post_date">
    </div>
    
    @if( session()->has('date_error') )
        <div class="alert alert-danger">{{ session()->get('date_error') }}</div>
    @endif

    @error('post_date') <div class="alert alert-danger">{{ $message }}</div> @enderror

    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <br><button class="btn btn-primary" type="submit">Save</button>
    <br><button class="btn btn-success" id="post_now">Post it now!</button>
    
</form>

@endsection