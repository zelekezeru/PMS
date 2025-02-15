<!-- resources/views/reports/form.blade.php -->
<form method="POST" action="{{ isset($report) ? route('reports.update', $report->id) : route('reports.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($report))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="start_date" class="form-label"><strong>Report Starting Date:</strong></label>
            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ isset($report) ? $report->start_date : old('start_date') }}" required>
            @error('start_date')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="end_date" class="form-label"><strong>Report Ending Date:</strong></label>
            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ isset($report) ? $report->end_date : old('end_date') }}" required>
            @error('end_date')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Assign Users in Two Columns -->
        @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']) && ($users || $departments))
            <!-- Assign Users and Assign Departments Card -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Select Users & Departments</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($users)
                                <div class="col-md-6">
                                    <label for="users" class="form-label">Select Users:</label>
                                    <div class="row">
                                        @foreach($users as $index => $user)
                                            @if ($index % 2 == 0 && $index > 0)
                                                </div><div class="row"> <!-- New Row -->
                                            @endif
                                            <div class="col-md-6">
                                                <input class="form-check-input" type="checkbox" name="user_id[]" value="{{ $user->id }}" id="user-{{ $user->id }}" {{ (in_array($user->id, old('user_id', [])) ? 'checked' :  in_array($user->id, $assignedUsers)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="user-{{ $user->id }}">{{ $user->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('user_id')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>                                
                            @endif

                            <!-- Assign Departments -->
                            @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                <div class="col-md-6">
                                    <label for="department_id" class="form-label">Responsible Departments:</label>
                                    <select name="department_id[]" class="form-control @error('department_id') is-invalid @enderror" id="department_id" multiple>
                                        @php
                                            $selectedDepartments = old('department_id', isset($report) && $report->departments()->count() !== 0 ? $report->departments->pluck('id')->toArray() : []);
                                        @endphp
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ in_array($department->id, $selectedDepartments) ? 'selected' : '' }}>{{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            @php
                $departmentId = Auth::user()->department_id ?? (isset($report) ? $report->departments->first()->id : null);
                $userId = Auth::user()->id ?? (isset($report) ? $report->users->first()->id : null);
            @endphp
            <input type="hidden" name="user_id[]" value="{{ $userId }}">
            <input type="hidden" name="department_id[]" value="{{ $departmentId }}">
        @endif

    </div>

    <button type="submit" class="btn {{ isset($report) ? 'btn-warning' : 'btn-success' }} mt-3">
        {{ isset($report) ? 'Update Report' : 'Create Report' }}
    </button>
</form>
