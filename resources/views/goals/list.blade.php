<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th class="d-flex align-items-center">
                <span class="me-2">Strategy Name</span>
                <form method="GET" action="{{ route('goals.index') }}" id="filter-form">
                    <div class="position-relative">
                        <select name="strategy_id" class="form-select" onchange="document.getElementById('filter-form').submit();" style="padding-right: 30px;">
                            <option value="">All Strategies</option>
                            @foreach($strategies as $strategy)
                                <option value="{{ $strategy->id }}" {{ request('strategy_id') == $strategy->id ? 'selected' : '' }}>
                                    {{ $strategy->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa fa-chevron-down position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
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
