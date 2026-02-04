@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        @if ($fortnight->quarter && $fortnight->quarter->year)
        <h2 class="card-header text-center">{{ $fortnight->quarter->quarter }} ({{ $fortnight->quarter->year->year }}) :
            Fortnight Details</h2>

        @endif

        <h4 class="card-header text-center text-primary">{{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }} <span class="text-info"> to </span> {{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }}</h4>
        
        <div class="card-body">
            <div class="d-flex justify-content-end">
                
                <button type="button" class="btn btn-success ms-3 btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#createDeliverableModal">
                    <i class="fas fa-plus"></i> Add Deliverable
                </button>
                
                <a class="btn btn-primary btn-sm mb-3 ms-3" href="{{ route('fortnights.index') }}">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>

                @hasanyrole(['SUPER_ADMIN', 'ADMIN'])
                <a class="btn btn-primary btn-sm ms-3 mb-3" href="{{ route('fortnights.printReport', $fortnight->id) }}">
                    <i class="fa fa-print"></i> Print Report
                </a>
                @endhasanyrole

            </div>

            <div class="d-flex justify-content-end mt-4">
                @can('edit-fortnights')
                <a href="{{ route('fortnights.edit', $fortnight->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete-fortnights')
               
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $fortnight->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    
                    <form id="delete-form-{{ $fortnight->id }}" action="{{ route('fortnights.destroy', $fortnight->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                @endcan
            </div>

        </div>
    </div>
    <div class="card w-200 h-40 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between flex-wrap">
            <div class="me-3 mb-3 mb-md-0 w-100 w-md-auto">

            <div class="d-grid gap-2 d-sm-flex justify-content-sm-end align-items-center" role="toolbar" aria-label="Quick actions toolbar">
                @php
                    $show = request('show', null);
                    if (!$show) {
                        // default to tasks if available, else deliverables
                        $show = ($deliverables->count() > 0) ? 'deliverables' : (($tasks->count() > 0) ? 'tasks' : 'tasks');
                    }
                @endphp
                <div class="me-3 mb-3 mb-md-0 w-100 w-md-auto">
                    <a href="{{ route('fortnights.show', ['fortnight' => $fortnight->id, 'show' => 'deliverables']) }}"
                       data-toggle-view
                       data-view="deliverables"
                       class="btn btn-lg {{ $show === 'deliverables' ? 'btn-primary' : 'btn-outline-secondary' }} w-100 w-sm-auto"
                       role="button"
                       aria-label="Deliverables"
                       title="View fortnight deliverables">
                        <i class="fa-solid fa-box-archive me-2 text-danger" aria-hidden="true" style="font-size: 1.5rem;"></i>
                        <span class="d-none d-sm-inline">Deliverables</span>
                    </a>
                </div>
                <div class="me-3 mb-3 mb-md-0 w-100 w-md-auto">
                    <a href="{{ route('fortnights.show', ['fortnight' => $fortnight->id, 'show' => 'tasks']) }}"
                       data-toggle-view
                       data-view="tasks"
                       class="btn btn-lg {{ $show === 'tasks' ? 'btn-primary' : 'btn-outline-secondary' }} w-100 w-sm-auto"
                       role="button"
                       aria-label="Fortnight Tasks"
                       title="View fortnight tasks">
                        <i class="fa-solid fa-user-check me-2 text-success" aria-hidden="true" style="font-size: 1.5rem;"></i>
                        <span class="d-none d-sm-inline">Fortnight Tasks</span>
                    </a>
                </div>

        </div>
    </div>
    @php
        // Use query param `show` to switch view; default to tasks if available, else deliverables.
        $show = request('show', null);
        if (!$show) {
            $show = ($tasks->count() > 0) ? 'deliverables' : (($deliverables->count() > 0) ? 'deliverables' : 'tasks');
        }
    @endphp

    @if (in_array($show, ['tasks', 'deliverables']))
    
        <div class="card-header">
            <h3 id="ft-section-title" class="card-title mb-5">
                @if ($show === 'deliverables')
                    Deliverables of this fortnight
                @elseif ($show === 'tasks')
                    Tasks of this fortnight
                @else
                    Fortnight Overview
                @endif
            </h3>
        </div>

        <div id="ft-tasks" class="{{ $show === 'tasks' ? 'w-100' : 'd-none w-100' }}">
            <div class="row">
                <div class="col-12">
                    @include('tasks.list')
                </div>
            </div>
        </div>
        
            
        <div id="ft-tasks-pager" class="mt-3 {{ $show === 'tasks' ? 'w-100' : 'd-none w-100' }}">
            {{ $tasks->appends(request()->query())->links() }}
        </div>

        <div class="d-flex justify-content-end mt-3 mb-3">
            @if ($show === 'tasks')
                @can('create-tasks')
                
                    <a href="{{ route('tasks.create', ['fortnight' => $fortnight->id]) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Add Fortnight Task
                    </a>
                @endcan
            @elseif ($show === 'deliverables')
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createDeliverableModal">
                    <i class="fas fa-plus"></i> Add Deliverable
                </button>
            @endif
        </div>
        
        <div id="ft-deliverables" class="{{ $show === 'deliverables' ? 'w-100' : 'd-none w-100' }}">
            <div class="row">
                <div class="col-12">
                    @include('deliverables.list')
                </div>
            </div>
        </div>
        
        <div id="ft-deliverables-pager" class="mt-3 {{ $show === 'deliverables' ? 'w-100' : 'd-none w-100' }}">
            {{ $deliverables->appends(request()->query())->links() }}
        </div>

    @else
    <div class="alert alert-warning mt-3">
        <p>No Tasks found for this fortnight.</p>
    </div>
    @endif
</div>
@endsection

