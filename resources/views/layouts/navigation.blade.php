
<div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="navbar brand" class="navbar-brand"
                height="20" />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>

<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"data-background-color="dark">
    <div class="container-fluid">
        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
                <input type="text" placeholder="Search ..." class="form-control" />
            </div>
        </nav>


        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false" aria-haspopup="true">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." class="form-control" />
                        </div>
                    </form>
                </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                    <li>
                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                            Feedbacks
                        </div>
                    </li>
                    <li>
                        <div class="message-notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                @foreach(Auth::user()->feedbacks as $feedback)
                                    <a href="{{ route('tasks.show', $feedback->task->id) }}">
                                        <div class="notif-img">
                                            <img class="avatar-img rounded" src="{{ auth()->user()->profile_image ? Storage::url(auth()->user()->profile_image) : asset('img/user.png') }}" alt="Img Profile">
                                        </div>
                                        <div class="notif-content">
                                            <span class="subject">{{ $feedback->user->name }}</span>
                                            <span class="block">{{ $feedback->comment }}</span>
                                            <span class="time">{{ $feedback->timestamp }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);">See all messages<i
                                class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">
                            You have 4 new notification
                        </div>
                    </li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-icon notif-primary">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="notif-content">
                                        <span class="block"> New user registered </span>
                                        <span class="time">5 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-icon notif-success">
                                        <i class="fa fa-comment"></i>
                                    </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Rahmad commented on Admin
                                        </span>
                                        <span class="time">12 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="{{ asset('img/profile2.jpg') }}" alt="Img Profile" />
                                    </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Reza send messages to you
                                        </span>
                                        <span class="time">12 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-icon notif-danger">
                                        <i class="fa fa-heart"></i>
                                    </div>
                                    <div class="notif-content">
                                        <span class="block"> Farrah liked Admin </span>
                                        <span class="time">17 minutes ago</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="see-all" href="javascript:void(0);">See all notifications<i
                                class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-layer-group"></i>
                </a>
                <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                        <span class="title mb-1">Quick Actions</span>
                        <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                        <div class="quick-actions-items">
                            <div class="row m-0">
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-danger rounded-circle">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <span class="text">Calendar</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-warning rounded-circle">
                                            <i class="fas fa-map"></i>
                                        </div>
                                        <span class="text">Maps</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-info rounded-circle">
                                            <i class="fas fa-file-excel"></i>
                                        </div>
                                        <span class="text">Reports</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-success rounded-circle">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <span class="text">Emails</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-primary rounded-circle">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <span class="text">Invoice</span>
                                    </div>
                                </a>
                                <a class="col-6 col-md-4 p-0" href="#">
                                    <div class="quick-actions-item">
                                        <div class="avatar-item bg-secondary rounded-circle">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <span class="text">Payments</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false">
                    <i class="fas fa-cog"></i>
                </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    @if(Auth::user())
                                        <div class="avatar-lg">
                                            <img class="avatar-img rounded" src="{{ auth()->user()->profile_image ? Storage::url(auth()->user()->profile_image) : asset('img/user.png') }}" alt="Profile Image">
                                        </div>
                                        <div class="u-text text-white">
                                            <h4>{{ Auth::user()->name ?? 'Guest' }}</h4>
                                            <p class=" text-white">{{ Auth::user()->email ?? 'No email' }}</p>
                                            <a href="{{route('profile.edit')}}" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                        </div>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('profile.edit')}}">My Profile</a>
                                <a class="dropdown-item" href="#">Inbox</a>
                                <a class="dropdown-item" href="#">Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <div class="btn bnt-sm btn-danger btn-sm">
                                            {{ __('Log Out') }}
                                        </div>
                                    </x-responsive-nav-link>
                                </form>
                            </li>
                        </div>
                    </ul>
            </li>
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    @if(Auth::user())
                        <div class="avatar-sm">
                            <img class="avatar-img rounded"
                            src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('img/user.png') }}"
                            alt="Profile Image">
                        </div>
                        <span class="profile-username">
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                @if(Auth::user())
                                    <div class="avatar-lg">
                                        <<img class="avatar-img rounded"
                                        src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('img/user.png') }}"
                                        alt="Profile Image">
                                    </div>
                                    <div class="u-text text-white">
                                        <h4>{{ Auth::user()->name ?? 'Guest' }}</h4>
                                        <p class="text-white">{{ Auth::user()->email ?? 'No email' }}</p>
                                        <a href="{{route('profile.edit')}}" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                    </div>
                                @endif
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('profile.edit')}}">My Profile</a>
                            <a class="dropdown-item" href="#">Inbox</a>
                            <a class="dropdown-item" href="#">Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <div class="btn btn-sm btn-danger">
                                        {{ __('Log Out') }}
                                    </div>
                                </x-responsive-nav-link>
                            </form>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
