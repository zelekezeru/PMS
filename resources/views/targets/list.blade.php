<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Budget</th>
                            <th class="d-flex align-items-center text-white">
                                <span class="me-2">Goal</span>
                                @if(isset($goals) && count($goals) > 0)
                                    <div class="dropdown">
                                        <i class="fa fa-chevron-down text-white px-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-filter text-white"></i>
                                        </i>
                                        <ul class="dropdown-menu custom-dropdown-menu">
                                            <li>
                                                <a class="dropdown-item {{ request('goal_id') ? '' : 'active' }}" href="{{ route('targets.index') }}">
                                                    Show All Options
                                                </a>
                                            </li>
                                            @foreach($goals as $goal)
                                                <li>
                                                    <a class="dropdown-item {{ request('goal_id') == $goal->id ? 'active' : '' }}" href="{{ route('targets.index', ['goal_id' => $goal->id]) }}">
                                                        {{ $goal->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </th>
                            @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                <th style="width: 10%; text-align: center;">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($targets as $target)
                            <tr>
                                <td onclick="window.location='{{ route('targets.show', $target->id) }}'">{{ ($targets->currentPage() - 1) * $targets->perPage() + $loop->iteration }}</td>
                                <td onclick="window.location='{{ route('targets.show', $target->id) }}'">{{ $target->name }}</td>
                                <td onclick="window.location='{{ route('targets.show', $target->id) }}'">{{ $target->budget }}</td>
                                <td onclick="window.location='{{ route('targets.show', $target->id) }}'">
                                    @if($target->goal)
                                        {{ $target->goal->name }}
                                    @endif
                                </td>
                                @if (request()->user()->hasAnyRole(['ADMIN', 'SUPER_ADMIN']))
                                    <td class="text-center">
                                        <div class="form-button-action">
                                            <a href="{{ route('targets.show', $target->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('targets.edit', $target->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $target->id }})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <form id="delete-form-{{ $target->id }}" action="{{ route('targets.destroy', $target->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No targets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>