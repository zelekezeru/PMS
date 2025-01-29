<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Pillar</th>
            <th>Strategy</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($strategies as $strategy)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $strategy->pilar_name }}</td>
                <td>{{ $strategy->name }}</td>
                <td>{{ $strategy->description }}</td>
                <td class="text-center">
                    <a href="{{ route('strategies.show', $strategy->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('strategies.edit', $strategy->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <a href="{{ route('strategies.show', $strategy->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-book"></i> Show</a>
                    <form action="{{ route('strategies.destroy', $strategy->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="m-1 btn  btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this strategy?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No strategies found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
