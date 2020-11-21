<section class="categories">

            <div>
                <a href="/" aria-current="page" class="active categories__link" alt="Todos los trabajos" style="text-align: center;">
                    👔
                    <br><br>
                    {{ __('Remote Jobs') }}                    
                </a>
            </div>

            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-dev-jobs')}}" class="categories__link" alt="Desarrollo de software" style="text-align: center;">
                    💻
                    <br><br>
                    {{ __('Software Development') }}
                </a>
            </div>
            
            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-customer-support-jobs')}}" class="categories__link" alt="Atención al cliente" style="text-align: center;">
                    📞
                    <br><br>
                    {{ __('Client Service') }}
                </a>
            </div>
            
            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-marketing-jobs')}}" class="categories__link" alt="Marketing" style="text-align: center;">
            
                    📈
                    <br><br>
                    {{ __('Marketing') }}
                </a>
            </div>
            
            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-design-jobs')}}" class="categories__link" alt="Diseño" style="text-align: center;">
                    🖌️
                    <br><br>
                    {{ __('Design') }}
                </a>
            </div>

            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-non-tech-jobs')}}" class="categories__link" alt="Otros" style="text-align: center;">
                    💡
                    <br><br>
                    {{ __('Others') }}
                </a>
            </div>
</section>