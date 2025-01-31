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

                            @if($kpis->first()->task_id != null)
                                <th>Task</th>
                            @elseif($kpis->first()->target_id != null)
                                <th>Target</th>
                            @endif

                            <th style="width: 10%; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kpis as $kpi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kpi->name }}</td>
                                <td>{{ $kpi->value }}</td>
                                <td>{{ $kpi->unit }}</td>

                                @if($kpi->task_id != null)
                                    <td>{{ $kpi->task->name }}</td>
                                @elseif($kpi->target_id != null)
                                    <td>{{ $kpi->target->name }}</td>
                                @endif

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
                                <td colspan="4" class="text-center">No kpis found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
