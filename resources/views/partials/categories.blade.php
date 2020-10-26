<section class="categories">

            <div>
                <a href="/" aria-current="page" class="nav-link nuxt-link-exact-active nuxt-link-active active" alt="Todos los trabajos" style="text-align: center;">
                    👔
                    <br>
                    {{ __('Remote Jobs') }}                    
                </a>
            </div>

            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-dev-jobs')}}" class="nav-link" alt="Desarrollo de software" style="text-align: center;">
                    💻
                    <br>
                    {{ __('Software Developers') }}
                </a>
            </div>
            
            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-customer-support-jobs')}}" class="nav-link" alt="Atención al cliente" style="text-align: center;">
                    📞
                    <br>
                    {{ __('Client Service') }}
                </a>
            </div>
            
            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-marketing-jobs')}}" class="nav-link" alt="Marketing" style="text-align: center;">
            
                    📈
                    <br>
                    {{ __('Marketing') }}
                </a>
            </div>
            
            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-design-jobs')}}" class="nav-link" alt="Diseño" style="text-align: center;">
                    🖌️
                    <br>
                    {{ __('Design') }}
                </a>
            </div>

            <div>
                <a href="{{route('remjobs.searchByTags', 'remote-non-tech-jobs')}}" class="nav-link" alt="Otros" style="text-align: center;">
                    💡
                    <br>
                    {{ __('Others') }}
                </a>
            </div>
</section>