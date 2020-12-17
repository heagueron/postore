@extends('layouts.auth')

@section('content')
<div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100">
                <div class="col-md-6 col-lg-5 col-xl-5 py-4 py-md-0">
                    <div class="card shadow zindex-100 mb-0">
                        <div class="card-body px-md-5 py-3">
                            <div class="mb-5 text-center">
                                <img src="{{ asset('images/remjob.png') }}" alt="remjob" class="w-25" >
                            </div>
                            <span class="clearfix"></span>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label  for="name" class="form-control-label">{{ __('auth.nameLabel') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <!-- <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span> -->
                                        </div>
                                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('auth.namePlaceholder')}}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  for="email" class="form-control-label">{{ __('auth.emailLabel') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <!-- <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span> -->
                                        </div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('auth.emailPlaceholder')}}" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <label for="password" class="form-control-label">{{ __('auth.passwordLabel') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <!-- <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span> -->
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{__('auth.passwordPlaceholder')}}" name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <label for="password-confirm" class="form-control-label">{{ __('auth.confirmPasswordLabel') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <!-- <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span> -->
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control" placeholder="{{__('auth.confirmPasswordPlaceholder')}}" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>


                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block  btn-auth" style="background-color:#4CAF50 !important;color:#fff;">
                                        {{ __('auth.register') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer px-md-5"><small>{{ __('auth.alreadyRegistered')}}</small>
                            <a href="{{ route('login') }}" class="small font-weight-bold" style="color:#4CAF50 !important;">
                                {{ __('auth.login') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection