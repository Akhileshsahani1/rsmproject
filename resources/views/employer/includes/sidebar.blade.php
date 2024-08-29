{{-- <button type="button" class="btn btn-primary block hidden-lg" id="Showmenu">Show Menu </button>
<button type="button" class="btn btn-danger block hidden-lg" id="Hidemenu" style="display: none">Hide Menu</button> --}}
<div class="leftside-menu mob-side-menu">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item">
                <a href="{{ route('home') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('my-profile') }}" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> My Profile </span>
                </a>
            </li>

            <li class="side-nav-item {{ request()->is('open-jobs') || request()->is('open-jobs/*') || request()->is('closed-jobs') || request()->is('closed-jobs/*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#jobManagement" aria-expanded="false"
                    aria-controls="jobManagement" class="side-nav-link">
                    <i class="uil-briefcase"></i>
                    <span> Jobs </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('open-jobs') || request()->is('open-jobs/*') || request()->is('job/applicants') || request()->is('job/applicants/*') ? 'show' : '' }}"
                    id="jobManagement">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->is('open-jobs') || request()->get('open-jobs/*') || request()->is('job/applicants') || request()->is('job/applicants/*') == true  ? 'menuitem-active' : '' }}">
                            <a href="{{ route('open-jobs') }}"
                                class="{{ request()->is('open-jobs') || request()->get('open-jobs/*') || request()->is('job/applicants') || request()->is('job/applicants/*') == true ? 'active' : '' }}">Open
                                Jobs</a>
                        </li>
                        <li
                            class="{{ request()->is('closed-jobs') && request()->get('closed-jobs/*') == false ? 'menuitem-active' : '' }}">
                            <a href="{{ route('closed-jobs') }}"
                                class="{{ request()->is('closed-jobs') && request()->get('closed-jobs/*') == false ? 'active' : '' }}">Closed
                                Jobs</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('chats.index') }}" class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span> Chats </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('bookmarks') }}" class="side-nav-link">
                    <i class="uil-bookmark"></i>
                    <span> Bookmarks </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('notifications') }}" class="side-nav-link">
                    <i class="uil-bell"></i>
                    <span> Notifications </span>
                </a>
            </li>


            <li class="side-nav-item">
                <a href="{{ route('password.form') }}" class="side-nav-link">
                    <i class="uil-lock-alt"></i>
                    <span>Change Password </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="side-nav-link">
                    <i class="uil-exit"></i>
                    <span>Logout </span>
                </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>

    </div>
    <!-- Sidebar -left -->

</div>
