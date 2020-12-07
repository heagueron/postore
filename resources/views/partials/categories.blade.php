

<section class="cat">

    <ul class="cat__list" id="cat-list">

        <li class="cat__list__item">
            <a href="/" aria-current="page" class="active categories__link">
                👔
                <br><br>
                {{ __('text.catRemoteJobs') }}                    
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote_dev_jobs')}}" class="categories__link">
                💻
                <br><br>
                {{ __('text.catSoftwareDevelopment') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote_customer_support_jobs')}}" class="categories__link">
                📞
                <br><br>
                {{ __('text.catClientService') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote_marketing_jobs')}}" class="categories__link">
                
                📈
                <br><br>
                {{ __('text.catMarketing') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote_design_jobs')}}" class="categories__link">
                🖌️
                <br><br>
                {{ __('text.catDesign') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote_non_tech_jobs')}}" class="categories__link">
                💡
                <br><br>
                {{ __('text.catNonTech') }}
            </a>
        </li>

    </ul>


</section>