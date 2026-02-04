<tr data-deliverable-id="{{ $deliverable->id }}">
    <td>{{ $deliverable->id }}</td>
    <td>{{ $deliverable->name }}</td>
    <td>
        @if($deliverable->deadline)
            {{ \Carbon\Carbon::parse($deliverable->deadline)->format('M d, Y') }}
        @else
            No Deadline
        @endif
    </td>
    <td>{{ $deliverable->user->name }}</td>
    <td>
        @if ($deliverable->is_completed)
            <span class="badge-status badge-achieved">Achieved</span>
        @else
            <form action="{{ route('deliverables.status', $deliverable->id) }}" method="POST" class="status-form d-inline">
                @csrf
                @method('PUT')
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="Pending" {{ $deliverable->is_completed == null ? 'selected' : '' }}>Not Achieved!</option>
                    <option value="Achieved" {{ $deliverable->is_completed ? 'selected' : '' }}>Achieved</option>
                </select>
            </form>
        @endif
    </td>
    <td class="text-center">
        <div class="btn-group">
            <a href="{{ route('deliverables.show', $deliverable->id) }}" class="btn btn-sm btn-outline-info" title="View"><i class="fa fa-eye"></i></a>
            <a href="{{ route('deliverables.edit', $deliverable->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa fa-edit"></i></a>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $deliverable->id }})" title="Delete"><i class="fa fa-times"></i></button>
            <form id="delete-form-{{ $deliverable->id }}" action="{{ route('deliverables.destroy', $deliverable->id) }}" method="POST" style="display: none;">@csrf @method('DELETE')</form>
        </div>
    </td>
</tr>