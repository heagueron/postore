@extends('layouts.app')

@section('title', 'Fail')

@section('content')

    <div class="failure-publish">
        <h4>{{ $publish }}</h4>
        <a type="button" class="btn btn-primary" href="{{ route('social_profiles.index') }}">SOCIAL ACCOUNTS</a>
    </div>

@endsection