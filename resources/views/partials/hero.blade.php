
@include('partials.nav')

<header class="hero" style="background-image:url( {{ asset('images/green-bg.png') }} )">
<!-- <header class="hero"> -->

    <div class="hero__title mt-5 text-center">
        <h1>REMJOB</h1>
        <h4>{{__('text.heroTitleTip')}}</h4>
    </div>

    
    <div class="search-container mt-3">

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