{{-- Deliverable create form modal --}}

<div class="modal fade" id="createDeliverableModal" tabindex="-1" aria-labelledby="createDeliverableLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDeliverableLabel">Create Deliverable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create-deliverable-form" action="{{ route('deliverables.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="deliverable-form-errors"></div>
                    <input type="hidden" name="fortnight_id" value="{{ $fortnight->id }}">

                    <div class="mb-3">
                        <label for="name" class="form-label">Deliverable Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" min="{{ $fortnight->start_date }}" max="{{$fortnight->end_date}}" class="form-control" name="deadline">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="create-deliverable-submit" type="submit" class="btn btn-primary">Save Deliverable</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[data-toggle-view]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var view = this.dataset.view;
                // update active classes
                document.querySelectorAll('a[data-toggle-view]').forEach(function(b) {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-primary');

                // show/hide sections
                var showTasks = (view === 'tasks');
                var showDeliverables = (view === 'deliverables');

                var ftTasks = document.getElementById('ft-tasks');
                var ftTasksPager = document.getElementById('ft-tasks-pager');
                var ftDeliver = document.getElementById('ft-deliverables');
                var ftDeliverPager = document.getElementById('ft-deliverables-pager');

                if (ftTasks) ftTasks.classList.toggle('d-none', !showTasks);
                if (ftTasksPager) ftTasksPager.classList.toggle('d-none', !showTasks);
                if (ftDeliver) ftDeliver.classList.toggle('d-none', !showDeliverables);
                if (ftDeliverPager) ftDeliverPager.classList.toggle('d-none', !showDeliverables);

                // Update header/title to reflect current view
                var titleEl = document.getElementById('ft-section-title');
                if (titleEl) {
                    if (view === 'deliverables') {
                        titleEl.textContent = 'Deliverables of this fortnight';
                    } else if (view === 'tasks') {
                        titleEl.textContent = 'Tasks of this fortnight';
                    } else {
                        titleEl.textContent = 'Fortnight Overview';
                    }
                }

                // update url without reloading
                try {
                    var url = new URL(window.location);
                    url.searchParams.set('show', view);
                    window.history.pushState({}, '', url);
                } catch (err) {
                    // ignore older browsers
                }
            });

            // Update view when browser history changes (back/forward)
            window.addEventListener('popstate', function() {
                var params = new URL(window.location).searchParams;
                var view = params.get('show') || 'tasks';

                // update active classes
                document.querySelectorAll('a[data-toggle-view]').forEach(function(b) {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-secondary');
                    if (b.dataset.view === view) {
                        b.classList.remove('btn-outline-secondary');
                        b.classList.add('btn-primary');
                    }
                });

                var showTasks = (view === 'tasks');
                var showDeliverables = (view === 'deliverables');

                var ftTasks = document.getElementById('ft-tasks');
                var ftTasksPager = document.getElementById('ft-tasks-pager');
                var ftDeliver = document.getElementById('ft-deliverables');
                var ftDeliverPager = document.getElementById('ft-deliverables-pager');

                if (ftTasks) ftTasks.classList.toggle('d-none', !showTasks);
                if (ftTasksPager) ftTasksPager.classList.toggle('d-none', !showTasks);
                if (ftDeliver) ftDeliver.classList.toggle('d-none', !showDeliverables);
                if (ftDeliverPager) ftDeliverPager.classList.toggle('d-none', !showDeliverables);

                var titleEl = document.getElementById('ft-section-title');
                if (titleEl) {
                    if (view === 'deliverables') titleEl.textContent = 'Deliverables of this fortnight';
                    else if (view === 'tasks') titleEl.textContent = 'Tasks of this fortnight';
                    else titleEl.textContent = 'Fortnight Overview';
                }
            });

        // Handle create deliverable modal via AJAX so the list updates inline
        (function() {
            var form = document.getElementById('create-deliverable-form');
            if (!form) return;

            var submitBtn = document.getElementById('create-deliverable-submit');
            var errorContainer = document.getElementById('deliverable-form-errors');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (submitBtn) submitBtn.disabled = true;
                if (errorContainer) errorContainer.innerHTML = '';

                var data = new FormData(form);

                try {
                    var res = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: data
                    });

                    if (res.status === 422) {
                        var jsonErr = await res.json();
                        var errors = jsonErr.errors || {};
                        var list = document.createElement('ul');
                        list.className = 'text-danger small';
                        Object.keys(errors).forEach(function(key) {
                            errors[key].forEach(function(msg) {
                                var li = document.createElement('li');
                                li.textContent = msg;
                                list.appendChild(li);
                            });
                        });
                        if (errorContainer) errorContainer.appendChild(list);
                        return;
                    }

                    if (!res.ok) throw new Error('Unexpected error');

                    var json = await res.json();

                    // Ensure deliverables tab is visible
                    var deliverBtn = document.querySelector('a[data-view="deliverables"]');
                    if (deliverBtn) deliverBtn.click();

                    // Insert new row into the deliverables table (prepend)
                    var tbody = document.querySelector('#ft-deliverables table tbody');
                    if (tbody && json.html) {
                        tbody.insertAdjacentHTML('afterbegin', json.html);
                    }

                    // Close modal
                    var modalEl = document.getElementById('createDeliverableModal');
                    try { var modalObj = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl); modalObj.hide(); } catch (err) {}

                    // Success alert
                    try { Swal.fire({ icon: 'success', title: 'Success', text: json.message || 'Deliverable created' }); } catch (e) {}

                    // Reset form
                    form.reset();

                } catch (err) {
                    console.error(err);
                    if (errorContainer) errorContainer.innerHTML = '<div class="text-danger">An unexpected error occurred.</div>';
                } finally {
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        })();

        });
    });
</script>