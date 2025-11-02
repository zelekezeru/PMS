@extends('layouts.app')

@section('content')

<div class="container mt-4">
	<div class="card shadow-sm">
		<div class="card-header">
			<h5 class="mb-0">Edit Daily Task</h5>
		</div>

		<div class="card-body">
			<form action="{{ route('daily_tasks.update', $dailyTask) }}" method="POST" class="row g-3 needs-validation" novalidate>
				@csrf
				@method('PUT')

				<div class="mb-3 form-floating">
					<input
						type="text"
						class="form-control @error('title') is-invalid @enderror"
						id="title"
						name="title"
						value="{{ old('title', $dailyTask->title) }}"
						required
						autofocus>
					<label for="title">Title <span class="text-danger">*</span></label>
					@error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
				</div>

				<div class="mb-3">
					<label for="description" class="form-label">Description / Notes</label>
					<textarea
						class="form-control @error('description') is-invalid @enderror"
						id="description"
						name="description"
						rows="6">{{ old('description', $dailyTask->description) }}</textarea>
					@error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
				</div>

				<div class="mb-3">
					<label for="user_id" class="form-label">Assign to</label>
					<select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
						<option value="">Unassigned</option>
						@foreach($users as $user)
							<option value="{{ $user->id }}" {{ (old('user_id', $dailyTask->user_id) == $user->id) ? 'selected' : '' }}>
								{{ $user->name }}
							</option>
						@endforeach
					</select>
					@error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
				</div>

				<div class="mb-3 form-floating">
					<input
						type="date"
						class="form-control @error('date') is-invalid @enderror"
						id="date_input"
						name="date"
						value="{{ old('date', $dailyTask->date) }}"
						required>
					<label for="date_input">Date <span class="text-danger">*</span></label>
					@error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
				</div>

				<div class="mb-3">
					<label for="status" class="form-label">Status</label>
					<select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
						<option value="Pending" {{ old('status', $dailyTask->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
						<option value="In Progress" {{ old('status', $dailyTask->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
						<option value="Completed" {{ old('status', $dailyTask->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
					</select>
					@error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
				</div>

				<div class="d-flex justify-content-end gap-2">
					<a href="{{ route('daily_tasks.show', $dailyTask) }}" class="btn btn-outline-secondary">Cancel</a>
					<button type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection