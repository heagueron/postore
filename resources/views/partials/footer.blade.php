@php
   $localeId = \App\Language::where('short_name', \App::getLocale())->first()->id;
@endphp

<div class="footer__banner p-4">

    {{-- LINKS --}}
    <div class="row my-2">

        <div class="col-sm-12 col-lg-2 mb-4 text-center"> </div>

        <div class="col-sm-12 col-lg-4 mb-3">
            <h5 class="footer__title">{{ strtoupper(__('text.rjByCats')) }}</h5>
            @foreach( \App\Category::where('language_id', $localeId)->get() as $category )
                @if( $category->tag == '' or $category->tag == 'all' or $category->tag == 'todos')
                    <a href="/" class="footer__link">{{ $category->name }}</a><br>
                @else 
                    <a href="{{route('remjobs.searchByTags', 'remote_' .$category->tag. '_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => $category->name ]) }}</a><br>    
                @endif
            @endforeach
        </div>

        <div class="col-sm-12 col-lg-4 mb-4">
            <h5 class="footer__title">{{ strtoupper(__('text.rjBySkills')) }}</h5>
                <a href="{{route('remjobs.searchByTags', 'remote_php_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Php' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_java_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Java' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_python_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Python' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_nodejs_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Node.js' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_sql_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'SQL' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_aws_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'AWS' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_linux_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Linux' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_wordpress_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Wordpress' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_fullstack_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Fullstack' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_javascript_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Javascript' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_writing_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'Writing' ]) }}</a><br>
                <a href="{{route('remjobs.searchByTags', 'remote_seo_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => 'SEO' ]) }}</a><br>
        </div>

        <div class="col-sm-12 col-lg-2 text-center">

            <div>
                <a href="{{ route('post_a_job') }}" type="button" role="button" class="sp_btn">
                    {{ __('text.postAJob') }}
                </a>
            </div>
            <div class="my-3 footer__link">
                <a href="mailto:info@remjob.io?subject=Advertise on Remjob IO&amp;body=I would like to advertise with you!%0A%0A%0A">{{ __('text.adWithUs') }}</a>
            </div>
            <div class="my-3 footer__link">
                <a href="{{ route('pages.api-docs') }}">{{ __('text.apiLinkLabel') }}</a>
            </div>
            
        </div>

    </div>

    {{--Social--}}

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

