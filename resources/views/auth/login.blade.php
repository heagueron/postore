@extends('layouts.auth')

@section('content')
<div class="container d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100">
                <div class="col-md-6 col-lg-5 col-xl-5 py-6 py-md-0">
                    <div class="card shadow zindex-100 mb-0">
                        <div class="card-body px-md-5 py-5">
                            <div class="mb-5 text-center">
                                <img src="{{ asset('images/remjob2c.svg') }}" alt="remjob" width="80" height="auto"  >
                            </div>
                            <span class="clearfix"></span>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label  for="email" class="form-control-label">{{ __('auth.emailLabel') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <!-- <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span> -->
                                        </div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{__('auth.emailPlaceholder')}}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-0">
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


                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-auth" style="background-color:#4CAF50 !important;color:#fff;">
                                        {{ __('auth.login') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}" style="color:#4CAF50 !important;">
                                            {{ __('auth.forgotPassword') }}
                                        </a>
                                    @endif
                                </div>

                            </form>
                        </div>
                        <div class="card-footer px-md-5"><small>{{ __('auth.notRegistered')}}</small>
                            <a href="{{ route('register') }}" class="small font-weight-bold" style="color:#4CAF50 !important;">
                                {{ __('auth.createAccount') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
