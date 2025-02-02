<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('index') }}" class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="navbar brand" class="navbar-brand"
                    height="50" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('index') ? 'active' : '' }}">
                    <a href="{{ route('index') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Task Navigation --}}
                <li class="nav-item {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.create') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#PerformanceDropdown" aria-expanded="false">
                        <i class="fas fa-tasks"></i>
                        <p>Tasks</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="PerformanceDropdown">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                                <a href="{{ route('tasks.index') }}">
                                    <i class="fas fa-clipboard-list"></i> Manage Tasks
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                                <a href="{{ route('tasks.create') }}">
                                    <i class="fas fa-plus-circle"></i> Add Task
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Strategy Navigation --}}
                <li class="nav-item {{ request()->routeIs('strategies.index') || request()->routeIs('strategies.create') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Strategy">
                        <i class="fas fa-lightbulb"></i>
                        <p>Strategy</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Strategy">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('strategies.index') ? 'active' : '' }}">
                                <a href="{{ route('strategies.index') }}">
                                    <i class="fas fa-list-ul"></i> Manage Strategy
                                </a>
                            </li>

                            {{-- ONLY FOR ADMIN USERS --}}
                            @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                                <li class="{{ request()->routeIs('strategies.create') ? 'active' : '' }}">
                                    <a href="{{ route('strategies.create') }}">
                                        <i class="fas fa-plus"></i> Add Strategy
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                {{-- Goal Navigation --}}
                <li class="nav-item {{ request()->routeIs('goals.index') || request()->routeIs('goals.create') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Goal">
                        <i class="fas fa-bullseye"></i>
                        <p>Goal</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Goal">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('goals.index') ? 'active' : '' }}">
                                <a href="{{ route('goals.index') }}">
                                    <i class="fas fa-list-check"></i> Manage Goal
                                </a>
                            </li>

                            {{-- ONLY FOR ADMIN USERS --}}
                            @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                                <li class="{{ request()->routeIs('goals.create') ? 'active' : '' }}">
                                    <a href="{{ route('goals.create') }}">
                                        <i class="fas fa-plus"></i> Add Goal
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                {{-- Target Navigation --}}
                <li class="nav-item {{ request()->routeIs('targets.index') || request()->routeIs('targets.create') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Target">
                        <i class="fas fa-crosshairs"></i>
                        <p>Target</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Target">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('targets.index') ? 'active' : '' }}">
                                <a href="{{ route('targets.index') }}">
                                    <i class="fas fa-bullseye"></i> Manage Target
                                </a>
                            </li>

                            {{-- ONLY FOR ADMIN USERS --}}
                            @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                                <li class="{{ request()->routeIs('targets.create') ? 'active' : '' }}">
                                    <a href="{{ route('targets.create') }}">
                                        <i class="fas fa-plus"></i> Add Target
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                {{-- ONLY FOR ADMIN USERS --}}
                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                    {{-- Department Navigation --}}
                    <li class="nav-item {{ request()->routeIs('departments.index') || request()->routeIs('departments.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Department">
                            <i class="fas fa-building"></i>
                            <p>Department</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="Department">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('departments.index') ? 'active' : '' }}">
                                    <a href="{{ route('departments.index') }}">
                                        <i class="fas fa-users-cog"></i> Manage Department
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('departments.create') ? 'active' : '' }}">
                                    <a href="{{ route('departments.create') }}">
                                        <i class="fas fa-plus"></i> Add Department
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- Report Navigation --}}
                <li class="nav-item {{ request()->routeIs('reports.index') || request()->routeIs('reports.create') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#Report">
                        <i class="fas fa-file-alt"></i>
                        <p>Report</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Report">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
                                <a href="{{ route('reports.index') }}">
                                    <i class="fas fa-file-invoice"></i> Manage Report
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('reports.create') ? 'active' : '' }}">
                                <a href="{{ route('reports.create') }}">
                                    <i class="fas fa-plus"></i> Add Report
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- ONLY FOR ADMIN USERS --}}
                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                    {{-- Schedule Navigation --}}
                    <li class="nav-item {{ request()->routeIs('years.index') || request()->routeIs('quarters.index') || request()->routeIs('fortnights.index') || request()->routeIs('days.index') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Schedule">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Plan Time</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="Schedule">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('years.index') ? 'active' : '' }}">
                                    <a href="{{ route('years.index') }}">
                                        <i class="fas fa-calendar"></i> Manage Years
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('quarters.index') ? 'active' : '' }}">
                                    <a href="{{ route('quarters.index') }}">
                                        <i class="fas fa-calendar-week"></i> Manage Quarters
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('fortnights.index') ? 'active' : '' }}">
                                    <a href="{{ route('fortnights.index') }}">
                                        <i class="fas fa-calendar-day"></i> Manage Fortnights
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('days.index') ? 'active' : '' }}">
                                    <a href="{{ route('days.index') }}">
                                        <i class="fas fa-calendar-check"></i> Manage Days
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- User Management Navigation --}}
                    <li class="nav-item {{ request()->routeIs('users.index') || request()->routeIs('users.waiting') || request()->routeIs('users.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#User">
                            <i class="fas fa-user-shield"></i>
                            <p>User Management</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="User">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <a href="{{ route('users.index') }}">
                                        <i class="fas fa-users"></i> Registered Users
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('users.waiting') ? 'active' : '' }}">
                                    <a href="{{ route('users.waiting') }}">
                                        <i class="fas fa-user-clock"></i> Waiting Approval
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('users.create') ? 'active' : '' }}">
                                    <a href="{{ route('users.create') }}">
                                        <i class="fas fa-user-plus"></i> Register User
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- Department Head Navigation --}}
                @if (request()->user()->hasRole('DEPARTMENT_HEAD'))
                    <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : ''}}">
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Employees in Department</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
