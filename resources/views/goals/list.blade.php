<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th class="d-flex align-items-center text-white">
                    <span class="me-2">Strategy </span>
                    @if(isset($strategies) && count($strategies) > 0)
                        <div class="dropdown">
                            <i class="fa fa-chevron-down text-white px-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">  <i class="fa-solid fa-filter text-white"></i> </i>
    
                            <ul class="dropdown-menu custom-dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('goals.index') }}">Show All Options</a></li>
                                @foreach($strategies as $strategy)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('goals.index', ['strategy_id' => $strategy->id]) }}">
                                            {{ $strategy->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </th>
                @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                    <th style="width: 10%; text-align: center;">Actions</th>
                    
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($goals as $goal)
                <tr>
                    <td onclick="window.location='{{ route('goals.show', $goal->id) }}'">{{ ($goals->currentPage() - 1) * $goals->perPage() + $loop->iteration }}</td>
                    <td onclick="window.location='{{ route('goals.show', $goal->id) }}'">{{ $goal->name }}</td>
                    <td onclick="window.location='{{ route('goals.show', $goal->id) }}'">
                        @if($goal->strategy)
                            {{ $goal->strategy->name }}
                        @endif
                    </td>
                    @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                        <td class="text-center">
                            <div class="form-button-action">
                                <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('goals.edit', $goal->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $goal->id }})">
                                    <i class="fa fa-times"></i>
                                </button>
                                <form id="delete-form-{{ $goal->id }}" action="{{ route('goals.destroy', $goal->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No goals found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
