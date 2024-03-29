@extends('layouts.app')

@section('title', 'Publish the Job')

@section('content')

    @include('partials.nav')

    <div class="container d-flex flex-column mb-2" style="margin-top:7rem;">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-5 py-6 py-md-0">
                    <div class="card shadow zindex-100 mb-0">
                        <div class="card-body px-md-5 py-5">

                            <div class="mb-5 text-center">
                                <h6 class="h3">{{ __('Publish your Remote Job') }}</h6>
                                <p class="text-muted mb-0">{{ $remjob->position }}</p>
                            </div>

                            <span class="clearfix"></span>
                            <form method="POST" action="{{ route( 'checkout.publish', $remjob->id ) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group text-center">
                                    <label  for="license" class="form-control-label">{{ __('Payment code (License)') }}</label>
                                    <div class="input-group">
                                        <input id="license" type="text" name="license" value="{{ $gumroadLicense }}"
                                            class="form-control @error('license') is-invalid @enderror gr-license text-center" 
                                            style="font-size:0.8rem !important;"
                                            required autofocus>
                                        <span class="rp-group__info">
                                            {{__( '( If this is blank, you can also grab your payment code or license for your payment in the email sent to you by Gumroad )' ) }}
                                        </span>
                                        @error('license')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-block btn-success">
                                        {{ __('PUBLISH THE REMOTE JOB! ') }}
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection