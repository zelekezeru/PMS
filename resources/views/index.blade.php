@extends('layouts.app')

@section('contents')

{{-- Main Quantities --}}
<div class="d-flex align-items-center justify-content-center flex-column pt-2 pb-4">
    <div class="text-center">
        <h3 class="fw-bold mb-3">SITS Performance Management System</h3>
        <h6 class="op-7 mb-2">Shiloh International Theological Seminary performance overview</h6>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="row">
            <a href="{{ route('tasks.index') }}">
                <div class="col-sm-6">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">All Tasks</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? count($tasks) : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('tasks.list', 'Pending') }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">Pending Tasks</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? $tasks->where('status', 'Pending')->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('tasks.list', 'Progress') }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">Tasks In Progress</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? $tasks->where('status', 'Progress')->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('tasks.list', 'Completed') }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3">
                                    <div class="numbers">
                                        <p class="card-category">Completed Tasks</p>
                                        <h4 class="card-title">{{ is_countable($tasks) ? $tasks->where('status', 'Completed')->count() : 0 }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-luggage-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3">
                                <div class="numbers">
                                    <p class="card-category">Departments</p>
                                    <h4 class="card-title">{{ is_countable($departments) ? count($departments) : 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="far fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3">
                                <div class="numbers">
                                    <p class="card-category">Registered Users</p>
                                    <h4 class="card-title">{{ is_countable($users) ? count($users) : 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5-Year Goals Section --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">SITS Pillars</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse ($strategies as $strategy)
                    <li class="list-group-item p-4"><i class="fas fa-check-circle text-success me-2"></i> {{$strategy->pillar_name}}</li>

                    @empty

                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
