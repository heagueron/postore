@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

    @include('partials.nav')

    <div class="container mb-2" style="margin-top:7rem;">

        <div class="row">
            
            <div class="col-lg-3 col-sm-12">
                @include('partials.left-menu')
            </div>

            <div class="col-lg-8 col-sm-12 ml-3">

                <h2>{{__('faq.title')}}</h2>

                <h3 class="footer__post mb-3">{{__('faq.forApplicants')}}</h3>

                <h5><strong>{{__('faq.whatsRemjob-Q')}}</strong></h5>
                <p>{{__('faq.whatsRemjob-A')}}</p>

                <h5><strong>{{__('faq.whoFor-Q')}}</strong></h5>
                <p>{{__('faq.whoFor-A')}}</p>

                <h5><strong>{{__('faq.isFullRemote-Q')}}</strong></h5>
                <p>{{__('faq.isFullRemote-A')}}</p>

                <h5><strong>{{__('faq.areJobsCredible-Q')}}</strong></h5>
                <p>{{__('faq.areJobsCredible-A')}}</p>


                <h3 class="footer__post mb-3">{{__('faq.forEmployers')}}</h3>

                <h5><strong>{{__('faq.whyRemjob-Q')}}</strong></h5>
                <p>{{__('faq.whyRemjob-A')}}</p>

                <h5><strong>{{__('faq.howMuch-Q')}}</strong></h5>
                <p>{{ __('faq.howMuch-A', ['plan2' => \App\Option::find(1)->value, 'duration' => \App\Option::find(1)->value]) }}</p>

                <h5><strong>{{__('faq.whatInfo-Q')}}</strong></h5>
                <p>{{__('faq.whatInfo-A')}}</p>
                
                <!-- <h5><strong>{{__('faq.canEditJob-Q')}}</strong></h5>
                <p>{{__('faq.canEditJob-A')}}</p> -->

            </div>
        </div>
        
    </div>

@endsection

                    

