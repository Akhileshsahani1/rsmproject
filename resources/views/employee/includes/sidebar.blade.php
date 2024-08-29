{{-- <button type="button" class="btn btn-primary block hidden-lg" id="Showmenu">Show Menu </button>
<button type="button" class="btn btn-danger block hidden-lg" id="Hidemenu" style="display: none">Hide Menu</button> --}}
<div class="leftside-menu mob-side-menu">

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item">
                <a href="{{ route('employee.dashboard') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('employee.my-profile') }}" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> My Profile </span>
                </a>
            </li>

            <li
                class="side-nav-item {{ request()->is('open-jobs') || request()->is('open-jobs/*') || request()->is('closed-jobs') || request()->is('closed-jobs/*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#jobManagement" aria-expanded="false" aria-controls="jobManagement"
                    class="side-nav-link">
                    <i class="uil-briefcase"></i>
                    <span> Jobs </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('applied-jobs') || request()->is('applied-jobs/*') || request()->is('awarded-jobs') || request()->is('awarded-jobs/*') || request()->is('rejected-jobs') || request()->is('rejected-jobs/*') ? 'show' : '' }}"
                    id="jobManagement">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->is('applied-jobs') || request()->get('applied-jobs/*') == true ? 'menuitem-active' : '' }}">
                            <a href="{{ route('employee.applied-jobs') }}"
                                class="{{ request()->is('applied-jobs') || request()->get('applied-jobs/*') == true ? 'active' : '' }}">Applied
                                Jobs</a>
                        </li>

                        <li
                            class="{{ request()->is('awarded-jobs') || request()->get('awarded-jobs/*') == true ? 'menuitem-active' : '' }}">
                            <a href="{{ route('employee.awarded-jobs') }}"
                                class="{{ request()->is('employee.awarded-jobs') || request()->get('awarded-jobs/*') == true ? 'active' : '' }}">Awarded
                                Jobs</a>
                        </li>

                        <li
                            class="{{ request()->is('rejected-jobs') || request()->get('rejected-jobs/*') == true ? 'menuitem-active' : '' }}">
                            <a href="{{ route('employee.rejected-jobs') }}"
                                class="{{ request()->is('employee.rejected-jobs') || request()->get('rejected-jobs/*') == true ? 'active' : '' }}">Rejected
                                Jobs</a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('employee.chats.index') }}" class="side-nav-link">
                    <i class="uil-envelope"></i>
                    <span> Chats </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('employee.bookmarks') }}" class="side-nav-link">
                    <i class="uil-bookmark"></i>
                    <span> Bookmarks </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('employee.notifications') }}" class="side-nav-link">
                    <i class="uil-bell"></i>
                    <span> Notifications </span>
                </a>
            </li>


            <li class="side-nav-item">
                <a href="{{ route('employee.password.form') }}" class="side-nav-link">
                    <i class="uil-lock-alt"></i>
                    <span>Change Password </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('employee.logout') }}"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                    class="side-nav-link">
                    <i class="uil-exit"></i>
                    <span>Logout </span>
                </a>
            </li>
            <form id="logout-form" action="{{ route('employee.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>

    </div>
    <!-- Sidebar -left -->

</div>
