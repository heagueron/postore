@extends('layouts.app')

@section('title', 'Edit')

@section('content')
{{-- Scheduled Post (Spost) Form --}}


    <div id="new-scheduled-post">


    <h3 class="inline-block" id="new-compose-title">Update Scheduled Post</h3>
    <hr>
    <div id="edit_post_content">

        <form action="{{ route('sposts.update', $spost->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- New SpostForm Component --}}
            <x-spost-form mode="edit" :spost="$spost"/>

            {{-- Date and time picker --}}
            <div class="form-group datetime-container" title="Choose a date and a time">
                <input 
                    class="form-control" 
                    type="datetime-local" 
                    value="{{ $currentDate }}" 
                    name='post_date' 
                    id="post_date"
                    min="{{ $minDate }}">
                
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
            <!-- <input hidden name="send-now" value="false" id="send-now-flag"> -->

            <button class="btn btn-primary disabled" type="submit" id="submit-update">Save changes</button>
            <a type="button" role="button" href="{{ route('sposts.schedule') }}" class="btn btn-success">Cancel</a>
            <!-- <button class="btn btn-success" id="post_now">Post it now!</button> -->
            
        </form>

    </div>

</div>


@endsection