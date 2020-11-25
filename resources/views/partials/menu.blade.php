<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    <div class="c-sidebar-brand d-md-down-none">
        <a href="{{ route('landing') }}">
            {{ __('Remote Jobs') }}
        </a>
    </div>

    <ul class="c-sidebar-nav ps ps--active-y">

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/home">

                Dashboard

            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.remjobs.index') }}">
                {{ __('Remote Jobs') }}
            </a>              
        </li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.edit-options') }}">
                {{ __('Admin Options') }}
            </a>              
        </li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>              
        </li>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
                               