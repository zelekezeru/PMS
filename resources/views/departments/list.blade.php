<style>
    .custom-dropdown-menu {
        background-color: #343a40; /* Matches the dark background of the table header */
        border-color: #454d55; /* Slightly lighter border to match the theme */
    }
    .custom-dropdown-menu .dropdown-item {
        color: #fff; /* White text to maintain readability */
    }
    .custom-dropdown-menu .dropdown-item:hover {
        background-color: #495057; /* Slightly lighter hover color */
    }
</style>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th class="d-flex align-items-center text-white">
                    <span class="me-2">Department</span>
                    @if(isset($allDepartments) && count($allDepartments) > 0)
                        <div class="dropdown">
                            <i class="fa fa-chevron-down text-white px-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-filter text-white"></i>
                            </i>
                            <ul class="dropdown-menu custom-dropdown-menu">
                                <!-- Show All Option -->
                                <li>
                                    <a class="dropdown-item {{ request('department_id') ? '' : 'active' }}" 
                                        href="{{ route('departments.index', array_merge(request()->query(), ['department_id' => null])) }}">
                                        Show All Options
                                    </a>
                                </li>
                                
                                <!-- List all departments -->
                                @foreach($allDepartments as $department)
                                    <li>
                                        <a class="dropdown-item {{ request('department_id') == $department->id ? 'active' : '' }}" 
                                            href="{{ route('departments.index', array_merge(request()->query(), ['department_id' => $department->id])) }}">
                                            {{ $department->department_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </th>

                <th>Department Head</th>    
                <th>Description</th>
                <th style="width: 10%; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($departments as $department)
                <tr>
                    <td onclick="window.location='{{ route('departments.show', $department->id) }}'">{{ $loop->iteration }}</td>
                    <td onclick="window.location='{{ route('departments.show', $department->id) }}'">{{ $department->department_name }}</td>
                    <td onclick="window.location='{{ route('departments.show', $department->id) }}'">
                        @if ($department->departmentHead)
                            @can('view-strategies')
                                <a href="{{route('users.show', $department->departmentHead->id)}}"> {{ $department->departmentHead->name }} </a>
                            @elsecan
                                {{ $department->departmentHead->name }},
                            @endcan
                        @else
                            Not Assigned To Any
                        @endif
                    </td>
                    <td onclick="window.location='{{ route('departments.show', $department->id) }}'">{{ $department->description }}</td>
                    <td class="text-center">
                        <div class="form-button-action">
                            <a href="{{ route('departments.show', $department->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $department->id }})">
                                <i class="fa fa-times"></i>
                            </button>
                            <form id="delete-form-{{ $department->id }}" action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No departments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
