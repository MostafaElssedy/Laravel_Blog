<div class="sidebar-menu">
    <ul id="accordion-menu">
        <li>
            <a href="{{route('admin.dashboard')}}" class="dropdown-toggle no-arrow {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <span class="micon bi bi-house"></span><span class="mtext">Home</span>
            </a>
        </li>
        @if(auth()->user()->type->value === 'superAdmin')
        <li>
            <a href="{{route('admin.categories')}}" class="dropdown-toggle no-arrow {{ Route::is('admin.categories') ? 'active' : '' }}">
                <span class="micon bi bi-view-list"></span><span class="mtext">Categories</span>
            </a>
        </li>
        <li>
            <a href="{{route('admin.users')}}" class="dropdown-toggle no-arrow {{ Route::is('admin.users') ? 'active' : '' }}">
                <span class="micon bi bi-people"></span><span class="mtext">Users &amp; Authors</span>
            </a>
        </li>
        @endif
        <li class="dropdown">
            <a href="javascript:;" class="dropdown-toggle {{ Route::is('admin.posts.*') ? 'active' : '' }}">
                <span class="micon bi bi-newspaper"></span><span class="mtext">Posts</span>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('admin.posts.all-posts') }}" class="{{ Route::is('admin.posts.all-posts') ? 'active' : '' }}">All Posts</a></li>
                <li><a href="{{ route('admin.posts.add-post') }}" class="{{ Route::is('admin.posts.add-post') ? 'active' : '' }}">Add New</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('home') }}" target="_blank" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-globe"></span><span class="mtext">Visit Website</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <div class="sidebar-small-cap">SETTINGS</div>
        </li>
        <li>
            <a href="{{ route('admin.profile') }}" class="dropdown-toggle no-arrow {{ Route::is('admin.profile') ? 'active' : '' }}">
                <span class="micon bi bi-person"></span><span class="mtext">Profile</span>
            </a>
        </li>
        @if(auth()->user()->type->value === 'superAdmin')
        <li>
            <a href="{{ route('admin.settings') }}" class="dropdown-toggle no-arrow {{ Route::is('admin.settings') ? 'active' : '' }}">
                <span class="micon bi bi-gear"></span><span class="mtext">General</span>
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="dropdown-toggle no-arrow">
                <span class="micon bi bi-box-arrow-right"></span><span class="mtext">Log Out</span>
            </a>
            <form id="sidebar-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
