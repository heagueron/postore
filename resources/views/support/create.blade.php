@extends('layouts.auth')

@section('content')
<div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100">
                <div class="col-md-6 col-lg-5 col-xl-5 py-6 py-md-0">
                    <div class="card shadow zindex-100 mb-0">
                        <div class="card-body px-md-5 py-5">
                            <div class="mb-5 text-center">
                                <img src="{{ asset('images/remjob.png') }}" alt="remjob" class="w-25" >
                            </div>
                            <span class="clearfix"></span>
                            <form method="POST" action="{{ route('support.store') }}">
                                @csrf

                                {{-- Name --}}
                                <div class="form-group">
                                    <label  for="name" class="form-control-label">{{ __('auth.nameLabel') }}</label>
                                    <div class="input-group">
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="{{__('auth.namePlaceholder')}}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label  for="email" class="form-control-label">{{ __('auth.emailLabel') }}</label>
                                    <div class="input-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('auth.emailPlaceholder')}}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="form-group">
                                    <label  for="support-request" class="form-control-label">{{ __('Message') }}</label>
                                    <textarea class="form-control" name="support-request" id="support-request" rows="4">
                                        {{ old('support-request') }}       
                                    </textarea>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-auth" style="background-color:#4CAF50 !important;color:#fff;">
                                        {{ __('Send') }}
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
