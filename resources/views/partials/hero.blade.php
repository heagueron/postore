
@include('partials.nav')

<header class="hero" style="background-image:url( {{ asset('images/birds.jpg') }} )" id="rj-hero">
<!-- <header class="hero"> -->

    <div class="hero__title mt-5 text-center">
        <h1>REMJOB</h1>
        <h3 class="hero__tip">{{__('text.heroTitleTip')}}</h3>
    </div>

    
    <div class="search-container">

            <div class="autocomplete" style="width:300px;">
                <input id="myInput" class="rp-search-input" type="text" name="search-term" 
                    placeholder="{{ __('text.startTyping') }}">
            </div>

            <a  href="{{  route( 'remjobs.searchByTags', 'remote-dev-jobs' )  }}"  
                class="post-button" id="hero-search-link">
                {{ __('text.searchJob') }}
            </a>

    </div>

</header>

