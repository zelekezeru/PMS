<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Quarter</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="text-center" style="width: 40%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fortnights as $fortnight)
                            <tr>
                                <td onclick="window.location='{{ route('fortnights.show', $fortnight->id) }}'">{{ $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('fortnights.show', $fortnight->id) }}'">{{ $fortnight->quarter->quarter }}</td>
                                <td onclick="window.location='{{ route('fortnights.show', $fortnight->id) }}'">{{ \Carbon\Carbon::parse($fortnight->start_date)->format('M - d - Y') }}</td>
                                <td onclick="window.location='{{ route('fortnights.show', $fortnight->id) }}'">{{ \Carbon\Carbon::parse($fortnight->end_date)->format('M - d - Y') }}</td>
                                <td class="text-center">
                                    <div class="form-button-action">
                                        <a href="{{ route('fortnights.show', $fortnight->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('fortnights.edit', $fortnight->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $fortnight->id }})">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <form id="delete-form-{{ $fortnight->id }}" action="{{ route('fortnights.destroy', $fortnight->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
