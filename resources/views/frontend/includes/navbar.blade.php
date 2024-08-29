<nav class="navbar navbar-expand-lg py-lg-2 navbar-dark destop-view">
    <div class="container">

        <!-- logo -->
        <a href="{{ url('/') }}" class="navbar-brand me-lg-5">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="user-image" height="40px" >
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>

        <!-- menus -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <!-- left menu -->
            <ul class="navbar-nav me-auto mhome">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ Auth::guard('web')->check() ? url('/home') : url('/') }}">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('page', 'about-us') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a></li>
                @if (Auth::guard('web')->check())
                <li class="nav-item">
                    <a class="nav-link btn btn-primary" href="{{ route('post-job') }}">Post Job</a>
                </li>
                @endif
            </ul>

            <!-- right menu -->
            <ul class="navbar-nav ms-auto m_menu">
                @if (Auth::guard('employee')->check() || Auth::guard('web')->check())

                @if (Auth::guard('employee')->check())
                <li class="nav-item "><a href="{{ route('employee.chats.index') }}" class="nav-link"> <i class="uil-envelope chat-icon"></i></a><div class="count nc" id="employee-chat-count">0</div></li>
                <li class="dropdown notification-list nav-item ">
                    <a class="nav-link bellread" id="employee" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>
                    </a>
                    <div class="count nc">{{count(Helper::headEmployeeNotifications())}}</div>
                    <div class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown" data-bs-popper="none">
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                Notification
                            </h5>
                        </div>
                         <div>
                              @if( ( count(Helper::headEmployeeNotifications()) ) > 0 )
                                                @foreach( Helper::headEmployeeNotifications() as $n)

                                                <!-- item-->

                                                @if( $n->type == 'App\Notifications\Employee\JobStatus')
                                                <p class="text-center bg-grey">
                                                    Applied <a href="{{ route('frontend.job.show', $n->data['job_id']) }}"> job </a> has been {{ $n->data['status'] }}
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employee\DocRequest')
                                                <p class="text-center bg-grey">
                                                    Document request is received for <a href="{{ route('frontend.job.show', $n->data['job_id']) }}"> job </a>
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employee\NewJobPostingNotification')
                                                <p class="text-center bg-grey">
                                                    New <a href="{{ route('frontend.job.show', $n->data['job_id']) }}"> job </a> based on your skill.
                                                </p>
                                                @endif

                                                @endforeach

                                                @else
                                                <p class="text-center nonew">No new notification found.</p>
                                                @endif
                         </div>
                        <a href="{{ route('employee.notifications') }}" class="dropdown-item text-center  notify-item notify-all">
                            View All
                        </a>
                    </div>
                </li>
                <li class="dropdown ">
                    <a class="nav-link dropdown-toggle web-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        @isset(Auth::guard('employee')->user()->avatar)
                        <span class="account-user-avatar">
                            <img src="{{ asset('storage/uploads/employees/' . Auth::guard('employee')->user()->slug . '/avatar' . '/' . Auth::guard('employee')->user()->avatar) }}" alt="user-image" class="rounded-circle">
                        </span>
                        @else
                        <span class="account-user-avatar">
                            <img src="{{ asset('assets/images/student.svg') }}" alt="user-image" width="32px">
                        </span>
                        @endisset
                        <span>
                            <span class="account-user-name text-dark">{{ Auth::guard('employee')->user()->firstname }} {{ Auth::guard('employee')->user()->lastname }}</span>
                            <span class="account-position">Employee</span>
                        </span>
                    </a>

                    <ul class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.dashboard') }}">
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.my-profile') }}">
                                {{ __('My Profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.awarded-jobs') }}">
                                {{ __('Jobs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.chats.index') }}">
                                {{ __('Chats') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.bookmarks') }}">
                                {{ __('Bookmarks') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('employee.password.form') }}">
                                {{ __('Change Password') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ 'App\Models\Employee' == Auth::getProvider()->getModel() ? route('employee.logout') : route('employee.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
                @endif
                @if (Auth::guard('web')->check())
                <li class="nav-item mx-auto"><a href="{{ route('chats.index') }}" class="nav-link"> <i class="uil-envelope chat-icon"></i></a><div class="count nc" id="employer-chat-count">0</div></li>
                <li class="dropdown notification-list nav-item mx-auto">
                    <a class="nav-link bellread" id="employer" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>
                    </a>
                    <div class="count nc">{{ Helper::headNotifications()->count() }}</div>
                    <div class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown" data-bs-popper="none">
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                Notification
                            </h5>
                        </div>
                        <div>
                             @if( (Helper::headNotifications()->count()) > 0 )
                                                @foreach( Helper::headNotifications() as $n)

                                                <!-- item-->

                                                @if( $n->type == 'App\Notifications\Employer\NewApplication')
                                                <p class="text-center bg-grey">
                                                    New <a href="{{ route('job.applicants', $n->data['job_id']) }}"> job({{$n->data['job_id']}}) </a> application received from
                                                    {{ $n->data['name'] }}
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employer\DocRequest')
                                                <p class="text-center bg-grey">
                                                    Document requested from {{ $n->data['name'] }}
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employer\DocRespond')
                                                <p class="text-center bg-grey">
                                                    Document {{ $n->data['status'] }} from {{ $n->data['name'] }}
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employer\JobStatus')
                                                <p class="text-center bg-grey">
                                                    Job assigned to {{ $n->data['name'] }} is {{ $n->data['status'] }}
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employer\JobClosed')
                                                <p class="text-center bg-grey">
                                                    The listed <a href="{{ route('closed-job') }}">Job</a> has been closed.
                                                </p>
                                                @endif

                                                @if( $n->type == 'App\Notifications\Employer\ApprovalNotification')
                                                <p class="text-center bg-grey">
                                                    Your <a href="{{ route('open-jobs') }}">Job</a> has been approved.
                                                </p>
                                                @endif

                                                @endforeach

                                                @else
                                                <p class="text-center nonew">No new notification found.</p>
                                                @endif
                        </div>
                        <a href="{{ route('notifications') }}" class="dropdown-item text-center notify-item notify-all">
                            View All
                        </a>
                    </div>
                </li>
                <li class="dropdown mx-auto">
                    <a class="nav-link dropdown-toggle web-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        @isset(Auth::user()->avatar)
                        <span class="account-user-avatar">
                            <img src="{{ asset('storage/uploads/employers/' . Auth::user()->slug . '/avatar' . '/' . Auth::user()->avatar) }}" alt="user-image" class="rounded-circle">
                        </span>
                        @else
                        <span class="account-user-avatar">
                            <img src="{{ asset('assets/images/teacher.svg') }}" alt="user-image" width="32px">
                        </span>
                        @endisset
                        <span>
                            <span class="account-user-name text-dark"> {{ Auth::user()->company_name }}</span>
                            <span class="account-position">Employer</span>
                        </span>
                    </a>

                    <ul class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('my-profile') }}">
                                {{ __('My Profile') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('open-jobs') }}">
                                {{ __('My Jobs') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('bookmarks') }}">
                                {{ __('Bookmarks') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('password.form') }}">
                                {{ __('Change Password') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
                @endif
                @else
                <li class="dropdown nav-item ">
                    <a href="{{ route('login') }}" class="nav-link d-lg-none dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="true">Login</a>
                    <ul class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('login') }}">Login as Employer</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.login') }}">Login as Employee</a>
                        </li>
                    </ul>
                    <a href="{{ route('login') }}" class="nav-link d-none d-lg-inline-flex dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/icons/login.svg') }}" alt="user-login" class="usericon"> Login
                    </a>
                    <ul class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('login') }}">Login as Employer</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.login') }}">Login as Employee</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown nav-item">
                    <a href="{{ route('register') }}" class="nav-link d-lg-none dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="true">Register</a>
                    <ul class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('register') }}">Register as Employer</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.register') }}">Register as Employee</a>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="nav-link d-none d-lg-inline-flex dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets/images/icons/register.svg') }}" alt="user-register" class="usericon"> Register
                    </a>
                    <ul class="dropdown-menu login-dropdown" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('register') }}">Register as Employer</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.register') }}">Register as Employee</a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<header class="mobile-menu mobile-view">
    <div class="container">
        <div class="row">

            <div class="col-5">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="user-image" height="40px" >
                </a>
            </div>
            <div class="col-5 text-end">


                @if (Auth::guard('web')->check())
                    <a class="nav-link btn btn-primary" href="{{ route('post-job') }}">Post Job</a>
                @endif


            </div>
            <div class="col-2">
                <div class="m-triger text-end">
                    <a class="navbar-toggle" type="button" class="openbtn" onclick="openNav()" href="javascript:openMMenu();">
                        <span><i class="mdi mdi-menu"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--Menu-->
    <div id="mySidebar">
        <nav id="menu">
            <ul>
                @if (Auth::guard('employee')->check() || Auth::guard('web')->check())

                @if (Auth::guard('employee')->check())
                <li style="padding: 12px;">
                    <a class="nav-link dropdown-toggle web-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="min-height: 50px;">
                        @isset(Auth::guard('employee')->user()->avatar)
                        <span class="account-user-avatar">
                            <img src="{{ asset('storage/uploads/employees/' . Auth::guard('employee')->user()->slug . '/avatar' . '/' . Auth::guard('employee')->user()->avatar) }}" alt="user-image" class="rounded-circle">
                        </span>
                        @else
                        <span class="account-user-avatar">
                            <img src="{{ asset('assets/images/student.svg') }}" alt="user-image">
                        </span>
                        @endisset
                        <span style="top: 8px; position: relative; left: 12px;">
                            <span class="account-user-name text-dark">{{ Auth::guard('employee')->user()->firstname }} {{ Auth::guard('employee')->user()->lastname }}</span>
                            <span class="account-position">Employee</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.dashboard') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.my-profile') }}">
                        {{ __('My Profile') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.applied-jobs') }}" class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="true">Jobs</a>
                    <ul>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.applied-jobs') }}">Applied Jobs</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.awarded-jobs') }}">Awarded Jobs</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.rejected-jobs') }}">Rejected Jobs</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('employee.chats.index') }}">
                        {{ __('Chats') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.bookmarks') }}">
                        {{ __('Bookmarks') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.notifications') }}">

                        {{ __('Notifications') }}
                    </a>
                </li>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                <li>
                    <a href="{{ route('employee.password.form') }}">
                        {{ __('Change Password') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ 'App\Models\Employee' == Auth::getProvider()->getModel() ? route('employee.logout') : route('employee.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                @endif
                @if (Auth::guard('web')->check())
                    <li style="padding: 12px;">
                        <a class="nav-link dropdown-toggle web-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="min-height: 50px;">
                            @isset(Auth::user()->avatar)
                            <span class="account-user-avatar">
                                <img src="{{ asset('storage/uploads/employers/' . Auth::user()->slug . '/avatar' . '/' . Auth::user()->avatar) }}" alt="user-image" class="rounded-circle">
                            </span>
                            @else
                            <span class="account-user-avatar">
                                <img src="{{ asset('assets/images/teacher.svg') }}" alt="user-image">
                            </span>
                            @endisset
                            <span style="top: 8px; position: relative; left: 12px;">
                                <span class="account-user-name text-dark"> {{ Auth::user()->company_name }}</span>
                                <span class="account-position">Employer</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('my-profile') }}">
                            {{ __('My Profile') }}
                        </a>
                    </li>

                    <li><a href="{{ route('open-jobs') }}" class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="true">Jobs</a>
                        <ul>
                            <li>
                                <a class="dropdown-item" href="{{ route('open-jobs') }}">Open Jobs</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('closed-jobs') }}">Closed Jobs</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('chats.index') }}">
                            {{ __('Chats') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bookmarks') }}">
                            {{ __('Bookmarks') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notifications') }}">
                            {{ __('Notifications') }}
                        </a>
                    </li>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                    <li>
                        <a href="{{ route('password.form') }}">
                            {{ __('Change Password') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                @endif
                @else

                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                <li>
                    <a href="{{ route('login') }}"  data-bs-toggle="dropdown" role="button" aria-haspopup="true">For Employer</a>
                    <ul>
                        <li>
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Register</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('employee.login') }}" class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" role="button" aria-haspopup="true">For Employee</a>
                    <ul>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.login') }}">Login</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee.register') }}">Register</a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</header>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.mmenu/5.6.3/js/jquery.mmenu.min.js"></script>
<script>
    var myMenu = $("#menu");

    // initialize mmenu
    myMenu.mmenu({});

    // initialize mmenu API
    var myMenuAPI = myMenu.data( "mmenu" );


    // function to set to specific subMenu
    function setMMenu(subMenu) {
    // set to subMenu
    var current = myMenu.find(subMenu);

    // myMenuAPI.setSelected(current.first());
    myMenuAPI.openPanel(current.closest(".mm-panel"));
    }

    // function to open mmmenu to specific subMenu
    function openMMenu() {
    myMenuAPI.open();
    }

    function openNav() {
        document.getElementById("mySidebar").style.width = "320px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
    }
</script>
<script>
    jQuery(document).ready(function($) {
        $('.bellread').click(function(e) {
            var u = $(this).attr('id');
            $('.nc').html(0);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
                }
            });
            $.ajax({
                url: u == 'employer' ? "{{ route('notifications.read') }}" : "{{ route('employee.notifications.read') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    _token: "{{ csrf_token() }}",
                    from: "bell"
                },
                success: function(r) {
                    console.log(r.message);
                }
            });
        })
    })
</script>
@endpush
