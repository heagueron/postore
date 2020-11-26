<header class="hero" style="background-image:url( {{ asset('storage/images/rob.jpg') }} )">

    @include('partials.nav')
    

    <div class="search-container mt-5">

            <div class="autocomplete" style="width:300px;">
                <input id="myInput" class="rp-search-input" type="text" name="search-term" placeholder="Start typing to find jobs ...">
            </div>

            <a  alt="Search jobs by tag" id="hero-search-link"
                href="{{  route( 'remjobs.searchByTags', 'remote-dev-jobs' )  }}"  
                class="post-button">{{ __('text.searchJob') }}
            </a>

    </div>

</header>

