@extends('layouts.app')

@section('title', 'Scheduler')

@section('content')

@if( !session()->has('errors') && !session()->has('date_error') )
    <button class="add-new-post-button btn btn-primary"  id="add_new_post" title="Add new post" tabindex=""> 
        <i class="fas fa-plus"></i> 
        <span class="ml-3">Add new post</span> 
    </button>
@endif

@if( session()->has('info') )
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Info: </strong> {{ session()->get('info')}}
    </div>
@endif

{{-- Scheduled Post (Spost) Form --}}

@if( session()->has('errors') || session()->has('date_error') )
    <div id="new-scheduled-post" style="display:block">
@else
    <div id="new-scheduled-post" style="display:none">
@endif

    {{-- New New Scheduled Post --}}
    <h3 class="inline-block" id="new-compose-title">New Scheduled Post</h3>
    <hr>
    <div id="create_post_content">

        <form action="/sposts" method="post" enctype="multipart/form-data">
            @csrf

            {{-- New SpostForm Component --}}
            <x-spost-form mode="schedule" :spost="$spost"/>

            {{-- Date and time picker --}}
            <div class="form-group datetime-container" title="Choose a date and a time">
                <input 
                    class="form-control" 
                    type="datetime-local" 
                    value="{{$currentDate}}" 
                    name='post_date' 
                    id="post_date"
                    min="{{ $currentDate }}">
                
                @if( session()->has('date_error') )
                    <div class="alert alert-danger">
                        {{ session()->get('date_error') }}
                    </div>
                @endif
                @error('post_date')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div> 
                @enderror
            </div>       
            
            <input hidden name="user_id" value="{{ $user->id }}" id="post-user-id">
            <input hidden name="send-now" value="false" id="send-now-flag">

            <button class="btn btn-primary disabled" type="submit" id="submit-schedule">Schedule the post</button>
            <button class="btn btn-success disabled" id="post_now">Post it now!</button>
            
        </form>

    </div>

</div>


{{-- Scheduled Posts (sposts) --}}
<div class="mt-4">
    <ul class="list-group list-group-flush">
        @forelse ($sposts as $spost)
            <li class="list-group-item">
               <x-spost-item mode="index" :spost="$spost"/> 
            </li>
        @empty
            <h3>No post scheduled</h3>
        @endforelse
    </ul>
</div>


@endsection