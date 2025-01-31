<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Title</th>
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
                <td class="text-center">
                    <a href="{{ route('targets.show', $target->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="{{ route('targets.edit', $target->id) }}" class="m-1 btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $target->id }})">
                        <i class="fa fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $target->id }}" action="{{ route('targets.destroy', $target->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
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
