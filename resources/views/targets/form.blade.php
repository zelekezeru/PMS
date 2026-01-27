<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label"><strong>Target Name:</strong></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $target->name ?? '') }}" placeholder="Target Name" required>
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="budget" class="form-label"><strong>Budget:</strong></label>
            <input type="text" name="budget" class="form-control @error('budget') is-invalid @enderror" id="budget" value="{{ old('budget', $target->budget ?? '') }}" placeholder="Budget">
            @error('budget')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="value" class="form-label"><strong>Value:</strong></label>
            <input type="number" step="0.01" name="value" class="form-control @error('value') is-invalid @enderror" id="value" value="{{ old('value', $target->value ?? '') }}" placeholder="Value">
            @error('value')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="unit" class="form-label"><strong>Unit:</strong></label>
            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" id="unit" value="{{ old('unit', $target->unit ?? '') }}" placeholder="Unit">
            @error('unit')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="goal_id" class="form-label"><strong>Goal:</strong></label>
            <select name="goal_id" class="form-control @error('goal_id') is-invalid @enderror" id="goal_id" required>
                <!-- Assuming you have a list of goals -->
                <option value="" {{ old('goal_id') == '' ? 'selected' : '' }}>Select Goal</option>
                @foreach($goals as $goal)
                    <option value="{{ $goal->id }}" {{ old('goal_id', $target->goal_id ?? '') == $goal->id ? 'selected' : '' }}>{{ $goal->name }}</option>
                @endforeach
            </select>
            @error('goal_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="department_id" class="form-label"><strong>Responsible Departments:</strong></label>
            <select name="department_id[]" class="form-control @error('department_id') is-invalid @enderror" id="department_id" multiple required>
                @php
                    $selectedDepartments = old('department_id', isset($target) && $target->departments ? $target->departments->pluck('id')->toArray() : []);
                @endphp

                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ in_array($department->id, $selectedDepartments) ? 'selected' : '' }}>{{ $department->department_name }}</option>
                @endforeach
            </select>
            @error('department_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-10 mb-3">
            <label for="year_id" class="form-label"><strong>Year:</strong></label>
            <select name="year_id" class="form-control @error('year_id') is-invalid @enderror" id="year_id" required>
                <!-- Assuming you have a list of strategies -->
                <option value="" {{ old('year_id') == '' ? 'selected' : '' }}>Select Year</option>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ old('year_id', $goal->year_id ?? '') == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
                @endforeach
            </select>
            @error('year_id')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ $buttonText }}</button>
</form>
