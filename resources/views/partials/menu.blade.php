<div class="" id="sidebar">

    <div class="">
        <a href="{{ route('landing') }}">
            Remote Jobs
        </a>
    </div>

    <ul class="remjob-sidenav__list">

        <li class="remjob-sidenav__item">
            <a class="c-sidebar-nav-link" href="/home">

                Dashboard

            </a>
        </li>

        @if( Auth::user()->is_admin == 1 )

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.remjobs.index') }}">
                    Remote Jobs
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.companies.index') }}">
                    Companies
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                    Users
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.categories.index') }}">
                    Categories
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.plans.index') }}">
                    Plans
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.edit-options') }}">
                    Admin Options
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.dailies.index') }}">
                    Dailies
                </a>              
            </li>

            <li class="remjob-sidenav__item">
                <p class="mb-1" style="font-size:12px;color:white;">Hits and visits today:</p>
                <table class="table table-bordered" style="font-size:12px;color:white;">
                    <thead>
                        <tr>
                            <th>Land</th><th>Cat</th><th>Show</th><th>All</th><th>Uniq</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td title="visits to LANDING page">{{ \App\Visit::where('entry_route', 'landing')->whereDate('created_at', \Carbon\Carbon::today())->count() }}</td>
                            <td title="visits to CATEGORY/TAG page">{{ \App\Visit::where('entry_route', 'remjobs.searchByTags')->whereDate('created_at', \Carbon\Carbon::today())->count() }}</td>
                            <td title="visits to DETAIL page">{{ \App\Visit::where('entry_route', 'remjobs.show')->whereDate('created_at', \Carbon\Carbon::today())->count() }}</td>
                            <td title="all visits">{{ \App\Visit::whereDate('created_at', \Carbon\Carbon::today())->count() }}</td>
                            <td title="all unique visitors">{{ \App\Visit::whereDate('created_at', \Carbon\Carbon::today())->where('first_on_date', 1)->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </li>

            <li class="remjob-sidenav__item">
                <div class="c-sidebar-nav-link"> 
                    <span>AHR/AR:&nbsp;</span>
                    <span>{{ \App\Option::findOrFail(2)->value }}&nbsp;</span>
                    <span>/&nbsp;{{ \App\Remjob::where('active', 1)->count() }}</span>
                </div>                 
            </li>
            
        @endif

        <li class="remjob-sidenav__item">
            <a class="c-sidebar-nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>              
        </li>

    </ul>

    


</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
                               