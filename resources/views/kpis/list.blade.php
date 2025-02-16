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
                            <th>Status</th>
                            
                            @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']))
                                <th>Approvals</th>
                            @endif
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kpis as $kpi)
                            <tr>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $kpi->name }}</td>
                                <td onclick="window.location='{{ route('kpis.show', $kpi->id) }}'">{{ $kpi->value }}</td>
                                
                                @if ($kpi->status != 'Completed')
                                    
                                    <td>
                                        <form action="{{ route('kpis.status', $kpi->id) }}" method="POST" enctype="multipart/form-data" class="status-form">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" style="border: 2px solid black;"  class="form-control @error('status') is-invalid @enderror" onchange="this.form.submit()">
                                                <option value="Pending" {{ $kpi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Progress" {{ $kpi->status == 'Progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ $kpi->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </form>
                                        @error('status')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                
                                @else
                                    <td class="badge badge-success me-4">Completed !</td>
                                @endif

                                @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']) && $kpi->status == 'Completed')

                                    <td class="text-center">
                                        <div class="form-button-action">

                                        @if ($kpi->approved_by)
                                            <p class="badge badge-success me-4" >Approved !</p>
                                        @else
                                            <a href="{{ route('kpis.approve', $kpi->id) }}" class="btn btn-link btn-info " data-bs-toggle="tooltip" title="Approve">
                                                <p class="badge badge-warning mr-3"><i class="fa-solid fa-check"></i> Approve!</p>
                                            </a>
                                        @endif
                                @elseif (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']))
                                    
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            <p class="badge badge-info me-4" >Wait for Completion!</p>
                                        </div>
                                    </td>

                                @endif

                                        @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']) && $kpi->approved_by != null)

                                            @if ($kpi->confirmed_by)
                                                <p class="badge badge-success me-4">Confirmed !</p>
                                            @else
                                                <a href="{{ route('kpis.confirm', $kpi->id) }}" class="btn btn-link btn-info " data-bs-toggle="tooltip" title="Confirm">
                                                    <p class="badge badge-warning"><i class="fa-solid fa-list-check"></i> Confirm </p>
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    @elseif (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))

                                            <p class="badge badge-info me-4" >Wait for Approval!</p>
                                        </td>
                                    </div>
                                </td>

                                    @else
                                        </div>
                                    </td>

                                    @endif                                   
                
                                    @if (Auth::user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN', 'DEPARTMENT_HEAD']) || $kpi->status != 'Completed')
                                    

                                        @if(Auth::user()->hasAnyRole(['DEPARTMENT_HEAD'])  && $kpi->approved_by != null)
                                            <td class="text-center">
                                                <div class="form-button-action">
                                                    <p class="badge badge-info me-4">KPI Submitted</p>
                                                </div>
                                            </td>

                                        @else

                                            <td>
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
                                    
                                    @endif

                                @else
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            <p class="badge badge-info me-4">KPI Submitted</p>
                                        </div>
                                    </td>
                                @endif
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
