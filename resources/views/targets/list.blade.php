<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Budget</th>
            <th class="d-flex align-items-center text-white">
                <span class="me-2">Goal</span>
                @if(isset($goals) && count($goals) > 0)
                <div class="dropdown">
                    <i class="fa fa-chevron-down text-white px-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">  <i class="fa-solid fa-filter text-white"></i> </i>

                    <ul class="dropdown-menu custom-dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('goals.index') }}">Show All Options</a></li>
                        @foreach($goals as $goal)
                            <li>
                                <a class="dropdown-item" href="{{ route('targets.index', ['goal_id' => $goal->id]) }}">
                                    {{ $goal->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </th>
            <th>Department</th>
            <th>Value</th>
            <th>Unit</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($targets as $target)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $target->name }}</td>
                <td>{{ $target->budget }}</td>
                <td>
                    @if($target->goal)
                        {{ $target->goal->name }}
                    @endif
                </td>
                <td>
                    @if($target->departments && $target->departments->count() > 0)
                        @foreach($target->departments as $department)
                            <strong>{{ $department->department_name }}</strong>,
                        @endforeach
                    @endif
                </td>
                <td>{{ $target->value }}</td>
                <td>{{ $target->unit }}</td>
                <td class="text-center">
                    <a href="{{ route('targets.show', $target->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('targets.edit', $target->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <form action="{{ route('targets.destroy', $target->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="m-1 btn  btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this target?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No targets found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
