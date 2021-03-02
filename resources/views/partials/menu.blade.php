<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    <div class="c-sidebar-brand d-md-down-none">
        <a href="{{ route('landing') }}">
            Remote Jobs
        </a>
    </div>

    <ul class="c-sidebar-nav ps ps--active-y">

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/home">

                Dashboard

            </a>
        </li>

        @if( Auth::user()->is_admin == 1 )

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.remjobs.index') }}">
                    Remote Jobs
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.companies.index') }}">
                    Companies
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                    Users
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.categories.index') }}">
                    Categories
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.plans.index') }}">
                    Plans
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.edit-options') }}">
                    Admin Options
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.dailies.index') }}">
                    Dailies
                </a>              
            </li>

            <li class="c-sidebar-nav-item">
                <span class="c-sidebar-nav-link">Landing Hits: {{ \App\Visit::where('entry_route', 'landing')->whereDate('created_at', \Carbon\Carbon::today())->count() }}</span>             
            </li>
            <li class="c-sidebar-nav-item">
                <span class="c-sidebar-nav-link">Detail Hits: {{ \App\Visit::where('entry_route', 'remjobs.show')->whereDate('created_at', \Carbon\Carbon::today())->count() }}</span>             
            </li>
            <li class="c-sidebar-nav-item">
                <span class="c-sidebar-nav-link">Cat/Tag Hits: {{ \App\Visit::where('entry_route', 'remjobs.searchByTags')->whereDate('created_at', \Carbon\Carbon::today())->count() }}</span>             
            </li>
            <li class="c-sidebar-nav-item">
                <span class="c-sidebar-nav-link">All Hits: {{ \App\Visit::whereDate('created_at', \Carbon\Carbon::today())->count() }}</span>             
            </li>
            <li class="c-sidebar-nav-item">
                <span class="c-sidebar-nav-link">Unique Hits: {{ \App\Visit::whereDate('created_at', \Carbon\Carbon::today())->where('first_on_date', 1)->count() }}</span>             
            </li>

            <li class="c-sidebar-nav-item">
                <span class="c-sidebar-nav-link">Active Jobs: {{ \App\Remjob::where('active', 1)->count() }}</span>             
            </li>
            
        @endif

        <li class="c-sidebar-nav-item">
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
                               