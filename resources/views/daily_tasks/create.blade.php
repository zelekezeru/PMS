@extends('layouts.app')

@section('contents')

<div class="container mt-4">
	<div class="card shadow-sm">
		<div class="card-header d-flex justify-content-between align-items-center">
			<h5 class="mb-0">Create Daily Task</h5>
			<small class="text-muted">Make tasks quick to add — required fields marked *</small>
		</div>

		<div class="card-body">
			<form action="{{ route('daily_tasks.store') }}" method="POST" class="row g-3 needs-validation" novalidate>
				@csrf
				<input type="hidden" name="dailyTask" value="1">
				<input type="hidden" name="date" value="{{ old('date', $selectedDate ?? now()->format('Y-m-d')) }}">

				<!-- Left column: main inputs -->
				<div class="col-12 col-lg-8">
					<div class="mb-3 form-floating">
						<input
							type="text"
							class="form-control @error('title') is-invalid @enderror"
							id="title"
							name="title"
							placeholder="Title"
							value="{{ old('title') }}"
							required
							autofocus
							aria-describedby="titleHelp">
						<label for="title">Title <span class="text-danger">*</span></label>
						<div id="titleHelp" class="form-text">Short descriptive title (e.g., "Pickup supplies").</div>
						@error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
					</div>

					<div class="mb-3">
						<label for="description" class="form-label">Description / Notes</label>
						<textarea
							class="form-control @error('description') is-invalid @enderror"
							id="description"
							name="description"
							rows="6"
							placeholder="Add details, steps, or links...">{{ old('description') }}</textarea>
						<small class="form-text text-muted">Write the description here..</small>
						@error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
					</div>
				</div>

				<!-- Right column: metadata and actions -->
				<div class="col-12 col-lg-4">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Assign to</label>
                        <div class="input-group">
                            <span class="input-group-text" id="user-addon" aria-hidden>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path d="M2 14s1-1 6-1 6 1 6 1-1 1-6 1-6-1-6-1z"/>
                                </svg>
                            </span>
                            <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" aria-describedby="userHelp">
                                <option value="">Unassigned</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', Auth::id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="userHelp" class="form-text text-muted">Optional — leave unassigned if unsure.</small>
                        @error('user_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

					<div class="mb-3 form-floating">
						<input
							type="date"
							class="form-control @error('date') is-invalid @enderror"
							id="date_input"
							name="date"
							value="{{ old('date', $selectedDate ?? now()->format('Y-m-d')) }}"
							min="{{ now()->subYear()->format('Y-m-d') }}"
							max="{{ now()->addYear()->format('Y-m-d') }}"
							required>
						<label for="date_input">Date <span class="text-danger">*</span></label>
						@error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
					</div>

					<div class="mb-3 form-floating">
						<select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
							<option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
							<option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
							<option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
						</select>
						<label for="status">Status <span class="text-danger">*</span></label>
						@error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
					</div>

					<div class="d-grid gap-2 mt-4">
						<button type="submit" class="btn btn-primary btn-lg">Create Task</button>
					</div>
				</div>

				<!-- show server-side validation count if present -->
				@if ($errors->any())
					<div class="col-12">
						<div class="alert alert-danger py-2 mb-0">
							<small class="mb-0">Please fix the highlighted fields before submitting.</small>
						</div>
					</div>
				@endif
			</form>
		</div>
	</div>
</div>

<!-- Client-side bootstrap validation -->
<script>
	(() => {
		'use strict';
		const forms = document.querySelectorAll('.needs-validation');
		Array.from(forms).forEach(form => {
			form.addEventListener('submit', event => {
				if (!form.checkValidity()) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
		});
	})();
</script>

@endsection
