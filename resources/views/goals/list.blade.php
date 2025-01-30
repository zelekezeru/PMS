<style>
    .custom-dropdown-menu {
        background-color: rgb(26, 32, 53); /* Matches the dark background of the table header */
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
            <th class="d-flex align-items-center text-white position-relative">
                <span class="me-2">Strategy Name</span>
                <form method="GET" action="{{ route('goals.index') }}" id="filter-form">
                    <div class="dropdown">
                        <i class="fa fa-chevron-down text-white px-3" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                        <ul class="dropdown-menu custom-dropdown-menu mt-4">
                            <li><a class="dropdown-item" href="{{ route('goals.index') }}">All Strategies</a></li>
                            @foreach($strategies as $strategy)
                                <li>
                                    <a class="dropdown-item" href="{{ route('goals.index', ['strategy_id' => $strategy->id]) }}">
                                        {{ $strategy->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($goals as $goal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $goal->strategy->name }} </td>
                <td>{{ $goal->name }}</td>
                <td>{{ $goal->description }}</td>
                <td class="text-center">
                    <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('goals.edit', $goal->id) }}" class="m-1 btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="m-1 btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this goal?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
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
