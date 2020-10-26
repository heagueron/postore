<header class="hero" style="background-image:url( {{ asset('storage/images/rob.jpg') }} )">

    <div class="nav logo-button-container">
        <div style="flex: 1" class="nav__logo">
            <a href="{{ route('landing') }}" aria-current="page" alt="Remote Position">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Remote Positions">
            </a>
        </div>
        <div class="nav__actions">
            <a href="{{ route('post-a-job') }}" alt="Post a job" class="post-button">{{ __('Post a Job') }}</a>
        </div>
        
    </div>

    <div class="search-container">
        <form autocomplete="off" action="/action_page.php">
            <div class="autocomplete" style="width:300px;">
                <input id="myInput" type="text" name="search-term" placeholder="Start typing to find jobs ...">
            </div>
            <input type="submit" value="Send">
        </form>
    </div>

    <!-- <div class="search-container">
        <input type="text" placeholder="Find a job..." id="search-input">
        <button type="button" id="search-button"><i class="fa fa-search"></i></button>
    </div> -->

</header>

