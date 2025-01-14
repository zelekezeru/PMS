<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
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
                    <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#PerformanceDropdown" aria-expanded="false">
                        <i class="fas fa-chart-line"></i>
                        <p>Performance Management</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="PerformanceDropdown">
                        <ul class="nav nav-collapse">
                            <li class="nav-item">
                                <a data-bs-toggle="collapse" href="#TaskManagementDropdown" aria-expanded="false">
                                    <i class="fas fa-tasks"></i> Task Management
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="TaskManagementDropdown">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('tasks.list') }}">
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
                        </ul>
                    </div>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
