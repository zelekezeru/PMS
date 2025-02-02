<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Pillar</th>
                            <th>Strategic Goal</th>
                            <th>Strategic Objective</th>
                            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                <th style="width: 10%; text-align: center;">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($strategies as $strategy)
                            <tr>
                                <td onclick="window.location='{{ route('strategies.show', $strategy->id) }}'">{{ $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('strategies.show', $strategy->id) }}'">{{ $strategy->pillar_name }}</td>
                                <td onclick="window.location='{{ route('strategies.show', $strategy->id) }}'">{{ $strategy->name }}</td>
                                <td onclick="window.location='{{ route('strategies.show', $strategy->id) }}'">{{ $strategy->description }}</td>
                                @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            <a href="{{ route('strategies.show', $strategy->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('strategies.edit', $strategy->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $strategy->id }})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <form id="delete-form-{{ $strategy->id }}" action="{{ route('strategies.destroy', $strategy->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No strategies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

