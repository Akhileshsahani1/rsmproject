<div class="leftside-menu" style="
  background: #ffffff;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;">

    <!-- LOGO -->
    <a href="{{ route('admin.dashboard') }}" class="logo text-center logo-light">
        <span class="logo-lg" style=
        "background:#fff;">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="">
        </span>
        <span class="logo-sm" style=
        "background:#fff;">
            <img src="{{ asset('assets/images/logo-sm.svg') }}" alt="">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{ route('admin.dashboard') }}" class="logo text-center logo-dark">
        <span class="logo-lg" style=
        "background:#fff;">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="">
        </span>
        <span class="logo-sm" style=
        "background:#fff;">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                    <i class="dripicons-view-thumb"></i>
                    <span> Dashboard </span>
                </a>
            </li>
             <li
                class="side-nav-item {{ request()->is('admin/jobs') || request()->is('admin/jobs/*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#jobManagement" aria-expanded="false"
                    aria-controls="jobManagement" class="side-nav-link">
                    <i class="uil-briefcase"></i>
                    <span> Jobs </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('admin/jobs') || request()->is('admin/jobs/*') ? 'show' : '' }}"
                    id="jobManagement">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->is('admin/jobs') && request()->get('status') == 'approved' || request()->is('admin/jobs/*') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('admin.jobs.index', ['status'=>'approved']) }}"
                                class="{{ request()->is('admin/jobs') && request()->get('status') == 'approved' || request()->is('admin/jobs/*') ? 'active' : '' }}">Approved
                                Jobs</a>
                        </li>
                        <li
                            class="{{ request()->is('admin/jobs') && request()->get('status') == 'pending' ? 'menuitem-active' : '' }}">
                            <a href="{{ route('admin.jobs.index', ['status' => 'pending']) }}"
                                class="{{ request()->is('admin/jobs') && request()->get('status') == 'pending' ? 'active' : '' }}">Pending
                                Jobs</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li
                class="side-nav-item {{ request()->is('admin/employers') || request()->is('admin/employers/*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#customerManagement" aria-expanded="false"
                    aria-controls="customerManagement" class="side-nav-link">
                    <i class="fa fa-users"></i>
                    <span> Employers </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('admin/employers') || request()->is('admin/employers/*') ? 'show' : '' }}"
                    id="customerManagement">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->is('admin/employers') && request()->get('status') == true ? 'menuitem-active' : '' }}">
                            <a href="{{ route('admin.employers.index', ['status' => true]) }}"
                                class="{{ request()->is('admin/employers') && request()->get('status') == true ? 'active' : '' }}">Approved
                                Employers</a>
                        </li>
                        <li
                            class="{{ request()->is('admin/employers') && request()->get('status') == false ? 'menuitem-active' : '' }}">
                            <a href="{{ route('admin.employers.index', ['status' => false]) }}"
                                class="{{ request()->is('admin/employers') && request()->get('status') == false ? 'active' : '' }}">Pending
                                Employers</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item {{ request()->is('admin/employees') || request()->is('admin/employees/*') ? 'menuitem-active' : '' }}">
                <a href="{{ route('admin.employees.index') }}" class="side-nav-link">                   
                    <i class="fa fa-users"></i>
                    <span> Employees </span>
                </a>
            </li>           

       

        @if(Auth::user()->role == 'Superadmin')
            <li
                class="side-nav-item {{ request()->is('admin/user-management') || request()->is('admin/user-management/*') ? 'menuitem-active' : '' }}">
                <a data-bs-toggle="collapse" href="#userManagement" aria-expanded="false" aria-controls="userManagement"
                    class="side-nav-link">
                    <i class="dripicons-user"></i>
                    <span> User management </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->is('admin/user-management') || request()->is('admin/user-management/*') ? 'show' : '' }}"
                    id="userManagement">
                    <ul class="side-nav-second-level">
                        <li
                            class="{{ request()->is('admin/user-management/admins') || request()->is('admin/user-management/admins/*') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('admin.admins.index') }}"
                                class="{{ request()->is('admin/user-management/admins') || request()->is('admin/user-management/admins/*') ? 'active' : '' }}">Admins</a>
                        </li>
                        <li
                            class="{{ request()->is('admin/user-management/superadmins') || request()->is('admin/user-management/superadmins/*') ? 'menuitem-active' : '' }}">
                            <a href="{{ route('admin.superadmins.index') }}"
                                class="{{ request()->is('admin/user-management/superadmins') || request()->is('admin/user-management/superadmins/*') ? 'menuitem-active' : '' }}">Superadmins</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="side-nav-item {{ request()->is('admin/notifications') || request()->is('admin/notifications/*') ? 'menuitem-active' : '' }}">
            <a href="{{ route('admin.notifications.index') }}" class="side-nav-link">
                <i class="dripicons-bell"></i>
                <span> Action Log </span>
            </a>
        </li>
        <li class="side-nav-item {{ request()->is('admin/pages') || request()->is('admin/pages/*') ? 'menuitem-active' : '' }}">
            <a href="{{ route('admin.pages.index') }}" class="side-nav-link">
                <i class="dripicons-star"></i>
                <span> Information Pages </span>
            </a>
        </li>
         <li class="side-nav-item {{ request()->is('admin/skills') || request()->is('admin/skills/*') ? 'menuitem-active' : '' }}">
            <a href="{{ route('admin.skills.index') }}" class="side-nav-link">
                <i class="dripicons-brush"></i>
                <span> Skills </span>
            </a>
        </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSettings" aria-expanded="false"
                    aria-controls="sidebarSettings" class="side-nav-link">
                    <i class="dripicons-gear"></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSettings">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.company-details.form') }}">Company Details</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.password.form') }}">Change Password</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.my-account.edit', Auth::guard('administrator')->id()) }}">My
                                Account</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

</div>
