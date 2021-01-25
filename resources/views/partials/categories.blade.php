

<section class="cat">

    <h5>{{ __('text.searchCatLabel')}}</h5>

    <div class="list-group list-group-flush">

        <a href="/" class="list-group-item list-group-item-action">
            {{ __('text.catRemoteJobs') }}
        </a>

        <a href="{{route('remjobs.searchByTags', 'remote_dev_jobs')}}" class="list-group-item list-group-item-action">
            {{ __('text.catSoftwareDevelopment') }}
        </a>

        <a href="{{route('remjobs.searchByTags', 'remote_customer_support_jobs')}}" class="list-group-item list-group-item-action">
            {{ __('text.catClientService') }}
        </a>

        <a href="{{route('remjobs.searchByTags', 'remote_marketing_jobs')}}" class="list-group-item list-group-item-action">
            {{ __('text.catMarketing') }}
        </a>

        <a href="{{route('remjobs.searchByTags', 'remote_design_jobs')}}" class="list-group-item list-group-item-action">
            {{ __('text.catDesign') }}
        </a>

        <a href="{{route('remjobs.searchByTags', 'remote_non_tech_jobs')}}" class="list-group-item list-group-item-action">
            {{ __('text.catNonTech') }}
        </a>
    </div>



</section>