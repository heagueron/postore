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
            <x-spost-form mode="edit" :spost="$spost"  />
            
            <input hidden name="user_id" value="{{ $user->id }}" id="post-user-id">
            <!-- <input hidden name="send-now" value="false" id="send-now-flag"> -->

            <button class="btn btn-primary disabled" type="submit" id="submit-update">Save changes</button>
            <a type="button" role="button" href="{{ route('sposts.schedule') }}" class="btn btn-success">Cancel</a>
            <!-- <button class="btn btn-success" id="post_now">Post it now!</button> -->
            
        </form>

    </div>

</div>


@endsection