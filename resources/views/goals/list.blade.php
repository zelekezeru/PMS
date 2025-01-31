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

<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th class="d-flex align-items-center text-white">
                <span class="me-2">Strategy </span>
                @if(isset($strategies) && count($strategies) > 0)
                    <div class="dropdown">
                        <i class="fa fa-chevron-down text-white px-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">  <i class="fa-solid fa-filter text-white"></i> </i>

                        <ul class="dropdown-menu custom-dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('goals.index') }}">Show All Options</a></li>
                            @foreach($strategies as $strategy)
                                <li>
                                    <a class="dropdown-item" href="{{ route('goals.index', ['strategy_id' => $strategy->id]) }}">
                                        {{ $strategy->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($goals as $goal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $goal->name }}</td>
                <td>
                    @if($goal->strategy)
                        {{ $goal->strategy->name }}
                    @endif
                </td>
                <td>{{ $goal->description }}</td>
                <td class="text-center">
                    <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="{{ route('goals.edit', $goal->id) }}" class="m-1 btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $goal->id }})">
                        <i class="fa fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $goal->id }}" action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No goals found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script>
    function confirmDelete(goalId) {
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, this goal cannot be recovered!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + goalId).submit();
            }
        });
    }
</script>
