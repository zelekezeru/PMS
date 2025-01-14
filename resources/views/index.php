<x-admin-layout>
    <div class="container mt-5 pt-5">

        <h3 class="fw-bold mb-3 text-center">Dashboard</h3>
        <h4 class="op-7 mb-2 text-center">SITS Admin Managment Panel</h4>

        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    <a href="{{ route('courses.list') }}" class="btn btn-label-info btn-round me-2">Manage</a>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary btn-round">Add Course</a>
                </div>
            </div>
            <div class="row">
                <!-- Users Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('users.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Users</p>
                                            <h4 class="card-title">{{ $usersCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Courses Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('courses.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Courses</p>
                                            <h4 class="card-title">{{ $coursesCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Programs Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('programs.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Programs</p>
                                            <h4 class="card-title">{{ $programsCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Trainers Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('trainers.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Trainers</p>
                                            <h4 class="card-title">{{ $trainersCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Events Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('events.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Events</p>
                                            <h4 class="card-title">{{ $eventsCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Blogs Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('blogs.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                            <i class="fas fa-list"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Blogs</p>
                                            <h4 class="card-title">{{ $blogsCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Tasks Card -->
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('tasks.list') }}">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-warning bubble-shadow-small">
                                            <i class="fas fa-tasks"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Tasks</p>
                                            <h4 class="card-title">{{ $tasksCount }}</h4> <!-- Display real count -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
</x-admin-layout>


