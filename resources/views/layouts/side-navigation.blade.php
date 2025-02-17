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
                @canany(['view-tasks', 'create-tasks', 'edit-tasks', 'delete-tasks'])
                    <li class="nav-item {{ request()->routeIs('tasks.index') || request()->routeIs('tasks.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#PerformanceDropdown" aria-expanded="false">
                            <i class="fas fa-tasks"></i>
                            <p>Tasks</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="PerformanceDropdown">
                            <ul class="nav nav-collapse">
                                @can('view-tasks')
                                    <li class="{{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                                        <a href="{{ route('tasks.index') }}">
                                            <i class="fas fa-clipboard-list"></i> Manage Tasks
                                        </a>
                                    </li>

                                @endcan
                                @can('create-tasks')
                                    <li class="{{ request()->routeIs('tasks.create') ? 'active' : '' }}">
                                        <a href="{{ route('tasks.create') }}">
                                            <i class="fas fa-plus-circle"></i> Add Task
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>

                @endcanany

                @canany(['view-fortnights', 'create-fortnights'])
                    {{-- fortnight Navigation --}}
                    <li class="nav-item {{ request()->routeIs('fortnights.index') || request()->routeIs('fortnights.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#fortnight">
                            <i class="fas  fa-clock"></i>
                            <p>Fortnight Planning</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="fortnight">
                            <ul class="nav nav-collapse">
                                @can('view-fortnights')
                                <li class="{{ request()->routeIs('fortnights.index') ? 'active' : '' }}">
                                    <a href="{{ route('fortnights.index') }}">
                                        <i class="fas fa-bullseye"></i> All FortnightS
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Strategy Navigation --}}
                @canany(['view-strategies', 'create-strategies', 'edit-strategies', 'delete-strategies'])
                    <li class="nav-item {{ request()->routeIs('strategies.index') || request()->routeIs('strategies.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Strategy">
                            <i class="fas fa-lightbulb"></i>
                            <p>Strategy</p>
                            <span class="caret"></span>
                        </a>

                        <div class="collapse" id="Strategy">
                            <ul class="nav nav-collapse">
                                @can('view-strategies')
                                    <li class="{{ request()->routeIs('strategies.index') ? 'active' : '' }}">
                                        <a href="{{ route('strategies.index') }}">
                                            <i class="fas fa-list-ul"></i> Manage Strategy
                                        </a>
                                    </li>
                                @endcan

                                {{-- ONLY FOR ADMIN USERS --}}
                                @can('create-strategies')
                                    <li class="{{ request()->routeIs('strategies.create') ? 'active' : '' }}">
                                        <a href="{{ route('strategies.create') }}">
                                            <i class="fas fa-plus"></i> Add Strategy
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Goal Navigation --}}
                @canany(['view-goals', 'create-goals'])
                    <li class="nav-item {{ request()->routeIs('goals.index') || request()->routeIs('goals.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Goal">
                            <i class="fas fa-bullseye"></i>
                            <p>Goal</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="Goal">
                            <ul class="nav nav-collapse">
                                @can('view-goals')
                                    <li class="{{ request()->routeIs('goals.index') ? 'active' : '' }}">
                                        <a href="{{ route('goals.index') }}">
                                            <i class="fas fa-list-check"></i> Manage Goal
                                        </a>
                                    </li>
                                @endcan

                                {{-- ONLY FOR ADMIN USERS --}}
                                @can ('create-goals')
                                    <li class="{{ request()->routeIs('goals.create') ? 'active' : '' }}">
                                        <a href="{{ route('goals.create') }}">
                                            <i class="fas fa-plus"></i> Add Goal
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['view-targets', 'create-targets'])
                    {{-- Target Navigation --}}
                    <li class="nav-item {{ request()->routeIs('targets.index') || request()->routeIs('targets.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Target">
                            <i class="fas fa-crosshairs"></i>
                            <p>Target</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="Target">
                            <ul class="nav nav-collapse">
                                @can('view-targets')
                                    <li class="{{ request()->routeIs('targets.index') ? 'active' : '' }}">
                                        <a href="{{ route('targets.index') }}">
                                            <i class="fas fa-bullseye"></i> Manage Target
                                        </a>
                                    </li>
                                @endcan

                                {{-- ONLY FOR ADMIN USERS --}}
                                @can('create-targets')
                                    <li class="{{ request()->routeIs('targets.create') ? 'active' : '' }}">
                                        <a href="{{ route('targets.create') }}">
                                            <i class="fas fa-plus"></i> Add Target
                                        </a>
                                    </li>

                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- ONLY FOR ADMIN USERS --}}
                @canany (['create-departments'])
                    @if(!request()->user()->hasRole('EMPLOYEE'))
                        {{-- Department Navigation --}}
                        <li class="nav-item {{ request()->routeIs('departments.index') || request()->routeIs('departments.create') ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#Department">
                                <i class="fas fa-building"></i>
                                <p>Department</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="Department">
                                <ul class="nav nav-collapse">
                                    @can ('view-departments')
                                    <li class="{{ request()->routeIs('departments.index') ? 'active' : '' }}">
                                        <a href="{{ route('departments.index') }}">
                                            <i class="fas fa-users-cog"></i> Manage Department
                                        </a>
                                    </li>
                                    @endcan

                                    @can ('create-departments')
                                    <li class="{{ request()->routeIs('departments.create') ? 'active' : '' }}">
                                        <a href="{{ route('departments.create') }}">
                                            <i class="fas fa-plus"></i> Add Department
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                        @endif
                @endcanany

                {{-- Report Navigation --}}

                @canany (['view-reports', 'create-reports'])
                    <li class="nav-item {{ request()->routeIs('reports.index') || request()->routeIs('reports.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Report">
                            <i class="fas fa-file-alt"></i>
                            <p>Report</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="Report">
                            <ul class="nav nav-collapse">
                                @can('view-departments')
                                    <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
                                        <a href="{{ route('reports.index') }}">
                                            <i class="fas fa-file-invoice"></i> Manage Report
                                        </a>
                                    </li>
                                @endcan

                                @can('create-departments')
                                    <li class="{{ request()->routeIs('reports.create') ? 'active' : '' }}">
                                        <a href="{{ route('reports.create') }}">
                                            <i class="fas fa-plus"></i> Add Report
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['view-years', 'view-quarters', 'view-days', 'view-fortnights', 'view-days'])

                @if(!request()->user()->hasRole('EMPLOYEE'))
                    {{-- Schedule Navigation --}}
                    <li class="nav-item {{ request()->routeIs('years.index') || request()->routeIs('quarters.index') || request()->routeIs('fortnights.index') || request()->routeIs('days.index') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#Schedule">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Plan Time</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="Schedule">
                            <ul class="nav nav-collapse">
                                @can('view-years')
                                    <li class="{{ request()->routeIs('years.index') ? 'active' : '' }}">
                                        <a href="{{ route('years.index') }}">
                                            <i class="fas fa-calendar"></i> Manage Years
                                        </a>
                                    </li>

                                @endcan
                                @can('view-quarters')
                                    <li class="{{ request()->routeIs('quarters.index') ? 'active' : '' }}">
                                        <a href="{{ route('quarters.index') }}">
                                            <i class="fas fa-calendar"></i> Manage Quarters
                                        </a>
                                    </li>
                                @endcan

                                @can('view-fortnights')
                                    <li class="{{ request()->routeIs('fortnights.index') ? 'active' : '' }}">
                                        <a href="{{ route('fortnights.index') }}">
                                            <i class="fas fa-calendar"></i> Manage Fortnights
                                        </a>
                                    </li>
                                @endcan

                                @can('view-days')
                                    <li class="{{ request()->routeIs('days.index') ? 'active' : '' }}">
                                        <a href="{{ route('days.index') }}">
                                            <i class="fas fa-calendar"></i> Manage Days
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                    
                @endif

                @endcanany

                @canany(['view-users', 'create-users' , 'approve-users'])
                    {{-- User Management Navigation --}}
                    <li class="nav-item {{ request()->routeIs('users.index') || request()->routeIs('users.waiting') || request()->routeIs('users.create') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#User">
                            <i class="fas fa-user-shield"></i>
                            <p>User Management</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="User">
                            <ul class="nav nav-collapse">
                                @can('view-users')
                                    <li class="{{ request()->routeIs('users.index') ? 'active' : '' }}">
                                        <a href="{{ route('users.index') }}">
                                            <i class="fas fa-users"></i> All Registered Users
                                        </a>
                                    </li>
                                @endcan

                                @can('approve-users')
                                    <li class="{{ request()->routeIs('users.waiting') ? 'active' : '' }}">
                                        <a href="{{ route('users.waiting') }}">
                                            <i class="fas fa-user-clock"></i> Waiting Approval
                                        </a>
                                    </li>
                                    {{-- <li class="{{ request()->routeIs('users.assign') ? 'active' : '' }}">
                                        <a href="{{ route('users.assign') }}">
                                            <i class="fas fa-user-clock"></i> Assign Roles
                                        </a>
                                    </li> --}}
                                @endcan

                                @can('create-users')
                                    <li class="{{ request()->routeIs('users.create') ? 'active' : '' }}">
                                        <a href="{{ route('users.create') }}">
                                            <i class="fas fa-user-plus"></i> Register User
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Department Head Navigation --}}
                {{-- @if (request()->user()->hasRole('DEPARTMENT_HEAD'))
                    @can('view-department-users')
                        <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : ''}}">
                            <a href="{{ route('users.index') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <p>Employees in Department</p>
                            </a>
                        </li>
                    @endcan
                @endif --}}
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
