@extends('layouts.app')

@section('contents')

    <div class="container mt-3">
        <div class="card pt-5">
            <h2 class="card-header text-center">deliverable Details</h2>
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('deliverables.index') }}">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>deliverable Name:</th>
                        <td>{{ $deliverable->deliverable_name }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $deliverable->description }}</td>
                    </tr>
                    <tr>
                        <th>deliverable Head:</th>
                        <td>
                            @if ($deliverable->deliverableHead)
                                @can('view-strategies')
                                    <a href="{{route('users.show', $deliverable->deliverableHead->id)}}"> {{ $deliverable->deliverableHead->name }} </a>
                                @elsecan
                                    {{ $deliverable->deliverableHead->name }},
                                @endcan
                            @else
                                Not Assigned To Any
                            @endif

                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('deliverables.edit', $deliverable->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <button type="button" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $deliverable->id }}" action="{{ route('deliverables.destroy', $deliverable->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

            </div>
        </div>


        @if ($deliverable->users)

            @php
                $users = $deliverable->users()->paginate(15);
            @endphp

            <div class="card-header">
                <h3 class="card-title mb-5">Users of this deliverable</h3>
            </div>

            @include('users.list')
            
            <div class="mt-3">
                {{ $tasks->appends(request()->query())->links() }}
            </div>

        @else
            <div class="alert alert-warning mt-3">
                <p>No users found for this deliverable.</p>
            </div>
        @endif
    </div>

@endsection
