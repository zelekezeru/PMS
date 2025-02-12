<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Year</th>
                            <th>Quarter</th>
                            <th>Fortnight</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $index => $day)
                            <tr>
                                <td onclick="window.location='{{ route('days.show', $day->id) }}'">{{ $days->firstItem() + $index }}</td>
                                <td onclick="window.location='{{ route('days.show', $day->id) }}'">{{ $day->fortnight->quarter->year->year }}</td>
                                <td onclick="window.location='{{ route('days.show', $day->id) }}'">{{ $day->fortnight->quarter->quarter }}</td>
                                <td onclick="window.location='{{ route('days.show', $day->id) }}'">
                                    {{ \Carbon\Carbon::parse($day->fortnight->start_date)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($day->fortnight->end_date)->format('M d, Y') }}
                                </td>
                                <td onclick="window.location='{{ route('days.show', $day->id) }}'">{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <div class="form-button-action">
                                        <a href="{{ route('days.show', $day->id) }}" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        @if(!request()->user()->hasRole('DEPARTMENT_HEAD'))
                                            <a href="{{ route('days.edit', $day->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete({{ $day->id }})">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <form id="delete-form-{{ $day->id }}" action="{{ route('days.destroy', $day->id) }}" method="POST" style="display: none;">
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
