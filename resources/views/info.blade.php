@extends('layouts.app')

@section('title', 'Remote Jobs | Information')

@section('content')

    <div class="failure-publish">
        <h4>{{ $infoMessage }}</h4>
        <a type="button" class="btn btn-primary" href="{{ route('social_profiles.index') }}">SOCIAL ACCOUNTS</a>
    </div>

@endsection