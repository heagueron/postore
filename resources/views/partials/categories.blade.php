

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
            <a href="{{route('remjobs.searchByTags', 'remote-dev-jobs')}}" class="categories__link">
                💻
                <br><br>
                {{ __('text.catSoftwareDevelopment') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote-customer-support-jobs')}}" class="categories__link">
                📞
                <br><br>
                {{ __('text.catClientService') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote-marketing-jobs')}}" class="categories__link">
                
                📈
                <br><br>
                {{ __('text.catMarketing') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote-design-jobs')}}" class="categories__link">
                🖌️
                <br><br>
                {{ __('text.catDesign') }}
            </a>
        </li>

        <li class="cat__list__item">
            <a href="{{route('remjobs.searchByTags', 'remote-non-tech-jobs')}}" class="categories__link">
                💡
                <br><br>
                {{ __('text.catNonTech') }}
            </a>
        </li>

    </ul>


</section>