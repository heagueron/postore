<header class="hero" style="background-image:url( {{ asset('storage/images/rob.jpg') }} )">

    @include('partials.nav')
    

    <div class="search-container mt-5">
        <!-- <form autocomplete="off" action=""> -->
            <div class="autocomplete" style="width:300px;">
                <input id="myInput" class="rp-search-input" type="text" name="search-term" placeholder="Start typing to find jobs ...">
            </div>
            <!-- <input type="submit" value="Send"> -->
            <a  alt="Search jobs by tag" id="hero-search-link"
                href="{{  route( 'remjobs.searchByTags', 'remote-dev-jobs' )  }}"  
                class="post-button">{{ __('Send') }}
            </a>
        <!-- </form> -->
    </div>

    <!-- <div class="search-container">
        <input type="text" placeholder="Find a job..." id="search-input">
        <button type="button" id="search-button"><i class="fa fa-search"></i></button>
    </div> -->

</header>

