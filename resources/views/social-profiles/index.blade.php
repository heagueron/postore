@extends('layouts.app')

@section('title', 'Scheduler')

@section('content')
<h1 class="page-title d-flex justify-content-center">SOCIAL PROFILES</h1>
<div class="page-subtitle">
    <h3><strong>MANAGE SOCIAL ACCOUNTS</strong> </h3>
    Check the linked social accounts you use to post your messages.  
    Add or remove accounts as needed.
</div>

<div class="social-profiles-content">

    {{-- Twitter profiles --}}
    <div class="social-profile-list-wrapper">
        <div class="social-profile-header">
            <i class="fab fa-twitter-square fa-2x"></i>
            <span class="social-profile-name">TWITTER<span>
        </div>
        <div class="social-profile-list">
            @forelse( auth()->user()->twitter_profiles as $tp)
                <div class="social-profile-item d-flex justify-content-between align-items-baseline mb-2">
                    <div class="social-profile-info">
                        <img src="{{ $tp->avatar }}" class="show-avatar img-fluid" alt="" >   
                        <label class="pl-2">
                            {{'@' . $tp->handler}}
                        </label>
                    </div>
                    

                    <form method="POST" action="{{ route('twitter_profiles.destroy', $tp->id) }}">
                        @csrf
                        @method('DELETE')
                        <i class="fas fa-unlink" style="color:#e3342f; font-size:1.2rem;"
                            title="{{'Unlink @' .$tp->handler. ' account'}}">
                        </i>
                        
                    </form> 
                </div>
            @empty
                <span><p class="no-social-profile-found">No Twitter Profile linked</p></span>     
            @endforelse
        </div>
        <a type="button" class="btn btn-add-tw" href="{{ route('twitter_profiles.create') }}">
            <i class="fab fa-twitter pr-3"></i>Add a Twitter Profile
        </a>

    </div>

    <!-- {{-- Facebook profiles --}}
    <div class="social-profile-list-wrapper">
        <div class="social-profile-header">
            <i class="fab fa-facebook-square fa-2x"></i>
            FACEBOOK
        </div>
        <div class="social-profile-list">
            put Facebook profiles here
        </div>
    </div>

    {{-- Linkedin profiles --}}
    <div class="social-profile-list-wrapper">
        <div class="social-profile-header">
            <i class="fab fa-linkedin-square fa-2x"></i>
            LINKEDIN
        </div>
        <div class="social-profile-list">
            put Linkedin profiles here
        </div>
    </div> -->

</div>




@endsection