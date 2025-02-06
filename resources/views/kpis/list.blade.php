<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Value</th>
                            <th>Unit</th>
                            <th>Status</th>

                            <th style="width: 10%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kpis as $kpi)
                            <tr>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $kpi->name }}</td>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $kpi->value }}</td>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $kpi->unit }}</td>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $kpi->status }}</td>

                                <td class="text-center">
                                    <div class="form-button-action">
                                        <a href="{{ route('kpis.show', $kpi->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kpis.edit', $kpi->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $kpi->id }})">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <form id="delete-form-{{ $kpi->id }}" action="{{ route('kpis.destroy', $kpi->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No KPIs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
