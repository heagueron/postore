@extends('layouts.app')

@section('title', 'Sponsorship')

@section('content')

    <div class="sp_page sp_center">
       
        @include('partials.nav')

        <section class="sp_intro mt-4">

            <div class="sp_center">
                <div class="mt-5 sp_intro__img_container">
                    <img src="{{ asset('images/group.jpg') }}" alt="sponsors" class="sp_intro__topImg">
                </div>
                
                <h1 class="sp_intro__title mt-4">Sponsorship</h1>

            </div>
            
            <p class="sp_intro__description mt-3 mb-3 mx-3">
                Connect with thousands of professional remote workers from around the world who visit Remjob IO
                on a daily base checking curated hand-picked remote job posts and who receive our newsletter. 
            </p>

            <p class="sp_intro__description mt-3 mb-3 mx-3">
                When you book a slot here, you promote your company with our <span class="sp_intro__highlight">Remjob Ads</span> (main landing page and job detail page),
                our daily <span class="sp_intro__highlight">Remjob Newsletter</span> and you will even get 3 promotional tweets
                in our main Twitter account, <a href="https://twitter.com/jmservca">@jmservca</a>.
                
            </p>
            <p class="sp_intro__description mb-3 mx-3">
                You can book a week-long block to promote your company.
            </p>

            <p class="sp_intro__description mb-3 mx-3">
                See details below.
            </p>

            <div class="sp_center mt-5 mb-3">
                <a href="mailto:info@remjob.io?subject=Advertise on Remjob IO&amp;body=I would like to advertise with you!%0A%0A%0A"
                    type="button" role="button" class="sp_btn">
                    Book your slot
                </a>
            </div>

        </section>


        <div class="sp_wrapper sp_center">

            <section class="sp_elements">

                <div class="sp_center">              
                    <h1 class="sp_elements__title my-4">Ad elements</h1>
                </div>

                <ul class="sp_list">
                    
                    <li class="my-4">
                        <strong>Landing page:</strong> on top row (also visible on all category and tag page)
                        <div class="mt-4">
                            <img src="{{ asset('images/ad_on_landing.png') }}" alt="" class="sp_elements__adLanding">
                        </div>
                    </li>

                    <li class="my-4">
                        <strong>Job detail page:</strong> just below company card.
                        <div class="mt-4">
                            <img src="{{ asset('images/ad_on_show.png') }}" alt="" class="sp_elements__adShow">
                        </div>
                    </li>

                    <li class="my-4">
                        <strong>On Remjob Newsletter:</strong> just above the jobs list.<br>
                        <small>[A top image, a title (max. 10 words), a description (max. 50 words) ]</small>
                        <div class="mt-4">
                            <img src="{{ asset('images/ad_on_news.png') }}" alt="" class="sp_elements__adNews">
                        </div>
                    </li>

                    <li class="my-4">
                        <strong>Social share:</strong> 3 promotional tweets having your copy and links in our Twitter account @jmservca.
                    </li>

                </ul>

                <div class="sp_center mt-5 mb-3">
                    <a href="mailto:info@remjob.io?subject=Advertise on Remjob IO&amp;body=I would like to advertise with you!%0A%0A%0A"
                        type="button" role="button" class="sp_btn">
                        Book your slot
                    </a>
                </div>

            </section>

            <div class="sp_separator"><br></div>

            <section class="sp_elements">

                <div class="sp_center">
                    <h1 class="sp_elements__title my-4">Details</h1>
                </div>

                <ul class="sp_list">
                    <li class="my-4">
                        We accept only one paid sponsor for a period of one week.   
                    </li>
                    <li class="my-4">
                        Once we receive the payment, we will need:
                        <ul class="sp_sublist mt-2">
                            <li>images for ads on landing and detail</li>
                            <li>image, title and description for ad on newsletter</li>
                            <li>text for the promotional tweets</li>
                        </ul>
                    </li>
                    <li class="my-4">
                        We the review and proof-read images and texts and suggestions may arise to ensure deliverability.
                    </li>

                    <li class="my-4">
                        Only one sponsor per week. Reserve your slot with anticipation.
                    </li>
                </ul>

                <div class="sp_center">
                    <h1 class="sp_elements__title my-4">FAQ</h1>
                </div>

                <ul class="sp_list">
                    <li class="my-4">     
                        <p>Which types of products/services sponsorships are accepted?</p>
                        <p>All related to remote work.</p>
                    </li>
                    <li class="my-4">     
                        <p>Which kind of payments are accepted?</p>
                        <p>Paypal or bank transfer.</p>
                    </li>
                    <li class="my-4">     
                        <p>Can I cancel my booked slot?</p>
                        <p>Yes, you can cancel your booked slot before it is published. Once your ads are published and sent to our audience, no refund can be made.</p>
                    </li>
                    

                </ul>

                <div class="sp_center">
                    <h1 class="sp_elements__title my-4">Has additional questions?</h1>

                    <a href="mailto:info@remjob.io?subject=Additional questions&amp;body=Hello. I need additional information about your ad schema ... %0A%0A%0A" style="color:#367c39; text-decoration:underline;">
                        Send an email to us.
                    </a>
                </div>



                <div class="sp_center mt-5 mb-3">
                    <a href="mailto:info@remjob.io?subject=Advertise on Remjob IO&amp;body=I would like to advertise with you!%0A%0A%0A"
                        type="button" role="button" class="sp_btn">
                        Book your slot
                    </a>
                </div>

            </section>

        </div> <!-- sp_wrapper -->
        

    </div> <!-- sp_page -->


@endsection