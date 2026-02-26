@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2>Visit Details</h2>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Site:</strong> <a href="{{ route('admin.sites.show', $visit->site) }}">{{ $visit->site?->name ?? 'Deleted Site' }}</a>
                    </div>
                    <div class="mb-3">
                        <strong>User:</strong> {{ $visit->user?->name ?? 'Unknown User' }}
                    </div>
                    <div class="mb-3">
                        <strong>Visit Date:</strong> {{ $visit->visited_at?->format('M d, Y') ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if ($visit->status === 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @elseif ($visit->status === 'submitted')
                            <span class="badge bg-info">Submitted</span>
                        @elseif ($visit->status === 'processed')
                            <span class="badge bg-success">Processed</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Notes:</strong> {{ $visit->notes ?? 'No notes' }}
                    </div>
                </div>
            </div>

            @if ($visit->status === 'draft')
                <div class="mt-3">
                    <form action="{{ route('admin.visits.submit', $visit) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Submit visit?')">Submit Visit</button>
                    </form>
                </div>
            @endif

            <div class="mt-3">
                @can('visit_edit')
                    @if ($visit->status === 'draft')
                        <a href="{{ route('admin.visits.edit', $visit) }}" class="btn btn-warning">Edit</a>
                    @endif
                @endcan
                {{-- @can('visit_delete')
                    <form action="{{ route('admin.visits.destroy', $visit) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                @endcan --}}
                <a href="{{ route('admin.visits.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

