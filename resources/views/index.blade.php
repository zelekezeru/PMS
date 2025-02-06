@extends('layouts.app')

@section('contents')

{{-- Main Quantities --}}
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3 text-center">SITS Performance Management System</h3>
        <h6 class="op-7 mb-2">Here is SITS college performance overview</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="row">
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
            </div>
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
                                    <p class="card-category">Pending Tasks</p>
                                    <h4 class="card-title">{{ is_countable($tasks) ? count($tasks) : 0 }}</h4>
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
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3">
                                <div class="numbers">
                                    <p class="card-category">Completed Tasks</p>
                                    <h4 class="card-title">{{ is_countable($tasks) ? count($tasks) : 0 }}</h4>
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
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3">
                                <div class="numbers">
                                    <p class="card-category">Tasks In Progress</p>
                                    <h4 class="card-title">13</h4>
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
