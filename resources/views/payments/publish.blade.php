@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')

    @include('partials.nav')

    <div class="container d-flex flex-column" style="margin-top:7rem;">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 col-lg-5 col-xl-5 py-6 py-md-0">
                    <div class="card shadow zindex-100 mb-0">
                        <div class="card-body px-md-5 py-5">

                            <div class="mb-5">
                                <h6 class="h3">{{ __('Publish your Remote Job') }}</h6>
                                <p class="text-muted mb-0">{{ $remjob->position }}</p>
                            </div>

                            <span class="clearfix"></span>
                            <form method="POST" action="{{ route( 'checkout.publish', $remjob->id ) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label  for="license" class="form-control-label">{{ __('Payment code (License)') }}</label>
                                    <div class="input-group">
                                        <input id="license" type="text" class="form-control @error('license') is-invalid @enderror" name="license" value="{{ $gumroadLicense }}" required autofocus>
                                        <span class="rp-group__info">
                                            {{__( '( If this is blank, you can also check your payment code or license for your payment in the email sent to you by Gumroad )' ) }}
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