<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Strategy Name</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($goals as $goal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $goal->strategy->name }}</td>
                <td>{{ $goal->name }}</td>
                <td>{{ $goal->description }}</td>
                <td class="text-center">
                    <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                    <a href="{{ route('goals.edit', $goal->id) }}" class="m-1 btn  btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $goal->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    
                    <form id="delete-form-{{ $goal->id }}" action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    
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
                    
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No goals found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
