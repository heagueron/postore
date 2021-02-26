@php
   $localeId = \App\Language::where('short_name', \App::getLocale())->first()->id;
@endphp

<div class="footer__banner p-4">

    {{-- LINKS --}}
    <div class="row my-2">

        <div class="col-sm-12 col-lg-2 mb-4 text-center"> </div>

        <!-- <div class="col-sm-12 col-lg-2 mb-4 text-center">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/remjob3.png') }}" alt="Remjob" class="w-15" >
            </a>
        </div> -->

        <div class="col-sm-12 col-lg-4 mb-3">
            <h5 class="footer__title">{{ strtoupper('Remote Jobs by Categories') }}</h5>
            @foreach( \App\Category::where('language_id', $localeId)->get() as $category )
                @if( $category->tag == '' or $category->tag == 'all' or $category->tag == 'todos')
                    <a href="/" class="footer__link">{{ $category->name }}</a><br>
                @else 
                    <a href="{{route('remjobs.searchByTags', 'remote_' .$category->tag. '_jobs')}}" class="footer__link">{{ __('text.footCategory', ['categoryTitle' => $category->name ]) }}</a><br>    
                @endif
            @endforeach
        </div>

        <div class="col-sm-12 col-lg-4 mb-5">
            <h5 class="footer__title">{{ strtoupper('Remote Jobs by Skills') }}</h5>
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