<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Pillar Name</th>
            <th>Strategy Name</th>
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
                    <a href="{{ route('strategies.show', $strategy->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> View
                    </a>
                    <a href="{{ route('strategies.edit', $strategy->id) }}" class="m-1 btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $strategy->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $strategy->id }}" action="{{ route('strategies.destroy', $strategy->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <script>
                        function confirmDelete(strategyId) {
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Once deleted, this strategy cannot be recovered!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + strategyId).submit();
                                }
                            });
                        }
                    </script>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No strategies found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
