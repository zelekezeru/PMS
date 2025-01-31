<!-- resources/views/reports/form.blade.php -->
<form method="POST" action="{{ isset($report) ? route('reports.update', $report->id) : route('reports.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($report))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="report_date" class="form-label"><strong>Report Date:</strong></label>
            <input type="date" name="report_date" id="report_date" class="form-control @error('report_date') is-invalid @enderror" value="{{ isset($report) ? $report->report_date : old('report_date') }}" required>
            @error('report_date')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="department_id" class="form-label"><strong>Department:</strong></label>
            <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ isset($report) && $report->department_id == $department->id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="user_id" class="form-label"><strong>User:</strong></label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ isset($report) && $report->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="target_id" class="form-label"><strong>Target:</strong></label>
            <select name="target_id" id="target_id" class="form-control @error('target_id') is-invalid @enderror" required>
                <option value="">Select Target</option>
                @foreach($targets as $target)
                    <option value="{{ $target->id }}" {{ isset($report) && $report->target_id == $target->id ? 'selected' : '' }}>{{ $target->name }}</option>
                @endforeach
            </select>
            @error('target_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label for="schedule" class="form-label"><strong>Schedule:</strong></label>
            <input type="text" name="schedule" id="schedule" class="form-control @error('schedule') is-invalid @enderror" value="{{ isset($report) ? $report->schedule : old('schedule') }}" required>
            @error('schedule')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn {{ isset($report) ? 'btn-warning' : 'btn-success' }} mt-3">
        {{ isset($report) ? 'Update Report' : 'Create Report' }}
    </button>
</form>
