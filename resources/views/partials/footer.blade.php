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

        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">{{ __('text.copyright') }}</li>
            <!-- <li class="list-group-item">
                <a href="{{ route('landing') }}">{{ __('text.terms') }}</a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('privacy') }}">{{ __('text.privacy') }}</a>
            </li> -->
        </ul>

        <a href="{{ route('support.create') }}" class="mr-2">
            {{ __('text.contactSupport') }}
        </a>

</div>