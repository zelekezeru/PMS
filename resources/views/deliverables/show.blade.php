@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">Deliverable Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ url()->previous() }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Deliverable Name:</th>
                        <td>{{ $deliverable->name }}</td>
                    </tr>
                    <tr>
                        <th>Created by:</th>
                        <td>{{ $deliverable->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        
                        @if ($deliverable->is_completed)
                            <td><span class="badge bg-success">Achieved</span></td>     
                        @else
                            <td>
                                <form action="{{ route('deliverables.status', $deliverable->id) }}" method="POST" enctype="multipart/form-data" class="status-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" style="border: 2px solid black;"  class="form-control @error('status') is-invalid @enderror" onchange="this.form.submit()">
                                        <option value="Pending" {{ $deliverable->is_completed == null ? 'selected' : '' }}>Not Achieved!</option>
                                        <option value="Achieved!" {{ $deliverable->is_completed == 'Achieved' ? 'selected' : '' }}>Achieved!</option>
                                    </select>
                                </form>
                                @error('status')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <th>Deadline:</th>
                        <td>
                            @if ($deliverable->deadline)
                                {{ \Carbon\Carbon::parse($deliverable->deadline)->format('M d, Y') }}
                            @else
                                No Deadline
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Comment:</th>
                        <td>
                            @if ($deliverable->is_completed)
                                @if ($deliverable->comment)
                                    {{ $deliverable->comment }}
                                @else                               
                                    <button type="button" class="btn btn-success ms-3 btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#commentDeliverableModal">
                                        <i class="fas fa-plus"></i> Comment On Deliverable
                                    </button>
                                @endif
                            @else
                                <span class="badge bg-success">Not Achieved</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Commented By:</th>
                        <td>
                            @if ($deliverable->is_completed)
                                @if ($deliverable->comment)
                                    {{ $deliverable->commented_by }}
                                @endif
                            @else
                                <span class="badge bg-success">Not Achieved</span>
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- Make sure the User is SUPER-ADMIN or ADMIN --}}
                @hasanyrole(['SUPER_ADMIN', 'ADMIN'])
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('deliverables.edit', $deliverable->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $deliverable->id }})">
                            <i class="fas fa-trash"></i> Delete
                        </button>

                        <form id="delete-form-{{ $deliverable->id }}" action="{{ route('deliverables.destroy', $deliverable->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endhasanyrole

            </div>
        </div>
    </div>

@endsection


{{-- Deliverable comment form modal --}}

<div class="modal fade" id="commentDeliverableModal" tabindex="-1" aria-labelledby="commentDeliverableLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentDeliverableLabel">Comment on Deliverable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('deliverables.update', ['deliverable' => $deliverable->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="name" class="form-label">Deliverable Title</label>
                        <p class="text-secondary">{{ $deliverable->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" name="comment" rows="4" required></textarea>
                    </div>

                {{-- Auth::user->id --}}
                <input type="hidden" name="commented_by" value="{{ Auth::user()->name }}">
                <input type="hidden" name="name" value="{{ $deliverable->name }}" type="text">


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>