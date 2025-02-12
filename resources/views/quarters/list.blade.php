<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Quarter</th>
                            <th>Year</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quarters as $quarter)
                            <tr>
                                <td onclick="window.location='{{ route('quarters.show', $quarter->id) }}'">{{ $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('quarters.show', $quarter->id) }}'">{{ $quarter->quarter }}</td>
                                <td onclick="window.location='{{ route('quarters.show', $quarter->id) }}'">{{ optional($quarter->year)->year ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="form-button-action">
                                        <a href="{{ route('quarters.show', $quarter->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                                            <a href="{{ route('quarters.edit', $quarter->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $quarter->id }})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <form id="delete-form-{{ $quarter->id }}" action="{{ route('quarters.destroy', $quarter->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
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
