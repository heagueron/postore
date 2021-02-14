<div class="footer__banner p-4">
    <div class="row">
        <div class="col-sm-9 col-lg-10">
            <h1 style="font-weight:bold;">REMJOB</h1>
        </div>
        <div class="col-sm-3 col-lg-2 mt-3">
            <a class="footer__post" href="{{ route('post_a_job') }}">{{ __('text.postAJob') }}</a>
        </div>
    </div>
</div>

<div class="footer__copyright d-flex justify-content-between align-items-baseline align-content-center">

    <div class="container">

        <div class="d-flex justify-content-center">
            <div class="p-2">
                <a href="https://twitter.com/jmservca/" class="mr-2" title="Twitter">
                    <i class="fab fa-twitter" style="font-size:20px;color:#1DA1F2"></i>
                </a>
            </div>

            <div class="p-2">
                <a href="{{ route('pages.faq') }}" class="mr-2" title="{{ __('text.faq') }}">
                    {{ __('text.faq') }}
                </a>
            </div>
            <div class="p-2">
                <a href="{{ route('support.create') }}" class="mr-2" title="{{ __('text.contactSupport') }}">
                    {{ __('text.contactSupport') }}
                </a>
            </div>
        </div>
</div>