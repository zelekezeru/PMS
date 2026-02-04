@extends('layouts.app')

@section('contents')

<div class="container mt-3">
    <div class="card pt-5">
        <h2 class="card-header text-center">deliverables List</h2>
        <div class="card-body">
            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createDeliverableModal">
                    <i class="fas fa-plus"></i> Add Deliverable
                </button>
            @endif

            @include('deliverables.list')

            {{ $deliverables->links() }}
            <!-- SweetAlert Success Notifications -->
            @if (session('status'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'deliverable {{ ucfirst(session('status')) }}',
                            text: 'Your deliverable has been successfully {{ session('status') }}.',
                            confirmButtonText: 'Okay'
                        });
                    });
                </script>
            @endif

        </div>
    </div>
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

                // update url without reloading
                try {
                    var url = new URL(window.location);
                    url.searchParams.set('show', view);
                    window.history.pushState({}, '', url);
                } catch (err) {
                    // ignore older browsers
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