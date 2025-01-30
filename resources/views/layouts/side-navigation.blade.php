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
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a href="{{ route('index') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Task Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#PerformanceDropdown" aria-expanded="false">
                        <i class="fas fa-chart-line"></i>
                        <p>Tasks</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="PerformanceDropdown">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('tasks.index') }}">
                                    <i class="fas fa-edit"></i> Manage Tasks
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tasks.create') }}">
                                    <i class="fas fa-plus-circle"></i> Add Task
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                {{-- Strategy Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Strategy">
                        <i class="fas fa-book"></i>
                        <p>Strategy</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Strategy">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('strategies.index') }}">
                                    <i class="fas fa-list"></i>Manage Strategy
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('strategies.create') }}">
                                    <i class="fas fa-plus"></i>Add Strategy
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Goal Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Goal">
                        <i class="fas fa-book"></i>
                        <p>Goal</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Goal">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('goals.index') }}">
                                    <i class="fas fa-list"></i>Manage Goal
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('goals.create') }}">
                                    <i class="fas fa-plus"></i>Add Goal
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Target Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Target">
                        <i class="fas fa-book"></i>
                        <p>Target</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Target">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('targets.index') }}">
                                    <i class="fas fa-list"></i>Manage Target
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('targets.create') }}">
                                    <i class="fas fa-plus"></i>Add Target
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Department Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Department">
                        <i class="fas fa-book"></i>
                        <p>Department</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Department">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('departments.index') }}">
                                    <i class="fas fa-list"></i>Manage Department
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('departments.create') }}">
                                    <i class="fas fa-plus"></i>Add Department
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Report Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Report">
                        <i class="fas fa-book"></i>
                        <p>Report</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Report">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('reports.index') }}">
                                    <i class="fas fa-list"></i>Manage Report
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reports.create') }}">
                                    <i class="fas fa-plus"></i>Add Report
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Schedule Navigation --}}

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Schedules</h4>
                </li>
                {{-- Schedule Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#Schedule">
                        <i class="fas fa-book"></i>
                        <p>Plan Time</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="Schedule">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('years.index') }}">
                                    <i class="fas fa-list"></i>Manage Years
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('quarters.index') }}">
                                    <i class="fas fa-list"></i>Manage Quarters
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fortnights.index') }}">
                                    <i class="fas fa-list"></i>Manage Fortnights
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('days.index') }}">
                                    <i class="fas fa-list"></i>Manage Days
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                {{-- ONLY FOR ADMIN USERS --}}

                @if (request()->user()->hasAnyRole(['SUPER_ADMIN', 'ADMIN']))
                {{-- User Navigation --}}

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#User">
                        <i class="fas fa-book"></i>
                        <p>User</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="User">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <i class="fas fa-list"></i>Manage User
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.waiting') }}">
                                    <i class="fas fa-plus"></i>Waiting Approval
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                    
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
